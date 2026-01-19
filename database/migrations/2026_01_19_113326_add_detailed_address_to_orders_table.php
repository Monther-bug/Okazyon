<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null')->after('buyer_id');
            $table->decimal('latitude', 10, 8)->nullable()->after('delivery_address');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('payment_method')->default('cash_on_delivery')->after('longitude');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('payment_method');
            $table->string('delivery_phone')->nullable()->after('payment_status');
            $table->text('delivery_notes')->nullable()->after('delivery_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->dropColumn([
                'address_id',
                'latitude',
                'longitude',
                'payment_method',
                'payment_status',
                'delivery_phone',
                'delivery_notes'
            ]);
        });
    }
};
