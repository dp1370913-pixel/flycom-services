<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages_conversation', function (Blueprint $table) {
            $table->id('id_message');
            $table->foreignId('id_conversation')->constrained('conversations', 'id_conversation')->onDelete('cascade');
            $table->enum('expediteur', ['Client', 'IA', 'Humain']);
            $table->text('contenu');
            $table->dateTime('horodatage')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages_conversation');
    }
};