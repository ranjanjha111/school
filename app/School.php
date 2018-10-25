<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class School extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'locality', 'address', 'near_by'];
    public $localeKey;
    protected $fillable = ['code', 'state_id', 'city_id', 'email', 'mobile', 'fax', 'image', 'status', 'created_by', 'updated_by'];

    const ORIGINAL_DIR      = 'images/school/original/';
    const THUMB_DIR         = 'images/school/thumb/';

    /*
     * School belongs to state.
     */
    public function state() {
        return $this->belongsTo('App\State');
    }

    /*
     * School belongs to city.
     */
    public function city() {
        return $this->belongsTo('App\City');
    }

    /*
     * Get school's featured in images.
     */
    public function featureds() {
        return $this->hasMany('App\Featured');
    }

    /*
     * Get original team image path.
     */
    public static function getDir() {
        return public_path(self::ORIGINAL_DIR);
    }

    /*
     * Get thumb team image path.
     */
    public static function getThumbDir() {
        return public_path(self::THUMB_DIR);
    }

    /*
     * Get list of all school.
     */
    public function getAllSchool() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $school = School::select('*');
        if(request()->has('search')) {
            $school = $school->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $school->paginate();
    }

    /*
     * Save school.
     */
    public function saveSchool($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->code         = $data['code'];
        $this->image        = $data['image'];
        $this->email        = $data['email'];
        $this->mobile       = $data['mobile'];
        $this->fax          = $data['fax'];
        $this->state_id     = $data['state_id'];
        $this->city_id      = $data['city_id'];
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
     * Update team
     */
    public function updateSchool($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $schoolData = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $schoolData[$lang][$field]    = $data[$lang . '_' . $field];
            }
        }

        $schoolData['code']         = $data['code'];
        $schoolData['image']        = $data['image'];
        $schoolData['email']        = $data['email'];
        $schoolData['mobile']       = $data['mobile'];
        $schoolData['fax']          = $data['fax'];
        $schoolData['state_id']     = $data['state_id'];
        $schoolData['city_id']      = $data['city_id'];
        $schoolData['status']       = $data['status'];
        $schoolData['updated_by']   = Auth::user()->id;

        $school = School::findOrFail($id);
        if($school->update($schoolData)) {
            return true;
        }

        return false;
    }

    /*
     * Get active school list.
     */
    public function getSchoolList() {
        $result     = School::where('status', '1')->get();
        $schoolList = array('' => 'Please select a school');
        foreach($result as $item) {
            $schoolList[$item['id']]    = $item['name'];
        }

        return $schoolList;
    }
}
