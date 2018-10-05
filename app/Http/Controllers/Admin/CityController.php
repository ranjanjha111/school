<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\State;
use App\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city   = new City();
        $result = $city->getAllCity();

        if (request()->ajax()) {
            return view('admin.city.load', ['result' => $result])->render();
        }

        return view('admin.city.index', compact('result'));
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

        return view('admin.city.new', compact('stateList'));
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
            'state_id'  => 'required|numeric',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $city  = new City();
        $result = $city->saveCity($request->all());
        if($result) {
            $request->session()->flash('success', 'City created successfully.');
            return redirect()->route('city.index');
        } else {
            $request->session()->flash('danger', 'City could not be created. Please try again.');
            return redirect()->route('city.create');
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
        $city  = City::find($id);

        if (request()->ajax()) {
            return view('admin.city.show', ['city' => $city, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state      = new State();
        $stateList  = $state->getStateList();
        $city       = City::find($id);
        return view('admin.city.edit', compact('city', 'stateList'));
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
            'state_id'  => 'required|numeric',
            'status'    => 'required'
        ];
        $this->validateTranslator($request, $langValidation, $validation);

        $city   = new City();
        $result = $city->updateCity($id, $request->all());
        if($result) {
            $request->session()->flash('success', 'City updated successfully.');
            return redirect()->route('city.index');
        } else {
            $request->session()->flash('danger', 'City coult not be updated.');
            return redirect()->route('city.index');
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
        if(City::findOrFail($id)->delete()) {
            request()->session()->flash('success', 'City deleted successfully.');
        } else {
            request()->session()->flash('danger', 'City could not be deleted.');
        }

        return redirect()->back();
    }
}
