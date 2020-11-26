<?php
/**
 * Class Invoice
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
 * Class Invoice
 *
 */
class Invoice extends Model
{

    /**
     * Set scope of the variables
     *
     * @access public
     *
     * @return array
     */
    protected $fillable = ['title', 'price', 'paid'];
    protected $dates = ['created_at'];

    /**
     * Items
     *
     * @access public
     *
     * @return array
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'invoice_id');
    }
}
