<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\CourtOrder;
use App\Models\Employee;
use App\Models\EmployeeCourtOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EmployeeCourtOrderController extends Controller
{
    public function index()
    {
        $employeeCourtOrders = EmployeeCourtOrder::with(['employee', 'courtOrder'])
            ->where('organization_id', Auth::user()->organization_id)
            ->get();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'view', 'viewed employee court orders');

        return View::make('employee_court_orders.index', compact('employeeCourtOrders'));
    }

    public function create()
    {
        $employees = Employee::all();
        $courtOrders = CourtOrder::all();

        return View::make('employee_court_orders.create', compact('employees', 'courtOrders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), EmployeeCourtOrder::$rules, EmployeeCourtOrder::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        EmployeeCourtOrder::create([
            'employee_id' => $request->get('employee_id'),
            'court_order_id' => $request->get('court_order_id'),
            'amount' => $request->get('amount'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'organization_id' => Auth::user()->organization_id,
        ]);

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'create', 'assigned court order to employee');

        return Redirect::route('employee_court_orders.index')->withFlashMessage('Employee Court Order successfully created!');
    }

    public function edit($id)
    {
        $employeeCourtOrder = EmployeeCourtOrder::findOrFail($id);
        $employees = Employee::all();
        $courtOrders = CourtOrder::all();

        return View::make('employee_court_orders.edit', compact('employeeCourtOrder', 'employees', 'courtOrders'));
    }

    public function update(Request $request, $id)
    {
        $employeeCourtOrder = EmployeeCourtOrder::findOrFail($id);

        $validator = Validator::make($request->all(), EmployeeCourtOrder::$rules, EmployeeCourtOrder::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $employeeCourtOrder->update($request->only([
            'employee_id', 'court_order_id', 'amount', 'start_date', 'end_date'
        ]));

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'update', 'updated employee court order');

        return Redirect::route('employee_court_orders.index')->withFlashMessage('Employee Court Order successfully updated!');
    }

    public function destroy($id)
    {
        $employeeCourtOrder = EmployeeCourtOrder::findOrFail($id);
        $employeeCourtOrder->delete();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'delete', 'deleted employee court order');

        return Redirect::route('employee_court_orders.index')->withDeleteMessage('Employee Court Order successfully deleted!');
    }
}
