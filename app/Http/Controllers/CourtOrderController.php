<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\CourtOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class CourtOrderController extends Controller {

    /*
     * Display a listing of court orders
     *
     * @return Response
     */
    public function index()
    {
        $court_orders = CourtOrder::whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id)
            ->get();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'view', 'viewed court orders');

        return View::make('court_orders.index', compact('court_orders'));
    }

    /*
     * Show the form for creating a new court order
     *
     * @return Response
     */
    public function create()
    {
        return View::make('court_orders.create');
    }

    /*
     * Store a newly created court order in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $data = $request->all(),
            CourtOrder::$rules,
            CourtOrder::$messages
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $court_order = new CourtOrder;

        $court_order->order_number    = $request->get('order_number');
        $court_order->description     = $request->get('description');
        $court_order->effective_date  = $request->get('effective_date');
        $court_order->organization_id = Auth::user()->organization_id;

        $court_order->save();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'create', 'created court order: ' . $court_order->order_number);

        return Redirect::route('court_orders.index')->withFlashMessage('Court Order successfully created!');
    }

    /*
     * Display the specified court order
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $court_order = CourtOrder::findOrFail($id);

        return View::make('court_orders.show', compact('court_order'));
    }

    /*
     * Show the form for editing the specified court order
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $court_order = CourtOrder::find($id);

        return View::make('court_orders.edit', compact('court_order'));
    }

    /*
     * Update the specified court order in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $court_order = CourtOrder::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'order_number' => [
                'required',
                Rule::unique('court_orders', 'order_number')->ignore($id),
            ],
            'description' => 'required',
            'effective_date' => 'required|date',
        ], CourtOrder::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $court_order->order_number   = $request->get('order_number');
        $court_order->description    = $request->get('description');
        $court_order->effective_date = $request->get('effective_date');
        $court_order->update();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'update', 'updated court order: ' . $court_order->order_number);

        return Redirect::route('court_orders.index')->withFlashMessage('Court Order successfully updated!');
    }

    /*
     * Remove the specified court order from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $court_order = CourtOrder::findOrFail($id);

        // Check if the court order is assigned to any employees
        $assigned = DB::table('employee_court_orders')->where('court_order_id', $id)->count();

        if ($assigned > 0) {
            return Redirect::route('court_orders.index')->withDeleteMessage('Cannot delete this court order because it is assigned to an employee(s)!');
        } else {
            CourtOrder::destroy($id);

            Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'delete', 'deleted court order: ' . $court_order->order_number);

            return Redirect::route('court_orders.index')->withDeleteMessage('Court Order successfully deleted!');
        }
    }

}
