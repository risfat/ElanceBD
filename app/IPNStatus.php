<?php
/**
 * Class IPNStatus
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IPNStatus
 *
 */
class IPNStatus extends Model
{
    /**
     * Set scope of the variable
     *
     * @access public
     *
     * @return array
     */
    protected $table = 'ipn_status';

    /**
     * Set scope of the variable
     *
     * @access public
     *
     * @return array
     */
    protected $fillable = [
        'payload',
        'status'
    ];
}
