<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Chatbot memory: one row per visitor (profile + conversation state that
 * survives across visits) and every message exchanged.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('phone', 20)->nullable();
            $table->json('profile')->nullable();   // city, media interests, goal, audience, budget, duration
            $table->json('state')->nullable();     // last topic, brainstorm stage, pending question
            $table->unsignedInteger('visits')->default(1);
            $table->boolean('lead_saved')->default(false);
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('chat_visitor_id')->index();
            $table->string('role', 10);            // user | bot
            $table->text('body');
            $table->json('meta')->nullable();      // intent, matched knowledge ids, page
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_visitors');
    }
};
