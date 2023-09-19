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
        Schema::create('distribution_list_member', function (Blueprint $table) {
            $table->integer('account_id');
            $table->bigInteger('distribution_list_id')->unsigned();

            $table->foreign('distribution_list_id')
                ->references('id')
                ->on('distribution_lists')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_list_member');
    }
};
