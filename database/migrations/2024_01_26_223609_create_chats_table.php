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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time');
            $table->foreignId('send_by')->nullable(false)->constrained('users');
            $table->foreignId('send_to')->nullable(false)->constrained('users');
            $table->text('message');
            $table->enum('message_type', ['text', 'attachment'])->nullable(false)->default('text');
            $table->boolean('is_received')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
