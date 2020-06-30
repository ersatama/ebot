<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bot');
            $table->bigInteger('index');
            $table->text('chat');
            $table->smallInteger('deleted')->default(0);
            $table->timestamps();
        });

        /*
         {"type":"start","message":null,"validation":0,"status":false,"name":null,"error":null,"connected":[],"answers":[{"title":"\u041b\u044e\u0431\u0430\u044f \u0434\u0440\u0443\u0433\u0430\u044f \u0444\u0440\u0430\u0437\u0430","type":"default","connect":{"status":false,"active":false,"block":-1,"l1":0,"l2":0,"endWidth":0,"endHeight":0}},{"title":"\u041f\u0440\u0438\u0432\u0435\u0442","type":"custom","connect":{"status":false,"active":false,"block":-1,"l1":0,"l2":0,"endWidth":0,"endHeight":0}}],"Y":30,"X":30}
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
