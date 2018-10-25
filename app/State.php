<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;
use App\Language;

class State extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    public $localeKey;
    protected $fillable = ['status', 'created_by', 'updated_by'];

    /*
     * State have many cities.
     */
    public function city() {
        return $this->hasMany('App\City');
    }

    /*
     * State have many schools.
     */
    public function schools() {
        return $this->hasMany('App\School');
    }

    /*
     * Get active state list.
     */
    public function getStateList() {
        $result     = State::where('status', '1')->get();
        $stateList  = array('' => 'Please select a state');
        foreach($result as $item) {
            $stateList[$item['id']] = $item['name'];
        }

        return $stateList;
    }

    /*
     * Get list of all state.
     */
    public function getAllState() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $state  = State::select('*');
        if(request()->has('search')) {
            $state  = $state->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $state->paginate();
    }

    /*
     * Save new state.
     */
    public function saveState($data = array()) {
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
     * Update state
     */
    public function updateState($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $stateData  = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $stateData[$lang]   = array(
                    $field  => $data[$lang . '_' . $field]
                );
            }
        }
        $stateData['status']        = $data['status'];
        $stateData['updated_by']    = Auth::user()->id;

        $state  = State::find($id);
        if($state->update($stateData)) {
            return true;
        }

        return false;
    }
}
