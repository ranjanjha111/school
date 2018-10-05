<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Auth;

class Team extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'profile_heading', 'description'];
    public $localeKey;
    protected $fillable = ['image', 'status', 'created_by', 'updated_by'];

    const TEAM_DIR          = 'images/team/original/';
    const TEAM_THUMB_DIR    = 'images/team/thumb/';

    /*
     * Get list of all team.
     */
    public function getAllTeam() {
        if(request()->has('recordPerPage')) {
            request()->session()->put('recordPerPage', request()->get('recordPerPage'));
            $this->setPerPage(request()->session()->get('recordPerPage'));
        } else if(request()->session()->has('recordPerPage')) {
            $this->setPerPage(request()->session()->get('recordPerPage'));
        }

        $team   = Team::select('*');
        if(request()->has('search')) {
            $team   = $team->whereTranslationLike('name', '%'. request()->get('search') .'%');
        }

        return $team->paginate();
    }

    /*
     * Save new team.
     */
    public function saveTeam($data = array()) {
        if(empty($data)) {
            return false;
        }

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
     * Update team
     */
    public function updateTeam($id, $data = array()) {
        if(empty($data)) {
            return false;
        }

        $teamData   = array();
        foreach (request()->session()->get('languages') as $lang => $language) {
            foreach($this->translatedAttributes as $field) {
                $teamData[$lang][$field]    = $data[$lang . '_' . $field];
            }
        }

        $teamData['image']      = $data['image'];
        $teamData['status']     = $data['status'];
        $teamData['updated_by'] = Auth::user()->id;

        $team   = Team::find($id);
        if($team->update($teamData)) {
            return true;
        }

        return false;
    }

    /*
     * Get original team image path.
     */
    public static function getDir() {
        return public_path(self::TEAM_DIR);
    }

    /*
     * Get thumb team image path.
     */
    public static function getThumbDir() {
        return public_path(self::TEAM_THUMB_DIR);
    }

}
