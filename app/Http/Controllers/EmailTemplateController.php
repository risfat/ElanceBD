<?php
/**
 * Class EmailTemplateController.
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use App\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use View;
use Session;

/**
 * Class EmailTemplateController
 *
 */
class EmailTemplateController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $email
     */
    protected $email;

    /**
     * Create a new controller instance.
     *
     * @param instance $email instance
     *
     * @return void
     */
    public function __construct(EmailTemplate $email)
    {
        $this->email = $email;
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
            $templates = $this->email::where('title', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
            $pagination = $templates->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $templates = $this->email->getEmailTemplates();
        }
        return View::make('back-end.admin.email-templates.index', compact('templates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id ID
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = $this->email::getEmailTemplateByID($id);
        return View::make('back-end.admin.email-templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \App\EmailTemplate       $id      emailTemplate
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request, [
                'title' => 'required',
                'subject' => 'required',
                'email_content' => 'required',
            ]
        );
        $this->email->updateEmailTemplates($request, $id);
        Session::flash('message', trans('lang.email_template_updated'));
        return Redirect::to('admin/email-templates');
    }
}
