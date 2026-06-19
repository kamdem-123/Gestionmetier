<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajoute posted_by_user_id pour tracer qui a soumis l'offre
        if (!Schema::hasColumn('offres', 'posted_by_user_id')) {
            Schema::table('offres', function (Blueprint $table) {
                $table->unsignedBigInteger('posted_by_user_id')->nullable()->after('status');
            });
        }

        // Met les offres sans statut en 'active' pour ne pas casser l'existant
        DB::table('offres')->whereNull('status')->update(['status' => 'active']);
    }

    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->dropColumn('posted_by_user_id');
        });
    }
};
