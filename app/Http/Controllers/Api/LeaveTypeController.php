<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Leavetype;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        try {
            $leavetypes = Leavetype::all();
            return response()->json(['data' => $leavetypes], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch leave types. ' . $e->getMessage()], 500);
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
        try {
            $leavetype = Leavetype::findOrFail($id);
            return response()->json(['data' => $leavetype], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Leave type not found. ' . $e->getMessage()], 404);
        }
    }
}
