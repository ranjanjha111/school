<?php

namespace App\Http\Controllers\Admin;

use App\School;
use Illuminate\Http\Request;
use App\Featured;
use Image;

class FeaturedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featured   = new Featured();
        $result     = $featured->getAllFeatured();

        if (request()->ajax()) {
            return view('admin.featured.load', ['result' => $result])->render();
        }

        return view('admin.featured.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school     = new School();
        $schoolList = $school->getSchoolList();

        return view('admin.featured.new', compact('schoolList'));
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
            'title' => 'required'
        ];
        $validation     = [
            'school_id' => 'required',
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
            $file->move(Featured::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Featured::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(Featured::getThumbDir() . $fileName);

            $data['image']   = $fileName;
        }

        $featured   = new Featured();
        if($featured->saveFeatured($data)) {
            $request->session()->flash('success', 'Featured created successfully.');
            return redirect()->route('featureds.index');
        } else {
            $request->session()->flash('danger', 'Featured could not be created. Please try again.');
            return redirect()->route('featureds.create');
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
        $featured   = Featured::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.featured.show', ['featured' => $featured, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.featured.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school     = new School();
        $schoolList = $school->getSchoolList();

        $featured   = Featured::find($id);
        return view('admin.featured.edit', compact('featured', 'schoolList'));
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
            'title' => 'required',
        ];
        $validation     = [
            'school_id' => 'required',
            'image'     => 'mimes:png,jpg,jpeg|max:2048',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data       = $request->all();
        $featured   = Featured::findOrFail($id);
        //Verify the profile image exists
        if($request->hasfile('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Featured::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Featured::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(Featured::getThumbDir() . $fileName);

            //Remove old image.
            if (file_exists(Featured::getDir() . $featured->image)) {
                unlink(Featured::getDir() . $featured->image);
                unlink(Featured::getThumbDir() . $featured->image);
            }

            $data['image']  = $fileName;
        } else{
            $data['image']  = $featured->image;
        }

        $featured   = new Featured();
        if($featured->updateFeatured($id, $data)) {
            $request->session()->flash('success', 'Featured updated successfully.!');
            return redirect()->route('featureds.index');
        } else {
            $request->session()->flash('danger', 'Featured could not be updated. Please try again.');
            return redirect()->route('featureds.index');
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
        $featured   = Featured::findOrFail($id);
        $imageName  = $featured->image;
        if(Featured::findOrFail($id)->delete()) {
            if(file_exists(public_path(Featured::ORIGINAL_DIR . $imageName))) {
                unlink(Featured::getDir() . $imageName);
                unlink(Featured::getThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'Featured deleted successfully.');
            return redirect()->route('featureds.index');
        }else {
            request()->session()->flash('danger', 'Featured could not be deleted. Please try again.');
            return redirect()->route('featureds.index');
        }

        return redirect()->back();
    }
}
