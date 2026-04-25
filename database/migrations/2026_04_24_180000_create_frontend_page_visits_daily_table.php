<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendPageVisitsDailyTable extends Migration
{
    public function up()
    {
        Schema::create('frontend_page_visits_daily', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date')->unique();
            $table->unsignedBigInteger('visits')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frontend_page_visits_daily');
    }
}

