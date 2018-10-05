<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class City extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    public $localeKey;
    protected $fillable = ['state_id', 'status', 'created_by', 'updated_by'];

    /*
     * City belongs to a state.
     */
    public function state() {
        return $this->belongsTo('App\State');
    }

    /*
     * Get list of all city.
     */
    public function getAllCity() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $city   = City::select('*');
        if(request()->has('search')) {
            $city   = $city->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $city->paginate();
    }

    /*
     * Save new city.
     */
    public function saveCity($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->state_id     = $data['state_id'];
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
     * Update City
     */
    public function updateCity($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $cityData  = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $cityData[$lang]   = array(
                    $field  => $data[$lang . '_' . $field]
                );
            }
        }

        $cityData['state_id']   = $data['state_id'];
        $cityData['status']     = $data['status'];
        $cityData['updated_by'] = Auth::user()->id;

        $city  = City::find($id);
        if($city->update($cityData)) {
            return true;
        }

        return false;
    }
}
