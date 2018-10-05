<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Team;
use Image;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team   = new Team();
        $result = $team->getAllTeam();

        if (request()->ajax()) {
            return view('admin.team.load', ['result' => $result])->render();
        }

        return view('admin.team.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.team.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $langValidation = [
            'name'              => 'required',
            'profile_heading'   => 'required',
            'description'       => 'required',
        ];
        $validation     = [
            'image'     => 'required|mimes:png,jpg,jpeg|max:2048',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        //Verify the profile image exists
        if($request->hasfile('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Team::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Team::getDir() . $fileName);
            $image->resize(220, 220);
            $image->save(Team::getThumbDir() . $fileName);

            $data['image']   = $fileName;
        }


        $team   = new Team();
        $result = $team->saveTeam($data);
        if($result) {
            $request->session()->flash('success', 'Team profile created successfully.');
            return redirect()->route('teams.index');
        } else {
            $request->session()->flash('danger', 'Team profile could not be created. Please try again.');
            return redirect()->route('teams.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team   = Team::find($id);

        if (request()->ajax()) {
            return view('admin.team.show', ['team' => $team, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team   = Team::find($id);
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $langValidation = [
            'name'              => 'required',
            'profile_heading'   => 'required',
            'description'       => 'required',
        ];
        $validation     = [
            'image'     => 'mimes:png,jpg,jpeg|max:2048',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        $team   = Team::find($id);
        //Verify the profile image exists
        if($request->hasfile('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Team::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Team::getDir() . $fileName);
            $image->resize(220, 220);
            $image->save(Team::getThumbDir() . $fileName);

            //Remove old image.
            if (file_exists(Team::getDir() . $team->image)) {
                unlink(Team::getDir() . $team->image);
                unlink(Team::getThumbDir() . $team->image);
            }

            $data['image']  = $fileName;
        } else{
            $data['image']  = $team->image;
        }

        $team   = new Team();
        if($team->updateTeam($id, $data)) {
            $request->session()->flash('success', 'Team updated successfully.!');
            return redirect()->route('teams.index');
        } else {
            $request->session()->flash('danger', 'Team could not be updated. Please try again.');
            return redirect()->route('teams.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team       = Team::find($id);
        $imageName  = $team->image;
        if(Team::find($id)->delete()) {
            if(file_exists(public_path(Team::TEAM_DIR . $imageName))) {
                unlink(Team::getDir() . $imageName);
                unlink(Team::getThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'Team deleted successfully.');
            return redirect()->route('teams.index');
        }else {
            request()->session()->flash('danger', 'Team could not be deleted. Please try again.');
            return redirect()->route('teams.index');
        }

        return redirect()->back();
    }
}
