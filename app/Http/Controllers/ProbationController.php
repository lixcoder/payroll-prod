<?php

namespace App\Http\Controllers;

use App\Models\Probation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProbationController extends Controller
{
    //
    public function index()
    {
        $probations = Probation::where('organization_id',Auth::user()->organization_id)->get();
        return view('probation.index',compact('probations'));
    }
    public function store(Request  $request)
    {
        $validate = Validator::make($request->all(),[
            'period'=>'required',
        ]);
        if ($validate->fails())
        {
            toast('All Fields are required','warning','top-right');
        }
        else{
            $probation = new Probation();
            $probation->period = $request->period;
            $probation->organization_id = Auth::user()->organization_id;
            $probation->save();
            if ($probation)
            {
                toast('Success','success','top-right');
            }
        }
        return redirect()->back();
    }
    public function update(Request  $request)
    {
        $probation = Probation::where('id',$request->id)->findOrFail($request->id);
        $probation->period = $request->period;
        $probation->push();
        if ($probation)
        {
            toast('Success','info','top-right');
        }
        return redirect()->back();
    }
    public function getProbation()
    {
        $probation =  Probation::where('organization_id',Auth::user()->organization_id)->get();
        count($probation) > 0 ? $success = 1: $success=0;
        return response()->json(['probation'=>$probation,'success'=>$success]);
    }
}
