<?php
/**
 * Class EmailTemplate.
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
use DB;
use function Opis\Closure\unserialize;
use function Opis\Closure\serialize;

/**
 * Class EmailTemplate
 *
 */
class EmailTemplate extends Model
{
    /**
     * Get Email Templates
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmailTemplates()
    {
        return DB::table('email_templates')
            ->join('email_types', 'email_types.id', '=', 'email_templates.email_type_id')
            ->select('email_templates.*', 'email_types.*')->paginate(10);
    }

    /**
     * Get Email Template By ID
     *
     * @param int $id email template ID
     *
     * @return \Illuminate\Http\Response
     */
    public static function getEmailTemplateByID($id)
    {
        return DB::table('email_templates')
            ->join('email_types', 'email_types.id', '=', 'email_templates.email_type_id')
            ->select('email_templates.*', 'email_types.*')
            ->where('email_templates.id', $id)
            ->first();
    }

    /**
     * Update Email Template
     *
     * @param string $request get request attributes
     * @param int    $id      get department id for updation
     *
     * @return \Illuminate\Http\Response
     */
    public function updateEmailTemplates($request, $id)
    {
        if (!empty($request)) {
            $template = self::find($id);
            $template->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $template->subject  =  filter_var($request['subject'], FILTER_SANITIZE_STRING);
            $template->content = $request['email_content'];
            return $template->save();
        }
    }
}
