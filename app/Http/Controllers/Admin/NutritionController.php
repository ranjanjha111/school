<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Nutrition;

class NutritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nutrition  = new Nutrition();
        $result     = $nutrition->getAllNutrition();

        if (request()->ajax()) {
            return view('admin.nutrition.load', ['result' => $result])->render();
        }

        return view('admin.nutrition.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nutrition.new');
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

        $nutrition  = new Nutrition();
        if($nutrition->saveNutrition($request->all())) {
            $request->session()->flash('success', 'Nutrition created successfully.');
            return redirect()->route('nutritions.index');
        } else {
            $request->session()->flash('danger', 'Nutrition could not be created. Please try again.');
            return redirect()->route('nutritions.create');
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
        $nutrition  = Nutrition::find($id);
        if (request()->ajax()) {
            return view('admin.nutrition.show', ['nutrition' => $nutrition, 'id' => $id, 'modalClass' => request()->get('modalClass')])->render();
        }

        return view('admin.nutrition.show', compact('nutrition'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nutrition  = Nutrition::find($id);
        return view('admin.nutrition.edit', compact('nutrition'));
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

        $nutrition  = new Nutrition();
        if($nutrition->updateNutrition($id, $request->all())) {
            $request->session()->flash('success', 'Nutrition updated successfully.');
            return redirect()->route('nutritions.index');
        } else {
            $request->session()->flash('danger', 'Nutrition could not be updated.');
            return redirect()->route('nutritions.index');
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
        if(Nutrition::findOrFail($id)->delete()) {
            request()->session()->flash('success', 'Nutrition deleted successfully.');
        } else {
            request()->session()->flash('danger', 'Nutrition could not be deleted.');
        }

        return redirect()->back();
    }
}
