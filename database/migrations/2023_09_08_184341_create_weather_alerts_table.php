<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'wx_id' => $alert['properties']['id'],
     * 'sender' => $alert['properties']['senderName'],
     * 'message_type' => $alert['properties']['messageType'],
     * 'severity' => $alert['properties']['severity'],
     * 'certainty' => $alert['properties']['certainty'],
     * 'urgency' => $alert['properties']['urgency'],
     * 'event' => $alert['properties']['event'],
     * 'headline' => $alert['properties']['headline'],
     * 'description' => $alert['properties']['description'],
     * 'instruction' => $alert['properties']['instruction'],
     * 'response' => $alert['properties']['response'],
     * 'ingest_id' => $ingest->id,
     * 'sent_at' => $alert['properties']['sent'],
     * 'effective_at' => $alert['properties']['effective'],
     * 'expires_at' => $alert['properties']['expires'],
     */
    public function up(): void
    {
        Schema::create('weather_alerts', function (Blueprint $table) {
            $table->id();

            $table->string('wx_id');
            $table->string('sender');
            $table->string('message_type');
            $table->string('severity')->nullable();
            $table->string('certainty')->nullable();
            $table->string('urgency')->nullable();
            $table->string('event');
            $table->string('headline');
            $table->text('description');

            $table->string('instruction')->nullable();
            $table->string('response')->nullable();

            $table->timestamp('sent_at');
            $table->timestamp('effective_at');
            $table->timestamp('expires_at');

            $table->bigInteger('ingest_id')->unsigned();

            $table->foreign('ingest_id')
                ->references('id')
                ->on('ingests')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_alerts');
    }
};
