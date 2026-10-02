<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('issues', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')
              ->constrained('students')
              ->onDelete('restrict');
        $table->foreignId('book_copy_id')
              ->constrained('book_copies')
              ->onDelete('restrict');
        $table->foreignId('issued_by')
              ->constrained('users')
              ->onDelete('restrict');
        $table->timestamp('issued_at');
        $table->date('due_date');
        $table->timestamp('returned_at')->nullable();
        $table->foreignId('returned_by')
              ->nullable()
              ->constrained('users')
              ->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
