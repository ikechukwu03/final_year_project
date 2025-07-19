<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finalist_id')->constrained()->onDelete('cascade');
            $table->string('project_title');
            $table->string('project_file');
            $table->string('code_file')->nullable();
            $table->text('abstract')->nullable();
            $table->year('year'); // pull from finalist
            $table->timestamps();
            $table->string('category')->nullable(); // optional for filtering
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
