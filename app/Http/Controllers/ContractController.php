<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class ContractController extends Controller
{
    //
    public function EmployeeContracts()
    {
        $employees = Employee::where('organization_id',Auth::user()->id)->get();
        foreach ($employees as $employee)
        {
            $start_date  = $employee->end_date;
            $today = (new \DateTime(today()));
            $end = (new \DateTime($start_date));
            $interval = $today->diff($end)->m;
            if (($interval)<3)
            {
                (dd(count($employees)));
            }
            if ($interval < 3 && $employee->employeeY->employee_type_name == 'Contract')
            {
                $emailData = [
                    'id'=>$employee->id,
                    'email'=>$employee->email_office,
                    'name'=>$employee->first_name.' '.$employee->last_name,
                    'admin'=>'nelson.saammy@gmail.com',
                    'ends'=>$interval
                ];
                ContractController::general($emailData);
            }
        }
    }
    public static function general($emailData)
    {
        view()->share(compact('emailData'));
        $mail = new PHPMailer(true);
        try {
            $mail->DEBUG_OFF = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username =env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            //
            $mail->setFrom(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
            $mail->addAddress($emailData['email']);
            $mail->addCC($emailData['admin']);
            $mail->addReplyTo(env('MAIL_FROM_ADDRESS'),'Lixnet Payroll');
            //
            $mail->isHTML(true);
            $mail->Subject = 'Your Contract End in '.$emailData['ends']. ' Months';
            $mail->Body = view('mail.contract')->render();
            $mail->send();
        }
        catch (\Exception $e)
        {
            Log::error($e);
        }
    }
}
