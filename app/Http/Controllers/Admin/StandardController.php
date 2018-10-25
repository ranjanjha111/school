<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Standard;
use Image;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $standard   = new Standard();
        $result     = $standard->getAllStandard();

        if (request()->ajax()) {
            return view('admin.standard.load', ['result' => $result])->render();
        }

        return view('admin.standard.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.standard.new');
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
            'name'          => 'required',
            'description'   => 'required'
        ];
        $validation     = [
            'banner'    => 'required|mimes:png,jpg,jpeg|max:2048',
            'age_from'  => 'required|numeric',
            'age_to'    => 'required|numeric',
            'size'      => 'required|numeric',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        //Verify the banner image exists
        if($request->hasfile('banner')) {
            $file       = $request->file('banner');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Standard::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Standard::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(Standard::getThumbDir() . $fileName);

            $data['banner']   = $fileName;
        }

        $standard   = new Standard();
        if($standard->saveStandard($data)) {
            $request->session()->flash('success', 'Class created successfully.');
            return redirect()->route('classes.index');
        } else {
            $request->session()->flash('danger', 'Class could not be created. Please try again.');
            return redirect()->route('classes.create');
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
        $standard   = Standard::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.standard.show', ['standard' => $standard, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.standard.show', compact('standard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $standard   = Standard::findOrFail($id);
        return view('admin.standard.edit', compact('standard'));
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
            'name'          => 'required',
            'description'   => 'required'
        ];
        $validation     = [
            'banner'    => 'mimes:png,jpg,jpeg|max:2048',
            'age_from'  => 'required|numeric',
            'age_to'    => 'required|numeric',
            'size'      => 'required|numeric',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data       = $request->all();
        $standard   = Standard::findOrFail($id);
        //Verify the profile image exists
        if($request->hasfile('banner')) {
            $file       = $request->file('banner');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Standard::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Standard::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(Standard::getThumbDir() . $fileName);

            //Remove old image.
            if (file_exists(Standard::getDir() . $standard->banner)) {
                unlink(Standard::getDir() . $standard->banner);
                unlink(Standard::getThumbDir() . $standard->banner);
            }

            $data['banner']  = $fileName;
        } else{
            $data['banner']  = $standard->banner;
        }

        $standard   = new Standard();
        if($standard->updateFeatured($id, $data)) {
            $request->session()->flash('success', 'Class updated successfully.!');
            return redirect()->route('classes.index');
        } else {
            $request->session()->flash('danger', 'Class could not be updated. Please try again.');
            return redirect()->route('classes.index');
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
        $standard   = Standard::findOrFail($id);
        $imageName  = $standard->banner;
        if($standard->delete()) {
            if(file_exists(public_path(Standard::ORIGINAL_DIR . $imageName))) {
                unlink(Standard::getDir() . $imageName);
                unlink(Standard::getThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'Class deleted successfully.');
            return redirect()->route('classes.index');
        }else {
            request()->session()->flash('danger', 'Class could not be deleted. Please try again.');
            return redirect()->route('classes.index');
        }

        return redirect()->back();
    }
}
