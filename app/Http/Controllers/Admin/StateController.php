<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\State;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = State::latest()->paginate(10);
        return view('admin.state.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.state.new');
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
            'name' => 'required'
        ];
        $validation     = [
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $data   = $request->all();
        $state  = new State();
        $result = $state->saveState($data);
        // Create the gallery
        if($result) {
            $request->session()->flash('success', 'State created successfully.');
            return redirect()->route('states.index');
        } else {
            $request->session()->flash('danger', 'State could not be created. Please try again.');
            return redirect()->route('states.create');
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
        $state  = State::find($id);
        return view('admin.state.show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state  = State::find($id);
        return view('admin.state.edit', compact('state'));
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
            'name' => 'required'
        ];
        $validation     = [
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $state  = new State();
        $result = $state->updateState($id, $request->all());
        if($result) {
            $request->session()->flash('success', 'State updated successfully.');
            return redirect()->route('states.index');
        } else {
            $request->session()->flash('danger', 'State coult not be updated.');
            return redirect()->route('states.index');
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
        if(State::findOrFail($id)->delete()) {
            request()->session()->flash('success', 'State deleted successfully.');
        } else {
            request()->session()->flash('danger', 'State could not be deleted.');
        }

        return redirect()->back();
    }
}
