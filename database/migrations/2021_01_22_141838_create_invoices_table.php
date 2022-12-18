<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->string('special_inovice_status')->nullable();
            $table->string('year')->nullable();
            $table->string('loan_amount');
            $table->unsignedBigInteger('customer_id')->index()->unsigned()->nullable();
            $table->string('number_of_installments')->default('8');
            $table->string('payment_method');
            $table->string('special_rate')->nullable();
            $table->string('guaranter1_name');
            $table->string('guaranter1_Gov_ID');
            $table->string('guaranter1_phone_number');
            $table->string('guaranter2_name');
            $table->string('guaranter2_Gov_ID');
            $table->string('guaranter2_phone_number');
            $table->timestamps();


            $table->foreign('customer_id')->references('id')
            ->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
