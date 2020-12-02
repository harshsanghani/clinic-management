<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Patient;
use App\User;
use App\Payment_mode;
use DB;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user               = getLoginUser();
        $data['user']       = collect($user);
        $data['patient']    = collect(Patient::all()->toArray());
        $data['doctors']    = collect(array());
        if ($user->type != 0) {
            $data['doctors']    = collect(User::get_doctors());
        }
        return view('portal.invoice.index',$data);
    }
    public function get_invoices(Request $request)
    {
        $method         = $request->method();
        $data           = array();
        $filter         = array();
        $filter_data    = json_decode(base64_decode($request->custom_filter));
        
        //doctor filter
        if (isset($filter_data->doctor_from_date) && $filter_data->doctor_from_date != "" && isset($filter_data->doctor_to_date) && $filter_data->doctor_to_date != "") {
            $filter['where']['appointment_date_from']   = date('Y-m-d',strtotime($filter_data->doctor_from_date));
            $filter['where']['appointment_date_to']     = date('Y-m-d',strtotime($filter_data->doctor_to_date));
        }
        if (isset($filter_data->doctor_patient_id) && $filter_data->doctor_patient_id != "") {
            $filter['where']['angel_invoice.patient_id'] = $filter_data->doctor_patient_id;
        }
        //master admin filter
        if (isset($filter_data->admin_patient_id) && $filter_data->admin_patient_id != "") {
            $filter['where']['angel_invoice.patient_id'] = $filter_data->admin_patient_id;
        }
        if (isset($filter_data->admin_from_date) && $filter_data->admin_from_date != "" && isset($filter_data->admin_to_date) && $filter_data->admin_to_date != "") {
            $filter['where']['appointment_date_from']   = date('Y-m-d',strtotime($filter_data->admin_from_date));
            $filter['where']['appointment_date_to']     = date('Y-m-d',strtotime($filter_data->admin_to_date));
        }
        if (isset($filter_data->admin_doctor_id) && $filter_data->admin_doctor_id != "") {
            $filter['where']['a.doctor_id'] = $filter_data->admin_doctor_id ;
        }
        
        $invoice = Invoice::query()
            ->select('angel_invoice.id', 'p.id as file_number','p.firstname as firstname','p.middlename','p.lastname','p.email','a.appointment_date','n.amount','n.consulting_amount','n.received_amount', 'n.medicine_amount')
            ->leftjoin("angel_appointment  as a", 'a.id', '=', 'angel_invoice.appointment_id')
            ->leftjoin("angel_patient  as p", 'p.id', '=', 'angel_invoice.patient_id')
            ->leftjoin("angel_patient_notes  as n", 'n.appointment_id', '=', 'a.id');
        
        $inv = Invoice::query()
            ->select('angel_invoice.id', 'p.id as file_number','p.firstname as firstname','p.middlename','p.lastname','p.email','a.appointment_date','n.amount','n.consulting_amount','n.received_amount', 'n.medicine_amount')
            ->leftjoin("angel_appointment  as a", 'a.id', '=', 'angel_invoice.appointment_id')
            ->leftjoin("angel_patient  as p", 'p.id', '=', 'angel_invoice.patient_id')
            ->leftjoin("angel_patient_notes  as n", 'n.appointment_id', '=', 'a.id');
        
        if($request['query'])
        {
            $search     = $request['query'];
            $invoice->where(function ($query) use($search) {
                $query->where('p.firstname', 'like', '%' . $search . '%')
                   ->orWhere('p.middlename', 'like', '%' . $search . '%')
                   ->orWhere('p.lastname', 'like', '%' . $search . '%')
                   ->orWhere('a.appointment_date', 'like', '%' . $search . '%')
                   ->orWhere('n.amount', 'like', '%' . $search . '%')
                   ->orWhere('n.medicine_amount', 'like', '%' . $search . '%')
                   ->orWhere('n.received_amount', 'like', '%' . $search . '%')
                   ->orWhere('n.consulting_amount', 'like', '%' . $search . '%');
              });
              
              $inv->where(function ($query) use($search) {
                $query->where('p.firstname', 'like', '%' . $search . '%')
                   ->orWhere('p.middlename', 'like', '%' . $search . '%')
                   ->orWhere('p.lastname', 'like', '%' . $search . '%')
                   ->orWhere('a.appointment_date', 'like', '%' . $search . '%')
                   ->orWhere('n.amount', 'like', '%' . $search . '%')
                   ->orWhere('n.medicine_amount', 'like', '%' . $search . '%')
                   ->orWhere('n.received_amount', 'like', '%' . $search . '%')
                   ->orWhere('n.consulting_amount', 'like', '%' . $search . '%');
                });
        }
        else if($request->orderBy)
        {
            $invoice->orderBy($request->orderBy, $request->ascending == 1 ? 'ASC' : 'DESC');
        }
        //$invoice->orderBy('firstname', 'ASC');
        if (isset($filter['where']) && !empty($filter['where'])) {
            foreach ($filter['where'] as $key => $where) {
                if ($key=='appointment_date_from') {
                    $invoice->where('a.appointment_date','>=',$where);
                    $inv->where('a.appointment_date','>=',$where);
                } else if ($key=='appointment_date_to'){
                    $invoice->where('a.appointment_date','<=',$where);
                    $inv->where('a.appointment_date','<=',$where);
                } else {
                    $invoice->where($key,'=',$where);
                    $inv->where($key,'=',$where);
                }
            }
        }
        
        $finalTotalData = array();
        $getTotal = array();
        if(!empty($inv)) {
            $where = clone $inv;
            $where->select(DB::raw('SUM(n.amount) as total_amount'),DB::raw('SUM(n.consulting_amount) as total_consulting_amount'),DB::raw('SUM(n.received_amount) as total_received_amount'),DB::raw('SUM(n.medicine_amount) as total_medicine_amount'));
            $getTotal = $where->first()->toArray();
            $finalTotalData['total_amount']             = 0;
            $finalTotalData['total_received_amount']    = 0;
            $finalTotalData['total_pending_amount']     = 0;
            if (!empty($getTotal)) {
                $finalTotalData['total_amount']             = round($getTotal['total_amount'], 2);
                $finalTotalData['total_received_amount']    = round($getTotal['total_received_amount'], 2);
                $finalTotalData['total_pending_amount']     = round($getTotal['total_amount'] - $getTotal['total_received_amount'], 2);
            }
        }
        $data           = $invoice->paginate($request->limit ? $request->limit : 20)->toArray();
        //p($data['data']);
        

        $return_data    = array();
        if (!empty($data['data'])) {
            foreach ($data['data'] as $row) {
                $amount                         = ($row['received_amount'] > $row['amount']) ? ($row['received_amount'] - $row['amount']) : ($row['amount'] - $row['received_amount']);
                $amount_text                    = ($amount > 0) ? (($row['received_amount'] > $row['amount']) ? '+' : '-').$amount : $amount;
                $row_data                       = array();
                $row_data['email']              = $row['email'];
                $row_data['id']                 = $row['id'];
                $row_data['file_number']        = $row['file_number'];
                $row_data['firstname']          = $row['firstname']." ".$row['middlename']." ".$row['lastname'];
                $row_data['consulting_amount']  = $row['consulting_amount'];
                $row_data['medicine_amount']    = $row['medicine_amount'];
                $row_data['received_amount']    = $row['received_amount'];
                $row_data['amount']             = $amount_text;
                $row_data['appointment_date']   = date('d-m-Y', strtotime($row['appointment_date']));
                $return_data[]                  = $row_data;
            }
        }
        if (!empty($return_data)) {
            $data['data']               = $return_data; 
        }
        $data['final_total_data']       = $finalTotalData; 
        return response()->json($data); die;
    }
    public function add_invoice_modal() {
        $return             = array();
        //$patient            = collect(Patient::getPatient($patient_id));
        $patient_notes      = collect(array());

        $payment_modes          = collect(payment_mode::all());
        $data['payment_modes']  = $payment_modes;
        $data['notes']          = $patient_notes;
        $data['patient']        = collect(array());
        $data['time_slots']     = collect(array());

        $appointment = collect(array());
//        if ($appointment_id > 0) {
//            $appointment                        = Appointment::where('id', $appointment_id)->first()->toArray();
//            $appointment['appointment_time']    = date("h:i A", strtotime($appointment['appointment_time']));
//        }
        $data['appointment']= collect($appointment);
        $data['patient_id'] = 0;
        $html               = view('portal.invoice.invoice_model',$data)->render();
        $return['html']     = $html;
        $return['status']   = TRUE ;
        $return['message']  = "Success" ;
        echo json_encode($return);die;
    }
}
