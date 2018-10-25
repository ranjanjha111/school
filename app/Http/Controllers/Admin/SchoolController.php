<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\School;
use App\State;
use App\City;
use Image;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school     = new School();
        $result     = $school->getAllSchool();

        if (request()->ajax()) {
            return view('admin.school.load', ['result' => $result])->render();
        }

        return view('admin.school.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state      = new State();
        $stateList  = $state->getStateList();

        $city_id     = array('' => 'Select a city');

        return view('admin.school.new', compact('stateList', 'city_id'));
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
            'name'      => 'required',
            'locality'  => 'required',
            'address'   => 'required'
        ];
        $validation     = [
            'email'     => 'required|email|unique:schools,email',
            'mobile'    => 'required|digits:10|unique:schools,mobile',
            'fax'       => 'required|digits:10|unique:schools,fax',
            'image' 	=> 'image|mimes:jpeg,png,jpg|max:2048',
            'state_id'  => 'required|numeric',
            'city_id'   => 'required|numeric',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        //Verify the profile image exists
        if($request->hasfile('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(School::getDir(), $fileName);

            //Resize image
            $image  = Image::make(School::getDir() . $fileName);
            $image->resize(187, 187);
            $image->save(School::getThumbDir() . $fileName);

            $data['image']   = $fileName;
        }

        $school = new School();
        if($school->saveSchool($data)) {
            $request->session()->flash('success', 'School added successfully.');
            return redirect()->route('schools.index');
        } else {
            $request->session()->flash('danger', 'School could not be added. Please try again.');
            return redirect()->route('schools.create');
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
        $school = School::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.school.show', ['school' => $school, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.school.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school     = School::findOrFail($id);
        $state      = new State();
        $stateList  = $state->getStateList();
        $city       = new City();
        $city_id    = array('' => 'Select a city') + $city->getCityByStateId($school->state_id);

        return view('admin.school.edit', compact('school', 'stateList', 'city_id'));
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
            'name'      => 'required',
            'locality'  => 'required',
            'address'   => 'required'
        ];
        $validation     = [
            'email'     => 'required|email|unique:schools,email,' . $id,
            'mobile'    => 'required|digits:10|unique:schools,mobile,' . $id,
            'fax'       => 'required|digits:10|unique:schools,fax,' . $id,
            'image' 	=> 'image|mimes:jpeg,png,jpg|max:2048',
            'state_id'  => 'required|numeric',
            'city_id'   => 'required|numeric',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        $school = School::FindOrFail($id);
        //Verify the profile image exists
        if($request->hasfile('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(School::getDir(), $fileName);

            //Resize image
            $image  = Image::make(School::getDir() . $fileName);
            $image->resize(220, 220);
            $image->save(School::getThumbDir() . $fileName);

            //Remove old image.
            if (file_exists(School::getDir() . $school->image)) {
                unlink($school::getDir() . $school->image);
                unlink($school::getThumbDir() . $school->image);
            }

            $data['image']  = $fileName;
        } else{
            $data['image']  = $school->image;
        }

        $school = new School();
        if($school->updateSchool($id, $data)) {
            $request->session()->flash('success', 'School updated successfully.!');
            return redirect()->route('schools.index');
        } else {
            $request->session()->flash('danger', 'School could not be updated. Please try again.');
            return redirect()->route('schools.index');
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
        $school     = School::findOrFail($id);
        $imageName  = $school->image;
        if(School::findOrFail($id)->delete()) {
            if(file_exists(public_path(School::ORIGINAL_DIR . $imageName))) {
                unlink(School::getDir() . $imageName);
                unlink(School::getThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'School deleted successfully.');
            return redirect()->route('schools.index');
        }else {
            request()->session()->flash('danger', 'School could not be deleted. Please try again.');
            return redirect()->route('schools.index');
        }

        return redirect()->back();
    }
}
