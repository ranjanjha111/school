<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class State extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    public $localeKey;
    protected $fillable = ['status', 'added_by', 'updated_by'];

    /*
     * List all states.
     */
    public function getStateList() {
        $states = State::latest()->paginate(10);
        return $states;
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

    /*
     * Find state details.
     */
    public function findStateById($id) {
        $state = State::find($id);

        $result = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $result[$lang . '_' . $field] = $state->getTranslation($lang)->{$field};
            }
        }


        dd($state);

        return $state;
    }

    /*
     * Build state data for user view.
     */
    public function buildStateData($state = array()) {
        if (empty($state)) {
            return false;
        }

        $result = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $this->translateOrNew($lang)->{$field}    = $data[$lang . '_' .$field];
            }
        }

    }
}
