<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chains', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bot');
            $table->bigInteger('index');
            $table->string('type');
            $table->string('name')->nullable();
            $table->longText('answers')->nullable();
            $table->longText('details')->nullable();
            $table->smallInteger('deleted')->default(0);
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
        Schema::dropIfExists('chains');
    }
}
