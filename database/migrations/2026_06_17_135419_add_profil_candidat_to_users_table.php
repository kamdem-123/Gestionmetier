<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'titre_poste')) {
                $table->string('titre_poste')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'competences')) {
                $table->text('competences')->nullable()->after('titre_poste');
            }
            if (!Schema::hasColumn('users', 'cv_texte')) {
                $table->text('cv_texte')->nullable()->after('competences');
            }
            if (!Schema::hasColumn('users', 'cv_path')) {
                $table->string('cv_path')->nullable()->after('cv_texte');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['titre_poste', 'competences', 'cv_texte', 'cv_path']);
        });
    }
};
