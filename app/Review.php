<?php
/**
 * Class Review
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
 * Class Review
 *
 */
class Review extends Model
{
    /**
     * Get user.
     *
     * @return polymorphic relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Submit Review
     *
     * @param mixed $request   req->attr
     * @param mixed $author_id Author ID
     *
     * @return request\response
     */
    public static function submitReview($request, $author_id)
    {
        $user_rating = array();
        $avg = 0;
        $avg_rating = 0;
        $count = 0;
        $json = array();
        $review = new Review();
        $user = User::find($author_id);
        $review->user()->associate($user);
        $review->receiver_id = intval($request['receiver_id']);
        $review->job_id = intval($request['job_id']);
        $review->feedback = filter_var($request['feedback'], FILTER_SANITIZE_STRING);
        foreach ($request['rating'] as $key => $value) {
            if ($value['rate'] > 0) {
                $count++;
                $user_rating[$key]['rating'] = intval($value['rate']);
                $user_rating[$key]['reason'] = intval($value['reason']);
                $avg = $avg + intval($value['rate']);
            }
        }
        if ($avg <= 0 ) {
            $json['type'] = 'rating_error';
            return $json;
        }
        $avg_rating = $avg / $count;
        $review->rating = serialize($user_rating);
        $review->avg_rating = $avg_rating;
        $review->save();
        $proposal = Proposal::find($request['proposal_id']);
        $proposal->status = 'completed';
        $proposal->save();
        $job = Job::find($proposal->job_id);
        $job->status = 'completed';
        $job->save();
        $json['type'] = 'success';
        return $json;
    }
}
