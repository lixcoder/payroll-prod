<?php

namespace App\Http\Controllers;
 
use App\Models\PayeRate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class PayeController extends Controller
{
     /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $prates = DB::table('paye')
                 ->where('organization_id', Auth::user()->organization_id)
                 ->get();


        return View::make('paye.index', compact('prates'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('paye.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
//        dd(request('amount'));
        $validator = Validator::make($data = request()->all(), PayeRate::$rules,PayeRate::$messages);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $prate = new PayeRate;

        $prate->income_from = request('income_from');

        $prate->income_to = request('income_to');

        $prate->percentage = request('percentage');

        $prate->organization_id = Auth::user()->organization_id;

        $prate->save();

//		return Redirect::route('paye.index');
        return redirect()->route('paye.index');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $prate = PayeRate::findOrFail($id);

        return View::make('paye.show', compact('prate'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $prate = PayeRate::find($id);

        return View::make('paye.edit', compact('prate'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $prate = PayeRate::findOrFail($id);

        $validator = Validator::make($data = request()->all(), PayeRate::$rules,PayeRate::$messages);

        if ($validator->fails())
        {

            //return redirect()->back()->withErrors($validator)->withInput();
        }

        //$prate = new PayeRate();

        if(request('i_from') > request('i_to')){
            return redirect()->back()->withErrors("Income to must be greater than income from!!!")->withInput();  
        }
        $prate->income_from = request('i_from');

        $prate->income_to = request('i_to');

        $prate->percentage = request('percentage');

        $prate->update();

        return redirect()->route('paye.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        PayeRate::destroy($id);

        return redirect()->route('paye.index');
    }
}
