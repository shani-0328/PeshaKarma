<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('initials');
            $table->string('last_name');
            $table->string('payment_status')->nullable();
            $table->string('invoice_count')->nullable()->default("0");
            $table->string('special_invoice_count')->nullable()->default("0");
            $table->date('first_payment_date')->nullable();
            $table->date('last_payment_date')->nullable();
            $table->string('voucher_number')->nullable();
            $table->string('invoice_first_invoice')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('Gov_ID')->unique();
            $table->string('occupation');
            $table->string('phone_number')->unique();
            $table->string('address');
            $table->string('date_diff_with_invoice')->nullable();
            $table->string('total_loan_amount')->nullable()->default('0.00');
            $table->string('arius_amount_3_month')->nullable();
            $table->string('total_paid_amount')->nullable()->default('0.00');
            $table->string('total_balance')->nullable()->default('0.00');
            $table->string('total_paid_percentage')->nullable()->default('0.00');
            $table->integer('department_id')->index()->unsigned();
            $table->integer('institution_id')->index()->unsigned();
            $table->string('place_to_get_paid')->nullable();
            $table->string('office_phone_number');
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
        Schema::dropIfExists('customers');
    }
}
