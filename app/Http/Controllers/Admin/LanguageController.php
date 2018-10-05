<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Lang;
use Image;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $language   = new Language();
        $result     = $language->getAllLanguage();
        if (request()->ajax()) {
            return view('admin.language.load', ['result' => $result])->render();
        }

        return view('admin.language.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.language.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|min:2',
            'code'  => 'required|max:4',
            'flag'  => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $data   = $request->all();
        //Verify the flag image exists
        if($request->hasfile('flag')) {
            $file       = $request->file('flag');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time().'.'.$extension;
            $file->move(Language::getLanguageDir(), $fileName);

            //Resize image
            $image  = Image::make(Language::getLanguageDir() . $fileName);
            $image->resize(25, 20);
            $image->save(Language::getLanguageThumbDir() . $fileName);

            $data['flag']   = $fileName;
        }

        $language   = new Language();
        $result     = $language->saveLanguage($data);
        // Create the gallery
        if($result) {
            $request->session()->flash('success', 'Language created successfully.!');
            return redirect()->route('languages.index');
        } else {
            $request->session()->flash('danger', 'Language could not be created. Please try again.');
            return redirect()->route('languages.create');
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
        $language = Language::find($id);
        if (request()->ajax()) {
            return view('admin.language.show', ['language' => $language, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }
        return view('admin.language.showback', compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = Language::find($id);
        return view('admin.language.edit', compact('language'));
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
        $this->validate($request, [
            'name'  => 'required|min:2',
            'code'  => 'required|max:4|unique:languages,code,' . $id,
            'flag'  => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $data   = $request->all();
        if(!isset($data['is_default']) && !Language::canUpdateIsDefault($id)) {
            return redirect()->route('languages.index');
        }

        $language   = Language::find($id);
        if($request->hasfile('flag'))
        {
            $file       = $request->file('flag');
            $fileName   = time() . '.' . $file->getClientOriginalExtension();
            $file->move(Language::getLanguageDir(), $fileName);

            //Resize image
            $image  = Image::make(Language::getLanguageDir() . $fileName);
            $image->resize(25, 20);
            $image->save(Language::getLanguageThumbDir() . $fileName);

            //Remove old image.
            if (file_exists(Language::getLanguageDir() . $language->flag)) {
                unlink(Language::getLanguageDir() . $language->flag);
                unlink(Language::getLanguageThumbDir() . $language->flag);
            }

            $data['flag']   = $fileName;
        } else{
            $data['flag']   = $language->flag;
        }

        $language   = new Language();
        if($language->updateLanguage($id, $data)) {
            $request->session()->flash('success', 'Language updated successfully.!');
            return redirect()->route('languages.index');
        } else {
            $request->session()->flash('danger', 'Language could not be updated. Please try again.');
            return redirect()->route('languages.index');
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
        $language   = Language::find($id);
        $imageName  = $language->flag;

        if($language->is_default) {
            request()->session()->flash('danger', 'Default language can not be deleted.');
            return redirect()->back();
        }

        if(Language::findOrFail($id)->delete()) {
            if(file_exists(public_path(Language::LANGUAGE_DIR . $imageName))) {
                unlink(Language::getLanguageDir() . $imageName);
                unlink(Language::getLanguageThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'Language deleted successfully.');
            return redirect()->route('languages.index');
        }else {
            request()->session()->flash('danger', 'Language could not be deleted. Please try again.');
            return redirect()->route('languages.index');
        }

        return redirect()->back();
    }
}
