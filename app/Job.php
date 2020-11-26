<?php

/**
 * Class Job.
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
use File;
use Storage;
use DB;
use Auth;
use App\Proposal;
use App\Location;
use App\Language;

/**
 * Class Job
 *
 */
class Job extends Model
{
    /**
     * Get all of the categories for the job.
     *
     * @return relation
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'catable');
    }

    /**
     * Get all of the languages for the user.
     *
     * @return relation
     */
    public function languages()
    {
        return $this->morphToMany('App\Language', 'langable');
    }

    /**
     * The skills that belong to the job.
     *
     * @return relation
     */
    public function skills()
    {
        return $this->belongsToMany('App\Skill');
    }

    /**
     * Get the location that owns the job.
     *
     * @return relation
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Get the employer that owns the job.
     *
     * @return relation
     */
    public function employer()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the proposals associated with job.
     *
     * @return relation
     */
    public function proposals()
    {
        return $this->hasMany('App\Proposal');
    }

    /**
     * Get all of the job's reports.
     *
     * @return relation
     */
    public function reports()
    {
        return $this->morphMany('App\Report', 'reportable');
    }

    /**
     * Uppload Attcahments.
     *
     * @param mixed $uploadedFile uploaded file
     *
     * @return relation
     */
    public function uploadTempattachments($uploadedFile)
    {
        $filename = $uploadedFile->getClientOriginalName();
        $path = 'uploads/jobs/temp/';
        Storage::disk('local')->putFileAs(
            $path,
            $uploadedFile,
            $filename
        );
        return 'success';
    }

