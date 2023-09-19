<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'entered_at' => $request->date1,
     * 'county'     => $request->county1,
     * 'name'      => $request->name1,
     * 'summary'   => $request->summary1,
     * 'key'       => hash('sha256',$request->date1 . ":" . $request->name1)
     */
    public function up(): void
    {
        Schema::create('initial_incident_reports', function (Blueprint $table) {
            $table->id();

            $table->timestamp('entered_at')->nullable();
            $table->string('county')->nullable();
            $table->string('name')->nullable();
            $table->text('summary')->nullable();
            $table->string('key');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initial_incident_reports');
    }
};
