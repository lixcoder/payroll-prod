<?php

namespace App\Http\Controllers;


use App\Models\NssfRates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class NssfController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $nrates = DB::table('x_social_security')->whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        //$nrates = DB::table('x_social_security')->where('income_from', '!=', 0.00)->get();

        return View::make('nssf.index', compact('nrates'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('nssf.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = request()->all(), NssfRates::$rules,NssfRates::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $nrate = new NssfRates;

        $nrate->employee_contribution = request('employee_contribution');

        $nrate->employer_contribution = request('employer_contribution');

        $nrate->total_contribution = request('total_contribution');

        $nrate->max_employee_nssf = request('max_employee_nssf');

        $nrate->max_employer_nssf = request('max_employer_nssf');

        $nrate->nssf_lower_earning = request('nssf_lower_earning');

        $nrate->nssf_upper_earning = request('nssf_upper_earning');

        $nrate->employer_nssf_upper_earning = request('employer_nssf_upper_earning');

        $nrate->graduated_scale = request('graduated_scale');

        $nrate->organization_id = Auth::user()->organization_id;

        $nrate->save();

        return Redirect::route('nssf.index');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $nrate = NssfRates::findOrFail($id);

        return View::make('nssf.show', compact('nrate'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $nrate = NssfRates::find($id);

        return View::make('nssf.edit', compact('nrate'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $nrate = NssfRates::findOrFail($id);

        $validator = Validator::make($data = request()->all(), NssfRates::$rules,NssfRates::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $nrate->employee_contribution = request('employee_contribution');

        $nrate->employer_contribution = request('employer_contribution');

        $nrate->total_contribution = request('total_contribution');

        $nrate->max_employee_nssf = request('max_employee_nssf');

        $nrate->max_employer_nssf = request('max_employer_nssf');

        $nrate->nssf_lower_earning = request('nssf_lower_earning');

        $nrate->nssf_upper_earning = request('nssf_upper_earning');

        $nrate->employer_nssf_upper_earning = request('employer_nssf_upper_earning');

        $nrate->graduated_scale = request('graduated_scale');

        $nrate->update();
        return Redirect::route('nssf.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        NssfRates::destroy($id);

        return Redirect::route('nssf.index');
    }

}
