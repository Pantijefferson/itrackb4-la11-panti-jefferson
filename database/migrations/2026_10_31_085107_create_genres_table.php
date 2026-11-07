<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        
        Schema::table('comics', function (Blueprint $table) {
            if (!Schema::hasColumn('comics', 'genre_id')) {
                $table->foreignId('genre_id')->constrained();
            }
        });
    }

    public function down(): void
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->dropConstrainedForeignId('genre_id');
        });

        Schema::dropIfExists('genres');
    }
};