<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('title', 60);
            $table->text('content');
            $table->string('excerpt', 300);
            $table->foreignId('idUser');
            $table->binary('featuredImage');
            $table->integer('imageNumber')->default(0);
            
            $table->timestamps();
            
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type')->references('name')->on('type')->onDelete('set null');
        });
        $sql = 'alter table review change featuredImage featuredImage longblob';
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
