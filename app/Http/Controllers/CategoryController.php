<?php
/**
 * Class CategoryController
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */

namespace App\Http\Controllers;

use App\Category;
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
class CategoryController extends Controller
{
    /**
     * Defining scope of variable
     *
     * @access public
     * @var    array $category
     */
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @param mixed $category get category model
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
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
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $cats = $this->category::where('title', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
            $pagination = $cats->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $cats = $this->category->paginate(10);
        }
        return View::make(
            'back-end.admin.categories.index', compact('cats')
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
            $request, [
                'category_title'    => 'required',
            ]
        );
        $this->category->saveCategories($request);
        Session::flash('message', trans('lang.save_category'));
        return Redirect::back();
    }

    /**
     * Edit Categories.
     *
     * @param int $id integer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $cats = $this->category::find($id);
            if (!empty($cats)) {
                return View::make(
                    'back-end.admin.categories.edit', compact('id', 'cats')
                );
                return Redirect::to('admin/categories');
            }
        }
    }

    /**
     * Update Categories.
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
                'category_title' => 'required',
            ]
        );
        $this->category->updateCategories($request, $id);
        Session::flash('message', trans('lang.cat_updated'));
        return Redirect::to('admin/categories');
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
            $this->category::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.cat_deleted');
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
        $path = Helper::PublicPath() . '/uploads/categories/temp/';
        if (!empty($request['uploaded_image'])) {
            return Helper::uploadTempImage($path, $request['uploaded_image']);
        }
    }

    /**
     * All Categories Lisiting.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function categoriesList(Request $request)
    {
        $categories = $this->category->paginate(10);
        if (!empty($categories)) {
            return View::make(
                'front-end.categories.index',
                compact(
                    'categories'
                )
            );
        } else {
            abort(404);
        }
    }
}
