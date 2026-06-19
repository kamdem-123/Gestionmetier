<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier l'enum pour ajouter entretien_programme
        DB::statement("ALTER TABLE candidatures MODIFY COLUMN statut ENUM('en_attente','vue','acceptee','refusee','entretien_programme') DEFAULT 'en_attente'");

        Schema::table('candidatures', function (Blueprint $table) {
            if (!Schema::hasColumn('candidatures', 'entretien_date')) {
                $table->date('entretien_date')->nullable()->after('notif_candidat_envoyee');
            }
            if (!Schema::hasColumn('candidatures', 'entretien_heure')) {
                $table->time('entretien_heure')->nullable()->after('entretien_date');
            }
            if (!Schema::hasColumn('candidatures', 'note_employeur')) {
                $table->text('note_employeur')->nullable()->after('entretien_heure');
            }
        });
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE candidatures MODIFY COLUMN statut ENUM('en_attente','vue','acceptee','refusee') DEFAULT 'en_attente'");
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn(['entretien_date', 'entretien_heure', 'note_employeur']);
        });
    }
};
