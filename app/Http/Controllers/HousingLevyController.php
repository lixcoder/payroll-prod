<?php

namespace App\Http\Controllers;

use App\Models\HousingLevy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class HousingLevyController extends Controller
{
    
    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $hrates = DB::table('housing_levy')->where('organization_id', Auth::user()->organization_id)->get();
      

        return View::make('housinglevy.index', compact('hrates'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('housinglevy.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
public function store()
{
    $validator = Validator::make(request()->all(), HousingLevy::$rules, HousingLevy::$messages);

    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput();
    }

    $hrate = new HousingLevy;
    $hrate->employee_rate = request('employee_rate');
    $hrate->employer_rate = request('employer_rate');
    $hrate->organization_id = Auth::user()->organization_id;
    $hrate->save();

    return Redirect::route('housinglevy.index');
}

public function update(Request $request, $id)
{
    $hrate = HousingLevy::findOrFail($id);

    $validator = Validator::make($request->all(), HousingLevy::$rules, HousingLevy::$messages);

    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput();
    }

    $hrate->employee_rate = $request->input('employee_rate');
    $hrate->employer_rate = $request->input('employer_rate');
    $hrate->update();

    return Redirect::route('housinglevy.index');
}


    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $hrate = HousingLevy::findOrFail($id);

        return View::make('housing.show', compact('hrate'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $hrate = HousingLevy::find($id);

        return View::make('housinglevy.edit', compact('hrate'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */


    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        HousingLevy::destroy($id);

        return Redirect::route('housinglevy.index');
    }
}
