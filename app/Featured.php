<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class Featured extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];
    public $localeKey;
    protected $fillable = ['school_id', 'image', 'status', 'created_by', 'updated_by'];

    const ORIGINAL_DIR      = 'images/featured/original/';
    const THUMB_DIR    = 'images/featured/thumb/';

    /*
     * Get school of featured in images.
     */
    public function school() {
        return $this->belongsTo('App\School');
    }


    /*
     * Get list of all featured.
     */
    public function getAllFeatured() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $featured   = Featured::select('*');
        if(request()->has('search')) {
            $featured   = $featured->whereTranslationLike('title', '%'. request()->get('search') .'%');
        }

        return $featured->paginate();
    }


    /*
     * Save new activity.
     */
    public function saveFeatured($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->school_id    = $data['school_id'];
        $this->image        = $data['image'];
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
     * Update Featured
     */
    public function updateFeatured($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $featuredData   = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $featuredData[$lang][$field]    = $data[$lang . '_' . $field];
            }
        }

        $featuredData['school_id']  = $data['school_id'];
        $featuredData['image']      = $data['image'];
        $featuredData['status']     = $data['status'];
        $featuredData['updated_by'] = Auth::user()->id;

        $featured   = Featured::find($id);
        if($featured->update($featuredData)) {
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
