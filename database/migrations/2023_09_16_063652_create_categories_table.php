<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('section_id')
                ->index()
                ->constrained('sections')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('parent_id')
                ->index()
                ->nullable()
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();;
            $table->string('slug')->unique();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('categories');
        }
    }
};
