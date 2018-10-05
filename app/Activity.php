<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class Activity extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    public $localeKey;
    protected $fillable = ['status', 'created_by', 'updated_by'];

    public $searchByFields  = array(
        'name'      => 'Name',
        'status'    => 'Status'
    );

    /*
     * Get list of all activity.
     */
    public function getAllActivity() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $activity   = Activity::select('*');
        if(request()->has('search')) {
            $activity   = $activity->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $activity->paginate();
    }

    /*
     * Save new activity.
     */
    public function saveActivity($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->status       = $data['status'];
        $this->created_by   = Auth::user()->id;
        $this->save();

        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $this->translateOrNew($lang)->{$field}    = $data[$lang . '_' .$field];
            }
        }

        return $this->save();
    }

    /*
     * Update activity
     */
    public function updateActivity($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $activityData   = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $activityData[$lang][$field]   = $data[$lang . '_' . $field];
            }
        }
        $activityData['status']     = $data['status'];
        $activityData['updated_by'] = Auth::user()->id;

        $activity   = Activity::find($id);
        if($activity->update($activityData)) {
            return true;
        }

        return false;
    }


}
