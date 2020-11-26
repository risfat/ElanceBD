<?php
/**
 * Class DepartmentController.
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */

namespace App\Http\Controllers;

use App\Department;
use View;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

/**
 * Class DepartmentController
 *
 */
class DepartmentController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $department
     */
    protected $department;

    /**
     * Create a new controller instance.
     *
     * @param instance $department instance
     *
     * @return void
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
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
            $departments = $this->department::where('title', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
            $pagination = $departments->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $departments = $this->department->paginate(7);
        }
        return View::make(
            'back-end.admin.departments.index',
            compact('departments')
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
                    'department_title' => 'required',
                ]
            );
            $this->department->saveDepartments($request);
        }
        Session::flash('message', trans('lang.save_department'));
        return Redirect::back();
    }

    /**
     * Edit departments.
     *
     * @param int $id integer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $departments = $this->department::find($id);
            if (!empty($departments)) {
                return View::make(
                    'back-end.admin.departments.edit', compact('id', 'departments')
                );
                Session::flash('message', trans('lang.dpt_updated'));
                return Redirect::to('admin/departments');
            }
        }
    }

    /**
     * Update departments.
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
            'department_title' => 'required',
            ]
        );
        $this->department->updateDepartments($request, $id);
        Session::flash('message', trans('lang.dpt_updated'));
        return Redirect::to('admin/departments');
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
            $this->department::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.dpt_deleted');
            return $json;
        }
    }
}
