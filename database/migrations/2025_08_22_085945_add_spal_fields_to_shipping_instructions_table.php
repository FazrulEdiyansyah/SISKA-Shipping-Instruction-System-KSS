<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_instructions', function (Blueprint $table) {
            $table->string('spal_number')->nullable()->after('remarks');
            $table->string('spal_document')->nullable()->after('spal_number');
            $table->timestamp('completed_at')->nullable()->after('spal_document');
        });
    }

    public function down(): void
    {
        Schema::table('shipping_instructions', function (Blueprint $table) {
            $table->dropColumn(['spal_number', 'spal_document', 'completed_at']);
        });
    }
};