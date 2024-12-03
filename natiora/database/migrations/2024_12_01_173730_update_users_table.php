<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('actif'); // Statut de l'utilisateur
            $table->timestamp('last_login_at')->nullable(); // Dernière connexion
            $table->date('birth_date')->nullable(); // Date de naissance
            $table->enum('gender', ['Homme', 'Femme', 'Autre'])->nullable(); // Genre
            $table->json('preferences')->nullable(); // Préférences utilisateur
            $table->softDeletes(); // Champ deleted_at pour SoftDeletes
            $table->unsignedBigInteger('company_id')->nullable(); // ID de l'entreprise
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'last_login_at',
                'birth_date',
                'gender',
                'preferences',
                'deleted_at',
                'company_id',
            ]);
        });
    }
}

