<?php
/**
 * Class BadgeController
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */

namespace App\Http\Controllers;

use App\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Session;
use View;
use App\Helper;

/**
 * Class Category Controller
 *
 */
class BadgeController extends Controller
{
    /**
     * Defining scope of variable
     *
     * @access public
     * @var    array $badge
     */
    protected $badge;

    /**
     * Create a new controller instance.
     *
     * @param mixed $badge get badge model
     *
     * @return void
     */
    public function __construct(Badge $badge)
    {
        $this->badge = $badge;
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
        if (!empty($_GET['s'])) {
            $keyword = $_GET['s'];
            $badges = $this->badge->where('title', 'like', '%' . $keyword . '%')
                ->orderBy('updated_at', 'desc')->paginate(7)->setPath('');
            $pagination = $badges->appends(
                array(
                    's' => Input::get('s')
                )
            );
        } else {
            $badges = $this->badge->paginate(10);
        }
        $badge_img = !empty($this->image) ? $this->image : '';
        return View::make(
            'back-end.admin.badges.index',
            compact('badges', 'badge_img')
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
        $this->validate(
            $request,
            [
                'badge_title'    => 'required',
            ]
        );
        $this->badge->saveBadges($request);
        Session::flash('message', trans('lang.save_badge'));
        return Redirect::back();
    }

    /**
     * Edit Badges
     *
     * @param int $id integer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $badges = $this->badge::find($id);
            if (!empty($badges)) {
                return View::make(
                    'back-end.admin.badges.edit',
                    compact('id', 'badges')
                );
                return Redirect::to('admin/badges');
            }
        }
    }

    /**
     * Update Badges
     *
     * @param string $request string
     * @param int    $id      integer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'badge_title' => 'required',
            ]
        );
        $this->badge->updateBadges($request, $id);
        Session::flash('message', trans('lang.update_badge'));
        return Redirect::to('admin/badges');
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
            $this->badge::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.badge_deleted');
            return $json;
        }
    }

    /**
     * Upload Image to temporary folder.
     *
     * @param mixed $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        $path = Helper::PublicPath() . '/uploads/badges/temp/';
        if (!empty($request['uploaded_image'])) {
            return Helper::uploadTempImage($path, $request['uploaded_image']);
        }
    }

    /**
     * All BadgesLisiting.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function categoriesList(Request $request)
    {
        $badges = $this->badge->paginate(10);
        if (!empty($badges)) {
            return View::make(
                'front-end.badges.index',
                compact('badges')
            );
        } else {
            abort(404);
        }
    }

    /**
     * Get Badge Color
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getBadgeColor(Request $request)
    {
        $json = array();
        $id =  $request['id'];
        if (!empty($id)) {
            $badge = Badge::find($id);
            if (!empty($badge)) {
                $json['color'] = $badge->color;
                $json['type'] = 'success';
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
}
