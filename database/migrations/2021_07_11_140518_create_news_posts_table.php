<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->foreignId('category_id')->references('id')->on('news_categories')->onDelete('cascade');
            $table->longText('content');
            $table->longText('content_en')->nullable();
            $table->foreignId('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('thumbnail')->nullable();
            $table->string('source');
            $table->enum('status', ['Draft', 'Pending', 'Published'])->default('Draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('viewer')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('news_posts');
    }
}
