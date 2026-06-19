<?php
/**
 * Script d'installation de la base de données JobAI
 * À utiliser localement ou sur un serveur en ligne
 */

// Configuration
$db_host = 'localhost';
$db_name = 'jobai_db';
$db_user = 'root';
$db_pass = '';

// Créer la base de données
try {
    // Connexion sans base de données pour créer la DB
    $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Base de données '$db_name' créée ou déjà existante.\n";
    
    // Se connecter à la base créée
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Lire et exécuter le fichier SQL
    $sql_file = __DIR__ . '/jobai_database.sql';
    
    if (!file_exists($sql_file)) {
        die("❌ Erreur : Le fichier 'jobai_database.sql' n'existe pas à l'adresse : $sql_file\n");
    }
    
    $sql = file_get_contents($sql_file);
    // Supprimer les commentaires SQL pour éviter que des requêtes soient ignorées
    $sql = preg_replace('/--.*$/m', '', $sql);
    
    // Exécuter les requêtes
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($statements as $statement) {
        if (!empty($statement) && strpos($statement, '--') !== 0) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                echo "⚠ Requête non exécutée : " . substr($statement, 0, 50) . "...\n";
                echo "   Raison : " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "✓ Base de données JobAI installée avec succès !\n";
    echo "\n=== Résumé ===\n";
    
    // Vérification
    $count_entreprises = $pdo->query("SELECT COUNT(*) as count FROM entreprises")->fetch(PDO::FETCH_ASSOC)['count'];
    $count_offres = $pdo->query("SELECT COUNT(*) as count FROM offres")->fetch(PDO::FETCH_ASSOC)['count'];
    
    echo "✓ Entreprises créées : $count_entreprises\n";
    echo "✓ Offres créées : $count_offres\n";
    echo "\n✓ Installation terminée avec succès !\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "\n";
    echo "\nVérifiez :\n";
    echo "- Le serveur MySQL est en cours d'exécution\n";
    echo "- L'identifiant est correct (user: '$db_user')\n";
    echo "- Le mot de passe est correct\n";
    exit(1);
}
?>
