<?php

namespace App\Http\Controllers;

use App\Models\PersonalRelief;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class PersonalReliefController extends Controller
{
    /**
     * Display a listing of personal relief rates
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $reliefRates = DB::table('x_tax_relief')->where('organization_id', Auth::user()->organization_id)->get();
        return View::make('personal_relief.index', compact('reliefRates'));
    }

    /**
     * Show the form for creating a new personal relief rate
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('personal_relief.create');
    }

    /**
     * Store a newly created personal relief rate in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = request()->all(), PersonalRelief::$rules, PersonalRelief::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $reliefRate = new PersonalRelief;
        $reliefRate->amount = request('amount');
        $reliefRate->organization_id = Auth::user()->organization_id;
        $reliefRate->save();

        return Redirect::route('personalrelief.index');
    }

    /**
     * Display the specified personal relief rate.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $reliefRate = PersonalRelief::findOrFail($id);
        return View::make('personal_relief.show', compact('reliefRate'));
    }

    /**
     * Show the form for editing the specified personal relief rate.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $reliefRate = PersonalRelief::find($id);
        return View::make('personal_relief.edit', compact('reliefRate'));
    }

    /**
     * Update the specified personal relief rate in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $reliefRate = PersonalRelief::findOrFail($id);
        $validator = Validator::make($data = request()->all(), PersonalRelief::$rules, PersonalRelief::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $reliefRate->amount = request('amount');
        $reliefRate->update();

        return Redirect::route('personalrelief.index');
    }

    /**
     * Remove the specified personal relief rate from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        PersonalRelief::destroy($id);
        return Redirect::route('personalrelief.index');
    }
}
