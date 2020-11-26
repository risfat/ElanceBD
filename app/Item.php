<?php
/**
 * Class Item
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
 * Class Item
 *
 */
class Item extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Set invoice relation
     *
     * @access public
     *
     * @return array
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Set user relation
     *
     * @access public
     *
     * @return array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
