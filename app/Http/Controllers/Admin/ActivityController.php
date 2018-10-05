<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activity   = new Activity();
        $result     = $activity->getAllActivity();
//        $searchBy   = $activity->searchByFields;

        if (request()->ajax()) {
            return view('admin.activity.load', ['result' => $result])->render();
        }

        return view('admin.activity.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activity.new');
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

        $activity   = new Activity();
        if($activity->saveActivity($request->all())) {
            $request->session()->flash('success', 'Activity created successfully.');
            return redirect()->route('activities.index');
        } else {
            $request->session()->flash('danger', 'Activity could not be created. Please try again.');
            return redirect()->route('activities.create');
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
        $activity   = Activity::find($id);
        if (request()->ajax()) {
            return view('admin.activity.show', ['activity' => $activity, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity   = Activity::find($id);
        return view('admin.activity.edit', compact('activity'));
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

        $activity   = new Activity();
        if($activity->updateActivity($id, $request->all())) {
            $request->session()->flash('success', 'Activity updated successfully.');
            return redirect()->route('activities.index');
        } else {
            $request->session()->flash('danger', 'Activity could not be updated.');
            return redirect()->route('activities.index');
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
        if(Activity::findOrFail($id)->delete()) {
            request()->session()->flash('success', 'Activity deleted successfully.');
        } else {
            request()->session()->flash('danger', 'Activity could not be deleted.');
        }

        return redirect()->back();
    }
}
