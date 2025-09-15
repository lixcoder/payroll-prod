<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\CourtOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class CourtOrderController extends Controller
{
    public function index()
    {
        $court_orders = CourtOrder::whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id)
            ->get();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'view', 'viewed court orders');
        return View::make('court_orders.index', compact('court_orders'));
    }

    public function create()
    {
        return View::make('court_orders.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), CourtOrder::$rules, CourtOrder::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // conditional validation
        if ($request->rate_type === 'fixed' && !$request->amount) {
            return Redirect::back()->withErrors(['amount' => 'Amount is required for fixed type'])->withInput();
        }
        if ($request->rate_type === 'percentage' && !$request->percentage) {
            return Redirect::back()->withErrors(['percentage' => 'Percentage is required for percentage type'])->withInput();
        }

        $court_order = new CourtOrder;
        $court_order->order_number    = $request->get('order_number');
        $court_order->order_type      = $request->get('order_type');   // garnishment/attachment/deduction
        $court_order->rate_type       = $request->get('rate_type');    // fixed/percentage
        $court_order->amount          = $request->get('amount');
        $court_order->percentage      = $request->get('percentage');
        $court_order->effective_date  = $request->get('effective_date');
        $court_order->end_date        = $request->get('end_date');
        $court_order->description     = $request->get('description');
        $court_order->organization_id = Auth::user()->organization_id;

        $court_order->save();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'create', 'created court order: ' . $court_order->order_number);
        return Redirect::route('court_orders.index')->withFlashMessage('Court Order successfully created!');
    }

    public function edit($id)
    {
        $court_order = CourtOrder::findOrFail($id);
        return View::make('court_orders.edit', compact('court_order'));
    }

    public function update(Request $request, $id)
    {
        $court_order = CourtOrder::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'order_number'   => ['required', Rule::unique('court_orders', 'order_number')->ignore($id)],
            'order_type'     => 'required|in:garnishment,attachment,deduction',
            'rate_type'      => 'required|in:fixed,percentage',
            'amount'         => 'nullable|numeric|min:0',
            'percentage'     => 'nullable|numeric|min:0|max:100',
            'effective_date' => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:effective_date',
        ], CourtOrder::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // conditional validation
        if ($request->rate_type === 'fixed' && !$request->amount) {
            return Redirect::back()->withErrors(['amount' => 'Amount is required for fixed type'])->withInput();
        }
        if ($request->rate_type === 'percentage' && !$request->percentage) {
            return Redirect::back()->withErrors(['percentage' => 'Percentage is required for percentage type'])->withInput();
        }

        $court_order->order_number   = $request->get('order_number');
        $court_order->order_type     = $request->get('order_type');
        $court_order->rate_type      = $request->get('rate_type');
        $court_order->amount         = $request->get('amount');
        $court_order->percentage     = $request->get('percentage');
        $court_order->effective_date = $request->get('effective_date');
        $court_order->end_date       = $request->get('end_date');
        $court_order->description    = $request->get('description');
        $court_order->update();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'update', 'updated court order: ' . $court_order->order_number);
        return Redirect::route('court_orders.index')->withFlashMessage('Court Order successfully updated!');
    }

    public function destroy($id)
    {
        $court_order = CourtOrder::findOrFail($id);
        $assigned = DB::table('employee_court_orders')->where('court_order_id', $id)->count();

        if ($assigned > 0) {
            return Redirect::route('court_orders.index')->withDeleteMessage('Cannot delete this court order because it is assigned to employees!');
        }

        CourtOrder::destroy($id);
        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'delete', 'deleted court order: ' . $court_order->order_number);

        return Redirect::route('court_orders.index')->withDeleteMessage('Court Order successfully deleted!');
    }
}
