<?php

/**
 * Class PrivateMessagesTo
 *
  
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class PrivateMessagesTo
 */
class PrivateMessagesTo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'private_messages_to',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('private_message_id')->nullable();
                $table->integer('recipent_id');
                $table->tinyInteger('message_read');
                $table->string('read_date')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_messages_to');
    }
}
