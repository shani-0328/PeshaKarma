<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('responsible_person')->nullable();
            $table->unsignedBigInteger('department_id')->index()->unsigned();
            $table->string('total_loan_amount')->nullable()->default('0.00');
            $table->string('paid')->nullable()->default('0.00');
            $table->string('balance')->nullable()->default('0.00');
            $table->string('percentage')->nullable()->default('0.00');
            $table->timestamps(); 
            $table->foreign('department_id')->references('id')
            ->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutions');
    }
}
