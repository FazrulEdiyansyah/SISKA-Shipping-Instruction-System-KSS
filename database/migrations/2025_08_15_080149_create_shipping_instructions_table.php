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
        Schema::create('shipping_instructions', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('to');
            $table->string('tugbarge');
            $table->string('flag');
            $table->string('vessel_name')->nullable();
            $table->date('vessel_arrived')->nullable();
            $table->string('vessel_arrived_note')->nullable();
            $table->string('shipper');
            $table->string('consignee');
            $table->text('notify_address');
            $table->string('port_loading');
            $table->string('port_discharging');
            $table->string('commodities');
            $table->string('quantity');
            $table->date('laycan_start');
            $table->date('laycan_end');
            $table->string('place');
            $table->date('date');
            $table->string('signed_by');
            $table->string('remarks')->nullable();
            $table->string('project_type')->default('default');
            $table->string('mra_number')->nullable();
            $table->string('mra_rab_document')->nullable();
            $table->string('spal_number')->nullable();
            $table->string('spal_document')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_instructions');
    }
};