    /**
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!Job::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Job::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * Store Jobs.
     *
     * @param mixed $request request->attr
     *
     * @return relation
     */
    public function storeJobs($request)
    {
        $json = array();
        if (!empty($request)) {
            $random_number = Helper::generateRandomCode(8);
            $code = strtoupper($random_number);
            $user_id = Auth::user()->id;
            $location = $request['locations'];
            $this->location()->associate($location);
            $this->employer()->associate($user_id);
            $this->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->price = filter_var($request['project_cost'], FILTER_SANITIZE_STRING);
            $this->project_level = filter_var($request['project_levels'], FILTER_SANITIZE_STRING);
            $this->description = $request['description'];
            $this->english_level = filter_var($request['english_level'], FILTER_SANITIZE_STRING);
            $this->duration = filter_var($request['job_duration'], FILTER_SANITIZE_STRING);
            $this->freelancer_type = filter_var($request['freelancer_type'], FILTER_SANITIZE_STRING);
            $this->is_featured = filter_var($request['is_featured'], FILTER_SANITIZE_STRING);
            $this->show_attachments = filter_var($request['show_attachments'], FILTER_SANITIZE_STRING);
            $this->address = filter_var($request['address'], FILTER_SANITIZE_STRING);
            $this->longitude = filter_var($request['longitude'], FILTER_SANITIZE_STRING);
            $this->latitude = filter_var($request['latitude'], FILTER_SANITIZE_STRING);
            $old_path = 'uploads\jobs\temp';
            $job_attachments = array();
            if (!empty($request['attachments'])) {
                $attachments = $request['attachments'];
                foreach ($attachments as $key => $attachment) {
                    if (Storage::disk('local')->exists($old_path . '/' . $attachment)) {
                        $new_path = 'uploads/jobs/' . $user_id;
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $attachment;
                        Storage::move($old_path . '/' . $attachment, $new_path . '/' . $filename);
                        $job_attachments[] = $filename;
                    }
                }
                $this->attachments = serialize($job_attachments);
            }
            $this->code = $code;
            $this->save();
            $job_id = $this->id;
            $skills = $request['skills'];
            $this->skills()->detach();
            if (!empty($skills)) {
                foreach ($skills as $skill) {
                    $this->skills()->attach($skill['id']);
                }
            }
            $job = Job::find($job_id);
            $languages = $request['languages'];
            $job->languages()->sync($languages);
            $categories = $request['categories'];
            $job->categories()->sync($categories);
            $json['type'] = 'success';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Update Jobs.
     *
     * @param mixed   $request request
     * @param integer $id      ID
     *
     * @return $request, ID
     */
    public function updateJobs($request, $id)
    {
        $json = array();
        if (!empty($request)) {
            $job = self::find($id);
            $random_number = Helper::generateRandomCode(8);
            $user_id = Auth::user()->id;
            $location = $request['locations'];
            $job->location()->associate($location);
            $job->employer()->associate($user_id);
            if ($job->title != $request['title']) {
                $job->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            }
            $job->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $job->price = filter_var($request['project_cost'], FILTER_SANITIZE_STRING);
            $job->project_level = filter_var($request['project_levels'], FILTER_SANITIZE_STRING);
            $job->description = $request['description'];
            $job->english_level = filter_var($request['english_level'], FILTER_SANITIZE_STRING);
            $job->duration = filter_var($request['job_duration'], FILTER_SANITIZE_STRING);
            $job->freelancer_type = filter_var($request['freelancer_type'], FILTER_SANITIZE_STRING);
            $job->is_featured = filter_var($request['is_featured'], FILTER_SANITIZE_STRING);
            $job->show_attachments = filter_var($request['show_attachments'], FILTER_SANITIZE_STRING);
            $job->address = filter_var($request['address'], FILTER_SANITIZE_STRING);
            $job->longitude = filter_var($request['longitude'], FILTER_SANITIZE_STRING);
            $job->latitude = filter_var($request['latitude'], FILTER_SANITIZE_STRING);
            $old_path = 'uploads\jobs\temp';
            $job_attachments = array();
            if (!empty($request['attachments'])) {
                $attachments = $request['attachments'];
                foreach ($attachments as $key => $attachment) {
                    $filename = $attachment;
                    if (Storage::disk('local')->exists($old_path . '/' . $attachment)) {
                        $new_path = 'uploads/jobs/' . $user_id;
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $attachment;
                        Storage::move($old_path . '/' . $attachment, $new_path . '/' . $filename);
                    }
                    $job_attachments[] = $filename;
                }
                $job->attachments = serialize($job_attachments);
            } else {
                $job->attachments = null;
            }
            if (empty($job->code)) {
                $code = strtoupper($random_number);
                $job->code = $code;
            }
            $job->save();
            $job_id = $job->id;
            $skills = $request['skills'];
            $job->skills()->detach();
            if (!empty($skills)) {
                foreach ($skills as $skill) {
                    $job->skills()->attach($skill['id']);
                }
            }
            $job = Job::find($job_id);
            $languages = $request['languages'];
            $job->languages()->sync($languages);
            $categories = $request['categories'];
            $job->categories()->sync($categories);
            $json['type'] = 'success';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Get all of the categories for the job.
     *
     * @param string $keyword                keyword
     * @param string $search_categories      search_categories
     * @param string $search_locations       search_locations
     * @param string $search_skills          search_skills
     * @param string $search_project_lengths search_project_lengths
     * @param string $search_languages       search_languages
     *
     * @return relation
     */
    public static function getSearchResult(
        $keyword, $search_categories, $search_locations,
        $search_skills, $search_project_lengths,
        $search_languages
    ) {
        $json = array();
        $jobs = Job::select('*');
        $job_id = array();
        $filters = array();
        $filters['type'] = 'job';
        if (!empty($keyword)) {
            $filters['s'] = $keyword;
            $jobs->where('title', 'like', '%' . $keyword . '%');
        };
        if (!empty($search_categories)) {
            $filters['category'] = $search_categories;
            $categories = Category::whereIn('slug', $search_categories)->get();
            foreach ($categories as $key => $category) {
                if (!empty($category->jobs[$key]->id)) {
                    $job_id[] = $category->jobs[$key]->id;
                }
            }
            $jobs->whereIn('id', $job_id);
        }
        if (!empty($search_locations)) {
            $filters['locations'] = $search_locations;
            $locations = Location::select('id')->whereIn('slug', $search_locations)->get()->pluck('id')->toArray();
            $jobs->whereIn('location_id', $locations);
        }
        if (!empty($search_skills)) {
            $filters['skills'] = $search_skills;
            $skills = Skill::whereIn('slug', $search_skills)->get();
            foreach ($skills as $key => $skill) {
                if (!empty($skill->jobs[$key]->id)) {
                    $job_id[] = $skill->jobs[$key]->id;
                }
            }
            $jobs->whereIn('id', $job_id);
        }
        if (!empty($search_project_lengths)) {
            $filters['project_lengths'] = $search_project_lengths;
            $jobs->whereIn('duration', $search_project_lengths);
        }
        if (!empty($search_languages)) {
            $filters['languages'] = $search_languages;
            $languages = Language::whereIn('slug', $search_languages)->get();
            foreach ($languages as $key => $language) {
                if (!empty($language->jobs[$key]->id)) {
                    $job_id[] = $language->jobs[$key]->id;
                }
            }
            $jobs->whereIn('id', $job_id);
        }
        $jobs = $jobs->orderBy('updated_at', 'desc')->paginate(7)->setPath('');
        foreach ($filters as $key => $filter ) {
            $pagination = $jobs->appends(
                array(
                    $key => $filter
                )
            );
        }
        $json['jobs'] = $jobs;
        return $json;
    }
}
