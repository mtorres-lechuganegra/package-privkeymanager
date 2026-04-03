<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('priv_key_group_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('priv_key_id')
                  ->constrained('priv_keys')
                  ->cascadeOnDelete();
            $table->foreignId('priv_key_group_id')
                  ->constrained('priv_key_groups')
                  ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['priv_key_id', 'priv_key_group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('priv_key_group_assignments');
    }
};
