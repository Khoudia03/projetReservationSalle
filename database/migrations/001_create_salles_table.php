<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('salles', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('batiment', 100);
            $table->integer('capacite');
            $table->string('type', 30);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('salles');
    }
};