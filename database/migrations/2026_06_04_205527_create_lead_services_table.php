<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_services', function (Blueprint $table) {
            $table->foreignId('id_lead')->constrained('leads', 'id_lead')->onDelete('cascade');
            $table->foreignId('id_service')->constrained('services', 'id_service')->onDelete('restrict');
            $table->primary(['id_lead', 'id_service']); // Clé primaire composite
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_services');
    }
};