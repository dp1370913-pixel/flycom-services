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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Équivalent de id_user (clé primaire auto-incrémentée)
            $table->string('nom_user', 100);
            $table->string('prenom_user', 100);
            $table->string('email', 150)->unique(); // Équivalent de email_user (identifiant unique de connexion)
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Équivalent de mot_de_passe_hash (géré de manière hachée et sécurisée)
            
            // Ajout de vos contraintes de rôles d'accès du CRM (Admin, Commercial, Lecture, System_Bot)
            $table->enum('role', ['Admin', 'Commercial', 'Lecture', 'System_Bot'])->default('Commercial');
            
            $table->dateTime('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};