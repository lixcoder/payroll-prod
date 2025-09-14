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

        Audit::logaudit(
            date('Y-m-d'),
            Auth::user()->name,
            'view',
            'viewed employee court orders'
        );

        return View::make('employee_court_orders.index', compact('employeeCourtOrders'));
    }

    public function create()
    {
        $employees = Employee::getActiveEmployee();
        $courtOrders = CourtOrder::where('organization_id', Auth::user()->organization_id)->get();

        return View::make('employee_court_orders.create', compact('employees', 'courtOrders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required|exists:x_employee,id',
            'court_order_id' => 'required|exists:court_orders,id',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'max_deduction'  => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $employeeCourtOrder = new EmployeeCourtOrder;
        $employeeCourtOrder->employee_id     = $request->get('employee_id');
        $employeeCourtOrder->court_order_id  = $request->get('court_order_id');
        $employeeCourtOrder->start_date      = $request->get('start_date');
        $employeeCourtOrder->end_date        = $request->get('end_date');
        $employeeCourtOrder->max_deduction   = $request->get('max_deduction');
        $employeeCourtOrder->status          = 'active';
        $employeeCourtOrder->organization_id = Auth::user()->organization_id;

        $employeeCourtOrder->save();

        Audit::logaudit(
            date('Y-m-d'),
            Auth::user()->name,
            'create',
            'assigned court order [' . $employeeCourtOrder->court_order_id . '] to employee [' . $employeeCourtOrder->employee_id . ']'
        );

        return Redirect::route('employee_court_orders.index')
            ->withFlashMessage('Employee Court Order successfully created!');
    }

    public function edit($id)
    {
        $employeeCourtOrder = EmployeeCourtOrder::findOrFail($id);
        $employees = Employee::getActiveEmployee();
        $courtOrders = CourtOrder::where('organization_id', Auth::user()->organization_id)->get();

        return View::make('employee_court_orders.edit', compact('employeeCourtOrder', 'employees', 'courtOrders'));
    }

    public function update(Request $request, $id)
    {
        $employeeCourtOrder = EmployeeCourtOrder::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required|exists:x_employee,id',
            'court_order_id' => 'required|exists:court_orders,id',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'max_deduction'  => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $employeeCourtOrder->employee_id    = $request->get('employee_id');
        $employeeCourtOrder->court_order_id = $request->get('court_order_id');
        $employeeCourtOrder->start_date     = $request->get('start_date');
        $employeeCourtOrder->end_date       = $request->get('end_date');
        $employeeCourtOrder->max_deduction  = $request->get('max_deduction');

        $employeeCourtOrder->update();

        Audit::logaudit(
            date('Y-m-d'),
            Auth::user()->name,
            'update',
            'updated employee court order [' . $employeeCourtOrder->id . ']'
        );

        return Redirect::route('employee_court_orders.index')
            ->withFlashMessage('Employee Court Order successfully updated!');
    }

    public function destroy($id)
    {
        $employeeCourtOrder = EmployeeCourtOrder::findOrFail($id);
        $employeeCourtOrder->delete();

        Audit::logaudit(
            date('Y-m-d'),
            Auth::user()->name,
            'delete',
            'deleted employee court order [' . $id . ']'
        );

        return Redirect::route('employee_court_orders.index')
            ->withDeleteMessage('Employee Court Order successfully deleted!');
    }
}
