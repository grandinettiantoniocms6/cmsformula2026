<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendPageVisitsByPageDailyTable extends Migration
{
    public function up()
    {
        Schema::create('frontend_page_visits_by_page_daily', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date');
            $table->unsignedBigInteger('page_id');
            $table->string('page_label')->nullable();
            $table->string('page_slug')->nullable();
            $table->unsignedBigInteger('visits')->default(0);
            $table->timestamps();

            $table->unique(['visit_date', 'page_id'], 'frontend_page_visits_by_page_daily_unique');
            $table->index('page_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('frontend_page_visits_by_page_daily');
    }
}
