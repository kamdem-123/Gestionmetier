# Base de Données JobAI - Guide d'Installation

## 📋 Fichiers fournis

- **jobai_database.sql** : Script SQL complet (tables + données de démo)
- **install.php** : Script PHP automatisé pour installer la BD
- **README.md** : Ce fichier

---

## 🚀 Installation Locale (WAMP/XAMPP)

### Méthode 1 : Utiliser le script PHP (Recommandé)

1. **Accéder au script d'installation**
   ```
   http://localhost/gestionmetier/metier/database/install.php
   ```

2. **Attendre le message de succès** ✓

3. **Vérifier les logs PhpMyAdmin**
   - Allez sur http://localhost/phpmyadmin
   - Base `jobai_db` devrait être créée

### Méthode 2 : PhpMyAdmin (Manuel)

1. Ouvrez **PhpMyAdmin**
2. Créez une nouvelle base : `jobai_db` (UTF-8)
3. Allez à l'onglet **Importer**
4. Sélectionnez le fichier **jobai_database.sql**
5. Cliquez **Exécuter**

### Méthode 3 : Ligne de commande MySQL

```bash
mysql -u root -p < database/jobai_database.sql
```

---

## 🌐 Installation sur Serveur en Ligne

### Sur cPanel/Plesk

1. **Via PhpMyAdmin en ligne**
   - Connectez-vous à votre panel
   - Ouvrez PhpMyAdmin
   - Importez `jobai_database.sql`

2. **Via FTP + Script PHP**
   - Uploadez les 2 fichiers : `jobai_database.sql` et `install.php`
   - Accédez via navigateur : `https://votresite.com/database/install.php`

3. **Personnaliser les identifiants** (Si différents de root)
   - Éditez `install.php` ligne 7-10 avec vos identifiants

### Exemple avec serveur en ligne

```php
$db_host = 'localhost';        // Généralement 'localhost'
$db_name = 'votredb_jobai';    // Ou celui fourni par l'hébergeur
$db_user = 'votredb_user';     // Votre utilisateur DB
$db_pass = 'votre_mot_de_passe'; // Votre mot de passe
```

---

## 📊 Structure de la Base de Données

### Table : `entreprises`
```sql
- id (INT, PRIMARY KEY)
- nom (VARCHAR, UNIQUE)
- secteur (VARCHAR)
- email_contact (VARCHAR)
- telephone (VARCHAR)
- website (VARCHAR)
- date_creation (TIMESTAMP)
- created_at / updated_at
```

### Table : `offres`
```sql
- id (INT, PRIMARY KEY)
- titre (VARCHAR)
- entreprise_id (INT, FOREIGN KEY)
- type_contrat (VARCHAR)
- mode_travail (VARCHAR)
- localisation (VARCHAR)
- ville (VARCHAR)
- pays (VARCHAR)
- description (LONGTEXT)
- competences (TEXT)
- salaire_min / salaire_max (DECIMAL)
- devise (VARCHAR)
- periode_salaire (VARCHAR)
- date_limite_candidature (DATE)
- date_publication (DATE)
- status (VARCHAR)
- salary_eur / salary_type (Pour conversions)
- created_at / updated_at
```

---

## 🔗 Modifier la Connexion en Production

Une fois la BD créée, mettez à jour votre configuration Laravel :

### `config/database.php`
```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'jobai_db'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
],
```

### `.env`
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=jobai_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📝 Données de Démo Incluses

✓ **8 Entreprises**
✓ **8 Offres d'emploi** (Variées par pays et devises)
✓ **Tests de conversion de devises**

---

## ⚠️ Dépannage

### Erreur : "Base de données non trouvée"
- Vérifiez que MySQL fonctionne
- Vérifiez les identifiants dans `install.php`

### Erreur : "Permission denied"
- Sur un serveur, vérifiez les permissions du dossier `database/`

### Erreur : "Fichier SQL non trouvé"
- Assurez-vous que `jobai_database.sql` est dans le même dossier que `install.php`

---

## 📤 Exporter la Base (Sauvegarde)

### Depuis PhpMyAdmin
1. Sélectionnez la base `jobai_db`
2. Onglet **Exporter**
3. Format SQL → **Télécharger**

### Depuis la CLI MySQL
```bash
mysqldump -u root -p jobai_db > jobai_backup.sql
```

---

## 🎯 Prochaines Étapes

1. ✓ Base créée
2. Créer les modèles Eloquent (Laravel)
3. Créer les contrôleurs pour offres/entreprises
4. Adapter les routes existantes
5. Tester les requêtes de recherche

---

**Créé le 2026-06-15 | Version 1.0**
