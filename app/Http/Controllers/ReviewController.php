<?php
/**
 * Class ReviewController
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\ReviewOptions;
use View;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

/**
 * Class ReviewController
 *
 */
class ReviewController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $review
     */
    protected $review;

    /**
     * Create a new controller instance.
     *
     * @param instance $review         review instance
     * @param instance $review_options review options instance
     *
     * @return void
     */
    public function __construct(Review $review, ReviewOptions $review_options)
    {
        $this->review = $review;
        $this->review_options = $review_options;

    }

    /**
     * Display a listing of the resource.
     *
     * @param mixed $request Request Attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $review_options = $this->review_options::paginate(10);
        return View::make(
            'back-end.admin.review-options.index',
            compact('review_options')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $request string
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
            $this->validate(
                $request, [
                    'review_option_title' => 'required',
                ]
            );
            $this->review_options->saveReviewOptions($request);
        }
        Session::flash('message', trans('lang.save_review_option'));
        return Redirect::back();
    }

    /**
     * Edit review options.
     *
     * @param int $id integer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $review_options = $this->review_options::find($id);
            if (!empty($review_options)) {
                return View::make(
                    'back-end.admin.review-options.edit', compact('id', 'review_options')
                );
                Session::flash('message', trans('lang.review_options_updated'));
                return Redirect::to('admin/review_options');
            }
        }
    }

    /**
     * Update review options.
     *
     * @param string $request string
     * @param int    $id      integer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request, [
            'review_option_title' => 'required',
            ]
        );
        $this->review_options->updateReviewOptions($request, $id);
        Session::flash('message', trans('lang.review_option_updated'));
        return Redirect::to('admin/review-options');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $json = array();
        $id = $request['id'];
        if (!empty($id)) {
            $this->review_options::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.dpt_deleted');
            return $json;
        }
    }
}
