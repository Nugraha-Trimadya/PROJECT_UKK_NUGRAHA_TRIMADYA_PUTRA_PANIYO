<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->string('borrower_name');
            $table->string('borrower_phone')->nullable();
            $table->text('note')->nullable();
            $table->date('lend_date');
            $table->date('due_date')->nullable();
            $table->timestamp('return_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};
