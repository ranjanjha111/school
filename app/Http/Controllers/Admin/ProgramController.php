<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Program;
use Image;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $program    = new Program();
        $result     = $program->getAllProgram();

        if (request()->ajax()) {
            return view('admin.program.load', ['result' => $result])->render();
        }

        return view('admin.program.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.program.new');
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
            'banner'    => 'mimes:png,jpg,jpeg|max:2048',
            'time_from' => 'required',
            'time_to'   => 'required',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        //Verify the banner image exists
        if($request->hasfile('banner')) {
            $file       = $request->file('banner');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Program::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Program::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(Program::getThumbDir() . $fileName);

            $data['banner']   = $fileName;
        }

        $program    = new Program();
        if($program->saveProgram($data)) {
            $request->session()->flash('success', 'Program created successfully.');
            return redirect()->route('programs.index');
        } else {
            $request->session()->flash('danger', 'Program could not be created. Please try again.');
            return redirect()->route('programs.create');
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
        $program    = Program::findOrFail($id);
        if (request()->ajax()) {
            return view('admin.program.show', ['program' => $program, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.program.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program    = Program::findOrFail($id);
        return view('admin.program.edit', compact('program'));
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
            'time_from' => 'required',
            'time_to'   => 'required',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data       = $request->all();
        $program    = Program::findOrFail($id);
        //Verify the profile image exists
        if($request->hasfile('banner')) {
            $file       = $request->file('banner');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $file->move(Program::getDir(), $fileName);

            //Resize image
            $image  = Image::make(Program::getDir() . $fileName);
            $image->resize(180, 90);
            $image->save(Program::getThumbDir() . $fileName);

            //Remove old image.
            if ($program->banner && file_exists(Program::getDir() . $program->banner)) {
                unlink(Program::getDir() . $program->banner);
                unlink(Program::getThumbDir() . $program->banner);
            }

            $data['banner']  = $fileName;
        } else{
            $data['banner']  = $program->banner;
        }

        $program    = new Program();
        if($program->updateProgram($id, $data)) {
            $request->session()->flash('success', 'Program updated successfully.!');
            return redirect()->route('programs.index');
        } else {
            $request->session()->flash('danger', 'Program could not be updated. Please try again.');
            return redirect()->route('programs.index');
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
        $program    = Program::findOrFail($id);
        $imageName  = $program->banner;
        if($program->delete()) {
            if(file_exists(public_path(Program::ORIGINAL_DIR . $imageName))) {
                unlink(Program::getDir() . $imageName);
                unlink(Program::getThumbDir() . $imageName);
            }

            request()->session()->flash('success', 'Program deleted successfully.');
            return redirect()->route('programs.index');
        }else {
            request()->session()->flash('danger', 'Program could not be deleted. Please try again.');
            return redirect()->route('programs.index');
        }

        return redirect()->back();
    }
}
