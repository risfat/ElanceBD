<?php

/**
 * Class PrivateMessages
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
 * Class PrivateMessages
 */
class PrivateMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'private_messages',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('author_id');
                $table->integer('proposal_id');
                $table->text('content');
                $table->text('attachments')->nullable();
                $table->tinyInteger('notify');
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
        Schema::dropIfExists('private_messages');
    }
}
