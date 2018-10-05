<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class Language extends Model
{
    protected $fillable = ['name', 'code', 'flag', 'is_default', 'status', 'added_by', 'updated_by'];

    const LANGUAGE_DIR          = 'images/language/original/';
    const LANGUAGE_THUMB_DIR    = 'images/language/thumb/';

    /*
     * Fetch all language.
     */
    public function getAllLanguage() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
        }
        if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $language   = Language::select('*');
        if(request()->has('search')) {
            $language   = $language->where('name', 'like', '%'. request()->get('search') .'%');
        }
        $language   = $language->paginate();

        return $language;
    }

    /*
     * Fetch all active languages.
     */
    public static function getAllActiveLanguage() {
        $languages  = Language::select('name', 'code', 'flag')->where('status', '1')->get();
        $data       = array();
        foreach ($languages as $language) {
            $data[$language->code]['name'] = $language->name;
            $data[$language->code]['flag'] = url(self::LANGUAGE_THUMB_DIR . $language->flag);
        }

        return $data;
    }

    /*
     * Save new language.
     */
    public function saveLanguage($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->verifyUpdateDefault($data);
        $data['added_by']   = Auth::user()->id;

        return Language::create($data);
    }

    /*
     * Update language.
     */
    public function updateLanguage($id, $data = array()) {
        if(empty($data)) {
            return false;
        }
        if(!$this->verifyUpdateDefault($data)) {
            $data['is_default'] = '0';
        }

        $data['updated_by'] = Auth::user()->id;
        $language   = Language::find($id);
        $language->fill($data);
        return $language->save();
    }

    /*
     * Set is_default to one language only.
     */
    public function verifyUpdateDefault($data) {
        if(isset($data['is_default'])) {
            return Language::where('status', '1')
                ->update(['is_default' => '0']);
        }

        return false;
    }

    /*
     * Verify is_default can be updated or not.
     */
    public static function canUpdateIsDefault($id) {
        $defaultCount   = Language::where(['is_default' => '1', 'status' => '1'])
            ->where('id', '!=', $id)
            ->get()->count();
        if($defaultCount === 0) {
            Session::flash('danger', 'There must be at least one default language.');
            return false;
        }

        return true;
    }

    /*
     * Get original language flag path.
     */
    public static function getLanguageDir() {
        return public_path(self::LANGUAGE_DIR);
    }

    /*
     * Get thumb language flag path.
     */
    public static function getLanguageThumbDir() {
        return public_path(self::LANGUAGE_THUMB_DIR);
    }

    /*
     * Get is_default attribute value for user display.
     */
    //To Do
}
