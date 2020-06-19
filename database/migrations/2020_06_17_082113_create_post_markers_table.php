<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_markers', function (Blueprint $table) {
            $table->id();
            $table->string('authtoken', 15)->nullable();
            $table->string('marker')->nullable();
            $table->string('linkpatt')->nullable();
            $table->string('name')->nullable();
            $table->string('tags')->nullable();
            $table->text('description')->nullable();
            $table->string('experienceid', 15)->nullable();
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
        Schema::dropIfExists('post_markers');
    }
}
