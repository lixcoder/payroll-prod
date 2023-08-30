<?php

namespace App\Http\Controllers;

use App\Models\HousingLevy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class HousingLevyController extends Controller
{
    
    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $hrates = DB::table('housing_levy')->get();
      

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
        $validator = Validator::make($data = request()->all(), HousingLevy::$rules,HousingLevy::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $hrate = new HousingLevy;

        $hrate->percentage = request('percentage');

        $hrate->organization_id = '1';

        $hrate->save();

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
    public function update($id)
    {
        $hrate = HousingLevy::findOrFail($id);

        $validator = Validator::make($data = request()->all(), HousingLevy::$rules,HousingLevy::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $hrate->percentage = request('percentage');

        $hrate->update();
        return Redirect::route('housinglevy.index');
    }

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
