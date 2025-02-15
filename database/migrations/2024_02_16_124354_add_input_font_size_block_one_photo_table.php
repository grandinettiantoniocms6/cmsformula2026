<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputFontSizeBlockOnePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
                try{
                    Schema::table('blocks_one_photos', function (Blueprint $table) {
                        $table->string('color_description')->nullable();
                        $table->string('mt')->nullable();
                        $table->string('font_size_title')->nullable();
                        $table->string('font_size_subtitle')->nullable();
                        $table->boolean('repeat_title')->default(0);
                        $table->boolean('cursor_title')->default(0);
                    });
                }catch (\Throwable $e) {
            }

        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            Schema::table('blocks_one_photos', function (Blueprint $table) {
                $table->dropColumn("color_description");
                $table->dropColumn("mt");
                $table->dropColumn("font_size_title");
                $table->dropColumn("font_size_subtitle");
                $table->dropColumn("repeat_title");
                $table->dropColumn("cursor_title");
            });
        }catch (\Throwable $e) {
        }
    }
}
