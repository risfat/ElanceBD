<?php
/**
 * Class PageController
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Auth;
use App\User;
use App\Helper;

/**
 * Class PageController
 *
 */
class PageController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $page
     */
    protected $page;

    /**
     * Create a new controller instance.
     *
     * @param instance $page instance
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->page::getPages();
        return View::make(
            'back-end.admin.pages.index',
            compact('pages')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_page = $this->page->getParentPages();
        $page_created = trans('lang.page_created');
        return View::make('back-end.admin.pages.create', compact('parent_page', 'page_created'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = array();
        if (!empty($request)) {
            $this->validate(
                $request, [
                    'title' => 'required|string',
                    'content' => 'required',
                ]
            );
            $this->page->savePage($request);
            $child_id = DB::getPdo()->lastInsertId();
            if ($request['parent_id']) {
                DB::table('child_pages')->insert(
                    ['parent_id' => $request['parent_id'], 'child_id' => $child_id]
                );
            }
            $json['type'] = 'success';
            return $json;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug page slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (!empty($slug)) {
            $page = $this->page->getPageData($slug);
            return View::make('back-end.admin.pages.show', compact('page', 'slug'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $id page Id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $page = $this->page::find($id);
            $parent_selected_id = '';
            $parent_page = $this->page->getParentPages($id);
            $has_child = $this->page->pageHasChild($id);
            $child_parent_id = DB::table('child_pages')->select('parent_id')->where('child_id', $id)->get()->first();
            if (!empty($child_parent_id->parent_id)) {
                $parent_selected_id = $child_parent_id->parent_id;
            } else {
                $parent_selected_id = '';
            }
            return View::make('back-end.admin.pages.edit', compact('page', 'parent_page', 'parent_selected_id', 'id', 'has_child'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed   $request $req->attr
     * @param integer $id      page ID
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request)) {
            $this->validate(
                $request, [
                'title' => 'required|string',
                'content' => 'required',
                ]
            );
            $parent_id = filter_var($request['parent_id'], FILTER_SANITIZE_NUMBER_INT);
            $child_id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $this->page->updatePage($id, $request);
            if ($parent_id == null) {
                DB::table('child_pages')->where('child_id', '=', $child_id)->delete();
            } elseif ($parent_id) {
                DB::table('child_pages')->where('child_id', '=', $child_id)->delete();
                DB::table('child_pages')->insert(
                    ['parent_id' => $parent_id, 'child_id' => $child_id]
                );
            }
            Session::flash('message', trans('lang.page_updated'));
            return Redirect::to('admin/pages');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $json = array();
        $id = $request['id'];
        if (!empty($id)) {
            $child_pages = $this->page::pageHasChild($id);
            if (!empty($child_pages)) {
                foreach ($child_pages as $page) {
                    DB::table('pages')->where('id', $page->child_id)->update(['relation_type' => 0]);
                }
            } else {
                $relation = DB::table('pages')->select('relation_type')->where('id', $id)->get()->first();
                if ($relation->relation_type == 1) {
                    DB::table('pages')->where('id', $id)->update(['relation_type' => 0]);
                }
            }
            DB::table('child_pages')->where('child_id', '=', $id)->orWhere('parent_id', '=', $id)->delete();
            DB::table('pages')->where('id', '=', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.page_deleted');
            return $json;
        }
    }
}
