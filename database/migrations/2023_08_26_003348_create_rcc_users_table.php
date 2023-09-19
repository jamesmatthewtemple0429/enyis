<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'account_id'        => $row['vcn'],
     * 'role'              => $row['job'],
     * 'is_active'         => $row['active'],
     * 'last_login'        => new Carbon($row['last_login']),
     * 'ingest_id'         => $this->ingest->id
     */
    public function up(): void
    {
        Schema::create('rcc_users', function (Blueprint $table) {
            $table->id();

            $table->integer('account_id')->nullable();
            $table->string('role');
            $table->boolean('is_active');
            $table->timestamp('last_login');

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
        Schema::dropIfExists('rcc_users');
    }
};
