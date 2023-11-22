<?php
namespace App\Http\Controllers;

use App\Models\NhifRates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class NhifController extends BaseController {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $nrates = DB::table('x_hospital_insurance')->where('organization_id', Auth::user()->organization_id)->get();
//		$nrates = DB::table('x_hospital_insurance')->where('income_from', '!=', 0)->get();
//        dd($nrates);

        return View::make('nhif.index', compact('nrates'));
    }

    //confirmation url for mpesa C2B
    public function confirmation(){
        
        header("Content-Type: application/json");
        $res = file_get_contents('php://input');

        $data = json_decode($res, true);

        // Access the TransAmount
        $transAmount = $data['TransAmount'];
        $phone = $data['MSISDN'];

        //remove first three characters
        $phone = substr($phone, 3);
        // Log the $data variable to a dtabase table
            DB::table('test_details')->insert([
                'id' => $data['TransID'],                             
                'all' => $transAmount,     
            ]);
        $count = DB::table('packages')->where('price',$transAmount)
                            ->count();
        $count2 = DB::table('business_locations')
                ->where('mobile', 'like', '%' . $phone)
                ->count();
        if($count>0 && $count2 >0){
            $result = json_encode(["ResultCode"=>"0", "ResultDesc"=>"Accepted"]);
            $response = new Response();
            $response->headers->set("Content-Type", "application/json; charset=utf-8");
            $response->setContent($result);
            return $response;
        }
        else{
            $result = json_encode(["ResultCode"=>"C2B00011", "ResultDesc"=>"Rejected"]);
            $response = new Response();
            $response->headers->set("Content-Type", "application/json; charset=utf-8");
            $response->setContent($result);
            return $response;
        }
    }

    //function to recieve json from mpesa
    public function recieveJson(){
        return Auth::user()->organization_id;
        // header("Content-Type: application/json");
        // $res = file_get_contents('php://input');

        // $data = json_decode($res, true);

        // // Access the TransactionID
        // $transactionID = $data['Result']['TransactionID'];
        // // Log the $data variable to a log file
        //     DB::table('test_details')->insert([
        //         'id' => 12353,                             
        //         'all' => $transactionID,     
        //     ]);



    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('nhif.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
//        dd(request('amount'));
        $validator = Validator::make($data = request()->all(), NhifRates::$rules,NhifRates::$messages);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nrate = new NhifRates;

        $nrate->income_from = request('minimum');

        $nrate->income_to = request('maximum');

        $nrate->hi_amount = request('contribution');

        $nrate->organization_id = Auth::user()->organization_id;

        $nrate->save();

//		return Redirect::route('nhif.index');
        return redirect()->route('nhif.index');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $nrate = NhifRates::findOrFail($id);

        return View::make('nhif.show', compact('nrate'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $nrate = NhifRates::find($id);

        return View::make('nhif.edit', compact('nrate'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $nrate = NhifRates::findOrFail($id);

        $validator = Validator::make($data = request()->all(), NhifRates::$rules,NhifRates::$messages);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nrate->income_from = request('income_from');

        $nrate->income_to = request('income_to');

        $nrate->hi_amount = request('hi_amount');

        $nrate->update();

        return redirect()->route('nhif.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        NhifRates::destroy($id);

        return redirect()->route('nhif.index');
    }

}
