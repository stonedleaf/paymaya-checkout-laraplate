<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('status')->default('CREATED');
            $table->string('request_reference_number')->nullable();
            $table->string('transaction_reference_number')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('checkout_url')->nullable();
            $table->string('payment_status')->default('PENDING');
            $table->unsignedBigInteger('refunded_amount')->default(0);
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->string('currency')->default('PHP');
            $table->string('payment_scheme')->nullable();
            $table->boolean('can_refund')->default(false);
            $table->boolean('can_void')->default(false);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
