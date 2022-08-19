<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('blog_categories')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('preview')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->timestamp('public_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
};
