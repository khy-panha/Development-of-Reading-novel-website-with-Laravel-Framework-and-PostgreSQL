<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // foreign key to books table
            $table->string('part'); // episode/part title
            $table->text('story'); // whole story content
            $table->enum('status', ['1', '2'])->default('1'); // status of the story (on-going or end)
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
