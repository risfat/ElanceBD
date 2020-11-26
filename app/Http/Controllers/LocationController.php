<?php
/**
 * Class LocationController.
 *
  
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com
 */

namespace App\Http\Controllers;

use App\Location;
use View;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Helper;

/**
 * Class Location Controller
 *
 */
class LocationController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $skill
     */
    protected $location;

    /**
     * Create a new controller instance.
     *
     * @param mixed $location location instance
     *
     * @return void
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $locations = $this->location::where('title', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
            $pagination = $locations->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $locations = $this->location->paginate(7);
        }
        return View::make(
            'back-end.admin.locations.index',
            compact('locations')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required',
            ]
        );
        if (!empty($request['title'])) {
            $this->location->storeLocation($request);
            Session::flash('message', trans('lang.save_location'));
            return Redirect::back();
        }
    }

    /**
     * Edit Locations.
     *
     * @param int $id integer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $locations = $this->location::find($id);
            if (!empty($locations)) {
                $store_locations = $this->location::where('id', '!=', $id)->get()->all();
                return View::make(
                    'back-end.admin.locations.edit',
                    compact(
                        'id', 'locations', 'store_locations'
                    )
                );
                Session::flash('message', trans('lang.location_updated'));
                return Redirect::to('admin/locations');
            }
        }
    }

    /**
     * Update locations.
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
                'title' => 'required',
            ]
        );
            $this->location->updateLocation($request, $id);
            Session::flash('message', trans('lang.location_updated'));
            return Redirect::to('admin/locations');
    }

    /**
     * Remove location from database.
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
            $this->location::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.location_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
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
        $path = Helper::PublicPath() . '/uploads/locations/temp/';
        if (!empty($request['uploaded_image'])) {
            return Helper::uploadTempImage($path, $request['uploaded_image']);
        }
    }
}
