<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     * @table companies
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('business_name')->nullable();
            $table->string('fiscal_code_vat')->nullable();
            $table->string('pec')->nullable();
            $table->string('sdi')->nullable();
            $table->unsignedInteger('country_id')->unsigned();
            $table->string('name', 250)->nullable()->default(null);
            $table->string('address1', 255)->nullable()->default(null);
            $table->string('address2', 255)->nullable()->default(null);
            $table->string('county', 255)->nullable()->default(null);
            $table->string('city', 255)->nullable()->default(null);
            $table->string('tin', 100)->nullable()->default(null)->comment('Tax Identification Number');
            $table->string('trn', 100)->nullable()->default(null)->comment('Trade Registry Number');
            $table->string('number_street')->nullable();
            $table->softDeletes();
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
       Schema::dropIfExists('shop_companies');
     }
}
