<?php

/**
 * Class ProposalDocuments
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
 * Class ProposalDocuments
 */
class ProposalDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'proposal_documents', 
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('proposal_id');
                $table->string('document');
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
        Schema::dropIfExists('proposal_documents');
    }
}
