<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class Standard extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['banner', 'age_from', 'age_to', 'time_from', 'time_to', 'size', 'status', 'created_by', 'updated_by'];

    const ORIGINAL_DIR      = 'images/standard/original/';
    const THUMB_DIR         = 'images/standard/thumb/';

    /*
     * Get list of all class.
     */
    public function getAllStandard() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $standard   = Standard::select('*');
        if(request()->has('search')) {
            $standard   = $standard->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $standard->paginate();
    }

    /*
     * Save new Class.
     */
    public function saveStandard($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->banner       = $data['banner'];
        $this->age_from     = $data['age_from'];
        $this->age_to       = $data['age_to'];
        $this->time_from     = $data['time_from'];
        $this->time_to       = $data['time_to'];
        $this->size         = $data['size'];
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
     * Update Class
     */
    public function updateFeatured($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $standardData   = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $standardData[$lang][$field]    = $data[$lang . '_' . $field];
            }
        }

        $standardData['banner']     = $data['banner'];
        $standardData['age_from']   = $data['age_from'];
        $standardData['age_to']     = $data['age_to'];
        $standardData['time_from']  = $data['time_from'];
        $standardData['time_to']    = $data['time_to'];
        $standardData['size']       = $data['size'];
        $standardData['status']     = $data['status'];
        $standardData['updated_by'] = Auth::user()->id;

        $standard   = Standard::findOrFail($id);
        if($standard->update($standardData)) {
            return true;
        }

        return false;
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
}
