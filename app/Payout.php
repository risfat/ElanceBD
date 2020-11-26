<?php
/**
 * Class Payout.
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
 * Class Payout
 *
 */
class Payout extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'payment_method',
        'currency', 'status',
    ];

    /**
     * Get the user that owns the payout.
     *
     * @return relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
