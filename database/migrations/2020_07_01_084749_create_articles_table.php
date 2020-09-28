<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('author_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->integer('status')->default(1); // 0 = Draft, 1 = Published, -1 = Trash (Deleted)
            $table->integer('type')->unsigned()->default(0); // 0 = Basic article, 1 = Featured article
            // $table->text('banner');
            $table->bigInteger('banner_id')->nullable();
            // $table->text('banner_mobile');
            $table->bigInteger('banner_mobile_id')->nullable();
            $table->bigInteger('comment_count')->unsigned()->default(0);
            $table->dateTime('published_at');
            $table->timestamps();

            $table->foreign('author_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->index(['author_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
