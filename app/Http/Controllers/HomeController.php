<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Appointment;
use App\User;
use App\Patient_notes;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user                   = getLoginUser();
        $data['doctors']        = collect(array());
        if ($user->type != 0) {
            $data['doctors']    = collect(User::get_doctors());
        }
        $appointments           = Appointment::getRecords();
        $data['appointments']   = collect($appointments);
        $data['patient_list']   = collect(Patient::all());
        $data['time_slots']     = collect(Appointment::getTimeSlot());
        return view('portal.home.index', $data);
    }
    public function add_appoiment_model(Request $request, $id = 0) {
        $appointment_data       = collect(array());
        if($id > 0) {
            $edit_data                      = Appointment::where('id',$id)->first();
            $edit_data['appointment_time']  = date("h:i A", strtotime($edit_data['appointment_time']));
            $appointment_data      = collect($edit_data);
        }
        $return['appointment_data']   = $appointment_data;
        $return['status']           = true;
        echo json_encode($return);die;
    }

    public function get_appointment(Request $request,$doctor_id = 0) {
        $filter['startdate']    = $request->start;
        $filter['enddate']      = $request->end;
        if($doctor_id > 0) {
            $filter['doctor_id']      = $doctor_id;
        }
        $appointments           = Appointment::getRecords($filter);
        $return['appointments'] = $appointments;
        return response()->json($return);
    }
    public function add_appointment(Request $request) {
        $this->validate($request, [
            'patient_id'        => 'required',
            'appointment_date'  => 'required',
            'appointment_time'  => 'required',
            'type'              => 'required'
        ]);
        $postdata['doctor_id']          = isset($request->doctor_id) && $request->doctor_id > 0 ? $request->doctor_id : 0;
        $postdata['patient_id']         = $request->patient_id;
        $postdata['type']               = $request->type;
        $postdata['appointment_date']   = ($request->appointment_date != "") ? date('Y-m-d', strtotime($request->appointment_date)) : "";
        $postdata['appointment_time']   = ($request->appointment_time != "" ) ? date('H:i:s',strtotime($request->appointment_time)) : "";
        $postdata['created_date']       = date('Y-m-d h:i:s');
        $postdata['sms_notification']   = ($request->sms_notification == 'on') ? '1' : '0';
        $postdata['email_notification'] = ($request->email_notification == 'on') ? '1' : '0';
        $id                             = isset($request->id) && $request->id > 0 ? $request->id : 0;
        $appointment                    = true;

        if ($id > 0) {
           $appointment = Appointment::where('id' ,$id)->update($postdata);
        } else {
           $appointment = Appointment::create($postdata);
        }

        if ($appointment) {

            if ($postdata['sms_notification'] == '1') {
                $patient    = Patient::where('id' ,$postdata['patient_id'])->first();
                if (!empty($patient)) {
                    $message= "Hello ".$patient->firstname.', \n';
                    $message.= "Your appointment is schedules on ".date('d-m-Y', strtotime($postdata['appointment_date']))." at ".date('h:i A', strtotime($postdata['appointment_time']))." by Dr. Dipak Soni. \n\n";
                    $message.= "Hetvi Clinic\n";
                    $message.= "www.hetviclinic.com";
                    if (isset($patient->phone) && ($patient->phone != '')) {
                        $mobile = '91'.$patient->phone;
                        send_sms($mobile, $message);
                    }
                    if (isset($patient->alternate_phone) && ($patient->alternate_phone != '')) {
                        $mobile = '91'.$patient->alternate_phone;
                        send_sms($mobile, $message);
                    }
                }
            }
            if($postdata['email_notification'] == '1') {
                $patient                            = Patient::where('id' ,$postdata['patient_id'])->first();
                if (!empty($patient)) {
                    $sent_data['patient_name']          = $patient->firstname." ".$patient->lastname;
                    $sent_data['appointment_date']      = date('d-m-Y', strtotime($postdata['appointment_date']));
                    $sent_data['appointment_time']      = date('h:i A', strtotime($postdata['appointment_time']));
                    $sent_data['patient']               = $patient;
                    $sent_data['subject']               = "Appointment Booked | HETVI CLINIC";
                    $sent_data['to']                    = $patient->email; 
                    $sent_data['message']               = 'portal.email.email';
                    $this->send_mail($sent_data);
                }
            }
            $return['status']   = true;
            $return['message']  = "Record Successfully Updated";
        } else {
            $return['status']   = false;
            $return['message']  = "Sometthing went wrong";
        }
        return response()->json($return);
    }
    public function delete_appointment($id = "") {
        $id             = base64_decode($id);
        $appointment    = false;
        if ($id > 0) {
           $appointment = Appointment::where('id' ,$id)->delete();
           Invoice::where('appointment_id' ,$id)->delete();
           Patient_notes::where('appointment_id' ,$id)->delete();
        }
        $return = array();
        if ($appointment) {
            $return['status']   = true;
            $return['message']  = "Record Successfully Deleted";
            
        } else {
            $return['status']   = false;
            $return['message']  = "Sometthing went wrong";
        }
        return response()->json($return);
    }
}
