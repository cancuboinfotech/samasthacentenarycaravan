<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caravan_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caravan_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->decimal('speed', 8, 2)->nullable();
            $table->decimal('heading', 5, 2)->nullable();
            $table->timestamp('tracked_at');
            $table->timestamps();

            $table->index('caravan_id');
            $table->index('tracked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caravan_locations');
    }
};

