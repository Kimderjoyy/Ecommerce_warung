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
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom payment_due jika belum ada
            if (!Schema::hasColumn('orders', 'payment_due')) {
                $table->timestamp('payment_due')->nullable()->after('payment_status');
            }
            
            // Tambah kolom payment_proof jika belum ada
            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_due');
            }
            
            // Tambah kolom payment_code jika belum ada
            if (!Schema::hasColumn('orders', 'payment_code')) {
                $table->string('payment_code')->nullable()->after('payment_proof');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_due', 'payment_proof', 'payment_code']);
        });
    }
};