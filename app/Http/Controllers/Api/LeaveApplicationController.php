namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leaveapplication;
use App\Models\Organization; // Add the necessary use statements for other models
use App\Models\Employee;
use App\Models\Leavetype;
use Validator;

class LeaveApplicationController extends Controller
{
    public function index()
    {
        $leaveApplications = Leaveapplication::all();
        return response()->json(['leaveApplications' => $leaveApplications], 200);
    }
    public function create(Request $request)
    {
        $data = $request->all();

        // Assuming you have the necessary models imported
        $organization = Organization::getUserOrganization();
        $employee = Employee::find(Arr::get($data, 'employee_id'));
        $leavetype = Leavetype::find(Arr::get($data, 'leavetype_id'));

        $application = new Leaveapplication;

        $application->applied_start_date = Arr::get($data, 'applied_start_date');
        $application->applied_end_date = Arr::get($data, 'applied_end_date');
        $application->status = 'applied';
        $application->application_date = now();
        $application->employee()->associate($employee);
        $application->leavetype()->associate($leavetype);
        $application->organization()->associate($organization);

        $application->save();

        return response()->json(['message' => 'Leave application created successfully']);
    }
}
