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
        Schema::table('distribution_lists', function(Blueprint $table) {
            $table->boolean('include_primary')->default(false);
            $table->boolean('include_backup')->default(false);
            $table->boolean('include_supervisor')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
