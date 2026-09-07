<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('salle_id')
                ->constrained('salles');

            $table->string('responsable', 120);
            $table->string('email', 255);
            $table->string('motif', 255);
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('statut', 20)->default('confirmée');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('reservations');
    }
};