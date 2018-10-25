<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class Program extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['banner', 'time_from', 'time_to', 'status', 'created_by', 'updated_by'];

    const ORIGINAL_DIR      = 'images/program/original/';
    const THUMB_DIR         = 'images/program/thumb/';

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
     * Get list of all class.
     */
    public function getAllProgram() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $program    = Program::select('*');
        if(request()->has('search')) {
            $program    = $program->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $program->paginate();
    }

    /*
     * Save new program.
     */
    public function saveProgram($data = array()) {
        if(empty($data)) {
            return false;
        }

        $this->banner       = $data['banner'] ?? null;
        $this->time_from     = $data['time_from'];
        $this->time_to       = $data['time_to'];
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
     * Update Program
     */
    public function updateProgram($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $programData   = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $programData[$lang][$field]    = $data[$lang . '_' . $field];
            }
        }

        $programData['banner']     = $data['banner'];
        $programData['time_from']  = $data['time_from'];
        $programData['time_to']    = $data['time_to'];
        $programData['status']     = $data['status'];
        $programData['updated_by'] = Auth::user()->id;

        $program    = Program::findOrFail($id);
        if($program->update($programData)) {
            return true;
        }

        return false;
    }

}
