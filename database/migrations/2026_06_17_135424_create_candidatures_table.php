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
        if (!Schema::hasTable('candidatures')) {
            Schema::create('candidatures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('offre_id')->constrained('offres')->onDelete('cascade');
                $table->decimal('score_matching', 5, 2)->nullable();
                $table->enum('statut', ['en_attente', 'vue', 'acceptee', 'refusee'])->default('en_attente');
                $table->boolean('notif_recruteur_envoyee')->default(false);
                $table->boolean('notif_candidat_envoyee')->default(false);
                $table->timestamps();

                // Un candidat ne peut postuler qu'une seule fois par offre
                $table->unique(['user_id', 'offre_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
