<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * return new Member([
     * 'name'              => $row['account_name'],
     * 'status'            => $row['current_status'],
     * 'email'             => $row['email'],
     * 'email_key'         => $row['email'],
     * 'cell_phone'        => $this->format_number($row['cell_phone']),
     * 'second_email'      => $row['second_email'],
     * 'second_email_key'  => $row['second_email'],
     * 'county'            => $county = strtoupper(str_replace('St.','Saint', str_replace(' County','',$row['county_of_residence']))),
     * 'territory'         => $this->getTerritory($county),
     * 'chapter'           => $this->getChapter($county),
     * 'member_number'     => $row['member_number'],
     * 'account_id'        => $row['account_id'],
     * 'availability'      => $row['geog_availability'],
     * 'available_now'     => ($row['available_now'] === "Yes") ? true : false
     * ]);
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->text('name');
            $table->string('status');

            $table->text('email');
            $table->string('email_key');

            $table->text('cell_phone');

            $table->text('second_email')->nullable();
            $table->string('second_email_key')->nullable();

            $table->string('county');
            $table->integer('territory')->nullable();
            $table->string('chapter')->nullable();

            $table->string('availability')->nullable();
            $table->boolean('available_now');

            $table->integer('member_number');
            $table->integer('account_id');

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
        Schema::dropIfExists('members');
    }
};
