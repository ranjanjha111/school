<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\School;
use App\ImageGallery;
use Image;

class ImageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery    = new ImageGallery();
        $result     = $gallery->getAllImage();
        if (request()->ajax()) {
            return view('admin.image_gallery.load', ['result' => $result])->render();
        }

        return view('admin.image_gallery.index', compact('result'));
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

        return view('admin.image_gallery.new', compact('schoolList'));
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
            $file->move(ImageGallery::getDir(), $fileName);

            //Resize image
            $image  = Image::make(ImageGallery::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(ImageGallery::getThumbDir() . $fileName);

            $data['image']   = $fileName;
        }

        $gallery   = new ImageGallery();
        if($gallery->saveGallery($data)) {
            $request->session()->flash('success', 'Image created successfully.');
            return redirect()->route('image_galleries.index');
        } else {
            $request->session()->flash('danger', 'Image could not be created. Please try again.');
            return redirect()->route('image_galleries.create');
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
        $gallery    = ImageGallery::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.image_gallery.show', ['gallery' => $gallery, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.image_gallery.show', compact('gallery'));
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

        $gallery    = ImageGallery::find($id);
        return view('admin.image_gallery.edit', compact('gallery', 'schoolList'));
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
        $gallery    = ImageGallery::findOrFail($id);
        //Verify the profile image exists
        if($request->hasfile('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(ImageGallery::getDir(), $fileName);

            //Resize image
            $image  = Image::make(ImageGallery::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(ImageGallery::getThumbDir() . $fileName);

            //Remove old image.
            if (file_exists(ImageGallery::getDir() . $gallery->image)) {
                unlink(ImageGallery::getDir() . $gallery->image);
                unlink(ImageGallery::getThumbDir() . $gallery->image);
            }

            $data['image']  = $fileName;
        } else{
            $data['image']  = $gallery->image;
        }

        $gallery    = new ImageGallery();
        if($gallery->updateGallery($id, $data)) {
            $request->session()->flash('success', 'Image updated successfully.!');
            return redirect()->route('image_galleries.index');
        } else {
            $request->session()->flash('danger', 'Image could not be updated. Please try again.');
            return redirect()->route('image_galleries.index');
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
        $gallery    = ImageGallery::findOrFail($id);
        $imageName  = $gallery->image;
        if(ImageGallery::findOrFail($id)->delete()) {
            if(file_exists(public_path(ImageGallery::ORIGINAL_DIR . $imageName))) {
                unlink(ImageGallery::getDir() . $imageName);
                unlink(ImageGallery::getThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'Image deleted successfully.');
            return redirect()->route('image_galleries.index');
        }else {
            request()->session()->flash('danger', 'Image could not be deleted. Please try again.');
            return redirect()->route('image_galleries.index');
        }

        return redirect()->back();
    }
}
