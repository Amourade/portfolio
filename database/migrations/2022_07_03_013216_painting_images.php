<?php

use App\Models\Image;
use App\Models\Painting;
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
        Schema::create('painting_images', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Painting::class, 'painting_id');
            $table->foreignIdFor(Image::class, 'image_id');
            $table->integer('order');

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
        Schema::dropIfExists('painting_images');
    }
};
