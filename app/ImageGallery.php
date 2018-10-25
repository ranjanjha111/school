<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class ImageGallery extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];
    public $localeKey;
    protected $fillable = ['school_id', 'image', 'status', 'created_by', 'updated_by'];

    const ORIGINAL_DIR  = 'images/image_gallery/original/';
    const THUMB_DIR     = 'images/image_gallery/thumb/';

    /*
     * Get school of featured in images.
     */
    public function school() {
        return $this->belongsTo('App\School');
    }

    /*
     * Get list of all gallery images.
     */
    public function getAllImage() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $gallery    = ImageGallery::select('*');
        if(request()->has('search')) {
            $gallery   = $gallery->whereTranslationLike('title', '%'. request()->get('search') .'%');
        }

        return $gallery->paginate();
    }

    /*
     * Save new activity.
     */
    public function saveGallery($data = array()) {
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
    public function updateGallery($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $galleryData    = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $galleryData[$lang][$field]    = $data[$lang . '_' . $field];
            }
        }

        $galleryData['school_id']  = $data['school_id'];
        $galleryData['image']      = $data['image'];
        $galleryData['status']     = $data['status'];
        $galleryData['updated_by'] = Auth::user()->id;

        $gallery    = ImageGallery::find($id);
        if($gallery->update($galleryData)) {
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
