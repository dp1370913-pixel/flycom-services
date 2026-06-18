<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_client');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('telephone', 20)->unique(); // Index unique pour éviter les doublons de contacts
            $table->string('email', 150)->nullable();
            $table->string('entreprise', 150)->nullable();
            $table->text('adresse')->nullable();
            $table->enum('type_contact', ['Prospect', 'Client', 'Partenaire'])->default('Prospect');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};