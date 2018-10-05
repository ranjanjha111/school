<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class Nutrition extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    public $localeKey;
    protected $fillable = ['status', 'created_by', 'updated_by'];

    /*
     * Get list of all nutrition.
     */
    public function getAllNutrition() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $nutrition  = Nutrition::select('*');
        if(request()->has('search')) {
            $nutrition  = $nutrition->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $nutrition->paginate();
    }

    /*
     * Save new activity.
     */
    public function saveNutrition($data = array()) {
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
     * Update nutrition
     */
    public function updateNutrition($id, $data = array())
    {
        if (empty($data)) {
            return false;
        }

        $nutritionData = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach ($this->translatedAttributes as $field) {
                $nutritionData[$lang][$field]   = $data[$lang . '_' . $field];
            }
        }
        $nutritionData['status'] = $data['status'];
        $nutritionData['updated_by'] = Auth::user()->id;

        $nutrition = Nutrition::find($id);
        if ($nutrition->update($nutritionData)) {
            return true;
        }

        return false;
    }
}
