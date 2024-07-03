<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesCountToBlogsTable extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('likes_count')->default(0); // تعريف عمود الإعجابات
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('likes_count'); // إزالة عمود الإعجابات إذا تم التراجع عن التغييرات
        });
    }


};
