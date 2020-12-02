<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Patient_address;
use App\Blood;
use App\Religion;
use App\Attachment;
use App\Diet;
use App\Marital_status;
use App\Occupation;
use App\Organisation;
use App\Prognosis;
use App\Report;
use App\Extra_notes;
use App\Patient_notes;
use App\Payment_mode;
use App\Appointment;
use App\Invoice;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use PDF;
use Mail;

class PatientController extends Controller
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
    public function index() {
        return view('portal.patient.index');
    }

    public function patient_list() {
        $data   = Patient::getRecords();
        return response()->json($data);
    }

    public function setup(Request $request) {
        
        $data['patient']                = collect(array());
        $data['address_info']           = collect(array());
        $data['blood_options']          = collect(Blood::all());
        $data['religion_options']       = collect(Religion::all());
        $data['prognosis_options']      = collect(Prognosis::all());
        $data['occupation_options']     = collect(Occupation::all());
        $data['organisation_options']   = collect(Organisation::all());
        $data['marital_status_options'] = collect(Marital_status::all());
        $data['diet_options']           = collect(Diet::all());
        if(isset($request->patientId) && $request->patientId > 0 ) {
            $patient_id                 = $request->patientId;
            $patient                    = collect(Patient::getPatient($patient_id));
            $data['address_info']       = collect($patient['address_info']);
            $data['patient']            = $patient;
        }
        return view('portal.patient.form', $data);
    }

    public function view($patient_id = '') {
        if ($patient_id > 0) {
            $patient                = collect(Patient::getPatient($patient_id));
            $data['patient']        = $patient;
            $data['patient_id']     = $patient_id;
            return view('portal.patient.view', $data);
        } else {
            return redirect('/portal');
        }
   }

   public function patient_setup() {
        $data   = array();
        $data['diet_options']           = Diet::all();
        $data['blood_options']          = Blood::all();
        $data['religion_options']       = Religion::all();
        $data['prognosis_options']      = Prognosis::all();
        $data['occupation_options']     = Occupation::all();
        $data['organisation_options']   = Organisation::all();
        $data['marital_status_options'] = Marital_status::all();
        return response()->json($data);
    }

    public function commit(Request $request) {
        $return     = array();
        $user       = auth()->user();
        
        $this->validate($request, [
            'title'         => 'required',
            'firstname'     => 'required',
            'middlename'    => 'required',
            'lastname'      => 'required',
            'email'         => 'email',
            'phone'         => 'required|max:10|min:10',
        ]);
        $patient_id = $request->patient_id;
        $age        = '0';
        $birthdate  = NULL;
        if ($request->birthdate != "") {
            $birthdate  = date('Y-m-d', strtotime($request->birthdate));
            $d1         = new DateTime($birthdate);
            $d2         = new DateTime(date('Y-m-d'));
            $diff       = $d2->diff($d1);
            $age        = $diff->y;
        }
        $insert_data = array (
                        'title'             => $request->title,
                        'firstname'         => $request->firstname,
                        'middlename'        => $request->middlename,
                        'lastname'          => $request->lastname,
                        'email'             => $request->email,
                        'phone'             => $request->phone,
                        'alternate_phone'   => isset($request->alternate_phone) ? $request->alternate_phone:"",
                        'birthdate'         => $birthdate,
                        'age'               => $age,
                        'gender'            => isset($request->gender) ? $request->gender :'',
                        'blood_group'       => isset($request->blood_group) ? $request->blood_group :0,
                        'religion'          => isset($request->religion) ? $request->religion :0,
                        'refereace'         => isset($request->refereace) ? $request->refereace :"",
                        'added_by'          => $user->id
        );
        if ($patient_id > 0) {
            $patient_data       = Patient::where('id',$patient_id)->update($insert_data);
            $return['message']  = "Patient record updated successfully";
        } else {
            $patient_data       = Patient::create($insert_data);
            if($patient_data->id > 0) {
                $patient_id         = $patient_data->id;
                $return['message']  = "Patient record save successfully";
            }
        }

        if ($request->hasFile('avatar') && $patient_id > 0) {
            $image  = $request->file('avatar');
            $path   = getcwd() . '/assets/portal-side/uploads/patient';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $avatar             = time().'.'.$image->getClientOriginalExtension();
            $destinationPath    = $path . '/' . md5($patient_id);
            $upload_path        = '/assets/portal-side/uploads/patient/' . md5($patient_id) .'/'. $avatar;

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $avatar);

            $image_insert_data  = array(
                                    'path' => $upload_path,
                                    'type' => 'image',
                                );
            $image_data = Attachment::create($image_insert_data);
            if (isset($image_data->id)) {
                $update_data['image'] = $image_data->id;
                Patient::where('id', $patient_id)->update($update_data);
            }
        }
        if ($patient_id > 0) {
            $return['status']       = true;
            $return['patient_id']   = $patient_id;
        } else {
            $return['status']   = false;
            $return['message']  = "Sometthing went wrong";
        }
        return response()->json($return);
    }

    public function save_general_detail(Request $request) {
        $return     = array();
        $this->validate($request, [
            'occupation'        => 'required',
            'maritial_status'   => 'required',
            'diet'              => 'required',
            'organization'      => 'required',
            'prognosis'         => 'required',
        ]);
        $patient_id = $request->patient_id;
        if ($patient_id > 0) {
            $insert_data = array (
                            'occupation'        => $request->occupation,
                            'maritial_status'   => $request->maritial_status,
                            'diet'              => $request->diet,
                            'organization'      => $request->organization,
                            'prognosis'         => $request->prognosis
            );
            
            Patient::where('id',$patient_id)->update($insert_data);

            $return['message']      = "Record Successfully Updated";
            $return['status']       = true;
            $return['patient_id']   = $patient_id;
        } else {
            $return['status']   = false;
            $return['message']  = "Sometthing went wrong";
        }
        return response()->json($return);
    }

    public function save_contact_detail(Request $request) {
        $return     = array();
        $patient_id = $request->patient_id;
        if ($patient_id > 0) {

            $address_id = $request->address_id;
            $this->validate($request, [
                'address'           => 'required',
                'city'              => 'required',
                'state'             => 'required',
                'country'           => 'required',
                'zipcode'           => 'required',
                'permanent_address' => 'required',
                'permanent_city'    => 'required',
                'permanent_state'   => 'required',
                'permanent_country' => 'required',
                'permanent_zipcode' => 'required',
            ]);

            $insert_data = array (
                            'patient_id'        => $patient_id,
                            'address'           => $request->address,
                            'city'              => $request->city,
                            'state'             => $request->state,
                            'country'           => $request->country,
                            'zipcode'           => $request->zipcode,
                            'permanent_address' => $request->permanent_address,
                            'permanent_city'    => $request->permanent_city,
                            'permanent_state'   => $request->permanent_state,
                            'permanent_country' => $request->permanent_country,
                            'permanent_zipcode' => $request->permanent_zipcode,
            );
            if ($address_id > 0) {
                Patient_address::where('id',$address_id)->update($insert_data);
                $return['message']      = "Record Successfully Updated";
            } else {
                $insert_data['created_date']    = date('Y-m-d H:i:s');
                $patient_address                = Patient_address::create($insert_data);
                if($patient_address->id > 0) {
                    $address_id         = $patient_address->id;
                    $return['message']  = "Record Successfully inserted";
                }
            }

            $return['status']       = true;
            $return['address_id']   = $address_id;
        } else {
            $return['status']   = false;
            $return['message']  = "Sometthing went wrong";
        }
        return response()->json($return);
    }
    public function patientlist(){
        return view('portal.patient.patient_list');
    }
    public function getpatientlist(Request $request){
        return response()->json(Patient::get());
    }
    public function delete_patient($patient_id = '') {
        if ($patient_id != "") {
             $patient = collect(Patient::getPatient($patient_id));
            if (!empty($patient)) {
                if (isset($patient['image_info']['path'])) {
                    $image = getcwd() . $patient['image_info']['path'];
                    if (file_exists($image)) {
                        unlink($image);
                    }
                    Attachment::where('id', $patient['image_info']['id'])->delete();
                }
                if (isset($patient['address_info'])) {
                    Patient_address::where('patient_id', $patient['address_info']['patient_id'])->delete();
                }
                Patient::where('id', $patient_id)->delete();
            }
        }
        return redirect('/portal/patient');
    }
    public function search_patient() {
        $return         = array();
        $search         = Input::get('search');
        $return['html'] = "";
        if ($search != "") {
             $data['patient'] =  Patient::where('firstname', 'like', "$search%")
                        ->orWhere('lastname', 'like', "$search%")
                        ->orWhere('middlename', 'like', "$search%")
                        ->orWhere('email', 'like', "$search%")
                        ->orWhere('phone', 'like', "$search%")->with('imageInfo')->get();
             $return['html']    = view('portal.patient.patient_search',$data)->render();
             $return['status']  = true;
        } else {
            $return['status']  = false;
        }
        echo json_encode($return);
    }
    public function report(Request $request, $patient_id = '') {
        $method         = $request->method();
        $data           = array();
        if ($request->isMethod('post')) {
            $data_view      = array();
            $return         = array();
            $reports_data   = collect(Report::where('patient_id',$patient_id)->with('imageInfo')->get());
            foreach($reports_data as $data) {
                $preview_path       = base_url().'/'.$data->imageInfo->path;
                $file_path          = '';
                if ($data->imageInfo->type == "doc") {
                    $file_path       = base_url().'/assets/portal-side/img/pdf.png';
                } else if ($data->imageInfo->type == "video") {
                    $file_path       = base_url().'/assets/portal-side/img/mp4.png';
                } else {
                    $file_path       = base_url().$data->imageInfo->path;
                }
                $data_view['reports'][] = array('file_path' => $file_path ,'preview_path' =>$preview_path,'report_id'=> $data->id);
             }
            $return['html']             = view('portal.patient.ajax_get_report',$data_view)->render();
            $return['status']           = true;
            echo json_encode($return);die;
        } else {
            $patient                = collect(Patient::getPatient($patient_id));
            $data['patient']        = $patient;
            if (!empty($data['patient'])) {
                 return view('portal.patient.report', $data);
            } else {
                $this->session->set_flashdata('error', 'Patient not found.');
                return redirect('/portal/patient/'.$patient_id);
            }
        }
    }
    public function invoice(Request $request, $patient_id = '') {
        $patient                = collect(Patient::getPatient($patient_id));
        $data['patient']        = $patient;
        if (!empty($data['patient'])) {
             return view('portal.patient.invoice', $data);
        } else {
            Session::flash('danger','Patient not found.');
            return redirect('/portal/patient/'.$patient_id);
        }
       
    }
    public function report_upload(Request $request, $patient_id = "") {
       
       $return = array();
       if ($patient_id > 0) {
            $image              = $request->file('file');
            $validextensions    = array("gif","jpg","jpeg","png","pdf","mp4","JPEG","PDF","PNG","JPG","GIF","MP4");
            $extension          = $request->file('file')->getClientOriginalExtension();

            if (in_array(strtolower($extension), $validextensions)) {

                $path   = getcwd() . '/assets/portal-side/uploads/patient/' . md5($patient_id) .'/report';
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $avatar             =  time().'.'.$image->getClientOriginalExtension();
                //$extension          =  '.'.pathinfo($avatar, PATHINFO_EXTENSION);
                $destinationPath    = $path;
                $upload_path        = '/assets/portal-side/uploads/patient/' . md5($patient_id) .'/report/'. $avatar;

                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $image->move($destinationPath, $avatar);
                if (isset($extension) && in_array('.'.$extension,doc_ext_array())) {
                    $extension = 'doc';
                } else if (isset($extension) && in_array('.'.$extension,video_ext_array())) {
                    $extension = 'video';
                } else {
                    $extension = 'image';
                }
                $image_insert_data  = array(
                        'path' => $upload_path,
                        'type' => $extension,
                    );
                $image_data = Attachment::create($image_insert_data);
                if (isset($image_data->id)) {
                    $postdata                   = array();
                    $postdata['patient_id']     = $patient_id;
                    $postdata['created_date']   = date('Y-m-d h:m:i');
                    $postdata['report']         = $image_data->id;
                    $report_image               = Report::create($postdata);
                    $return['status']           = TRUE;
                    $return['message']          = "Report Successfully Uploaded";
                } else {
                    $return['status']   = FALSE;
                    $return['message']  = "Somthing went wrong";
                }
            } else {
                $return['status']   = FALSE;
                $return['message']  = "Only gif,jpg,jpeg,png,pdf,mp4,JPEG,PDF,PNG,JPG,GIF,MP4 are allowed";
            }
        } else {
            $return['status']   = FALSE;
            $return['message']  = "Somthing went wrong";
        }
        echo json_encode($return);die;
    }
    public function detete_report($patient_id = 0) {
        $return = array();
        if ($patient_id > 0) {
            $reports= collect(Report::where('id',$patient_id)->with('imageInfo')->first());
            if (!empty($reports)) {
                if (isset($reports['image_info'])) {
                     $image = getcwd().$reports['image_info']['path'];
                     if (file_exists($image)) {
                         unlink($image);
                     }
                     Attachment::where('id',$reports['image_info']['id'])->delete();
                 }
                 Report::where('id' ,$patient_id)->delete();
                 $return['status']   = true;
                 $return['message']  = "Data Successfully Deleted";
            } else {
                $return['status']   = FALSE;
                $return['message']  = "Somthing went wrong";
            }
        } else {
            $return['status']   = FALSE;
            $return['message']  = "Somthing went wrong";
        }
        echo json_encode($return);die;
    }
    public function add_extra_notes(Request $request) {
        $patient_id     = $request['patient_id'];
        $message        = $request['message'];
        $return         = array();
        if ($request->isMethod('post')) {
             $validator = Validator::make($request->all(), [
                'message' => 'required'
            ]);
            if ($validator->fails()) {
                $return['status']   = FALSE;
                $return['message']  =  "the Message field is required.";
            } else {
                if ($patient_id > 0) {
                    $postdata                   = array();
                    $postdata['created_date']   = date('Y-m-d H:i:s');
                    $postdata['note']           = $message;
                    $postdata['patient_id']     = $patient_id;
                    $note_id                    = Extra_notes::create($postdata);
                    if ($note_id->id > 0) {
                        $return['status']       = TRUE;
                        $return['patient_id']   = $patient_id ;
                        $return['message']      = "Data sucessfully inserted";
                    } else {
                        $return['status']       = FALSE;
                        $return['message']      = "Somthing went wrong";
                    }
                } else {
                    $return['status']   = FALSE;
                    $return['message']  = "Somthing went wrong";
                }
            }
            echo json_encode($return);die;
        } else{
            return redirect('/portal/patient');
        }
    }
    public  function get_extra_notes(Request $request, $patient_id = '') {
        $method         = $request->method();
        if ($request->isMethod('post') && $patient_id != "") {
            $view_data                  = array();
            $return                     = array();
            $view_data['extra_notes']   = collect(Extra_notes::where('patient_id',$patient_id)->get());
            $return['html']             = view('portal.patient.ajax_extra_notes',$view_data)->render();
            $return['status']           = true;
            echo json_encode($return);die;
        } else {
           return redirect(base_url());
        }
    }
    public  function delete_extra_notes(Request $request, $note_id = '') {
        $method = $request->method();
        if ($request->isMethod('post') && $note_id != "") {
            $return                     = array();
            $note   = Extra_notes::where('id', $note_id)->first();
            if (!empty($note)) {
                if($note->delete()) {
                    $return['status']   = true ;
                    $return['message']  = "data sucessfully Deleted";
                } else {
                    $return['status']   = FALSE;
                    $return['message']  = "Somthing went wrong";
                }
            } else {
                $return['status']   = FALSE;
                $return['message']  = "Somthing went wrong";
            }
            echo json_encode($return);die;
        } else {
           return redirect(base_url());
        }
    }
    public function patient_card(Request $request, $patient_id = "") {
        $method = $request->method();
        if ($request->isMethod('post') && $patient_id != "") {
            $view_data  = array();
            $patient    = collect(Patient::getPatient($patient_id));
            if (!empty($patient)) {
                $view_data['patient']       = $patient;
                $view_data['card_detail']   = $request['card_detail'];
//                $html                       = view('portal.patient.patient_card_pdf',$view_data)->render();
                $pdf                        = PDF::loadView('portal.patient.patient_card_pdf', $view_data);
                return $pdf->stream($patient_id.".pdf");
            }
        } else {
           return redirect(base_url());
        }
    }
    public function add_notes(Request $request) {
        $method         = $request->method();
        $patient_id     = $request['patient_id'];
        $note_id        = $request['note_id'];

        if ($request->isMethod('post') && $patient_id > 0) {
             $this->validate($request, [
                'diet'              => 'required',
                'notes'             => 'required',
                'diagnosis'         => 'required',
                'medicines'         => 'required',
                'medicine_amount'   => 'required',
                'consulting_amount' => 'required',
                'received_amount'   => 'required',
                'appointment_time'  => 'required',
                'appointment_date'  => 'required',
            ]);
            $return                     = array();
            $postdata['diet']               = $request['diet'];
            $postdata['notes']              = $request['notes'];
            $postdata['diet']               = $request['diet'];
            $postdata['diagnosis']          = $request['diagnosis'];
            $postdata['medicines']          = $request['medicines'];
            $postdata['consulting_amount']  = $request['consulting_amount'];
            $postdata['medicine_amount']    = $request['medicine_amount'];
            $postdata['amount']             = $postdata['consulting_amount'] + $postdata['medicine_amount'];
            $postdata['received_amount']    = $request['received_amount'];
            $postdata['payment_mode']       = $request['payment_mode'];
            $postdata['created_date']       = date('Y-m-d H:i:s');
            $postdata['patient_id']         = $patient_id;

            $postdata['appointment_id']     = isset($request['appointment_id']) && $request['appointment_id'] != 0 ? $request['appointment_id'] : 0;
            $extra_payment_reason = 0;

            if ($postdata['received_amount'] > $postdata['amount']) {
                $extra_payment_reason = $request['extra_payment_reason'];
            }
            $postdata['extra_payment_reason']   = $extra_payment_reason;

            $insert                             = false;
            $a_data['appointment_date']         = date('Y-m-d', strtotime($request['appointment_date']));
            $a_data['appointment_time']         = ($request['appointment_time'] != "" ) ? date('H:i:s',strtotime($request['appointment_time'])) : "";;
            $a_data['type']                     = 3;
            $a_data['patient_id']               = $patient_id;
            $a_data['attend']                   = 1;
            $a_data['created_date']             = date('Y-m-d H:i:s');
            $a_data['doctor_id']                = 0;
            if ($note_id > 0) {
                $patient_notes          = Patient_notes::where('id',$note_id)->first();
                $insert                 = $patient_notes->update($postdata);
                $appointment            = Appointment::where('id', $patient_notes->appointment_id)->first();
                unset($a_data['created_date']);
                $a_data['modify_date']  = date('Y-m-d H:i:s');
                $appointment->update($a_data);
            } else {
                $appointment                    = Appointment::create($a_data);
                $id                             = $appointment->id;
                $postdata['appointment_id']     = $id;
                $insert                         = Patient_notes::create($postdata);
                if ($insert) {
                    $ipostdata['patient_id']        = $patient_id;
                    $ipostdata['appointment_id']    = $id;
                    $ipostdata['created_date']      = date('Y-m-d H:i:s');
                    $invoice                        = Invoice::create($ipostdata);
                }
            }
            if ($insert) {
                $return['status']  = TRUE ;
                $return['message'] = "Record Successfully Updated" ;
            } else {
                $return['status']  = FALSE ;
                $return['message'] = "Something went wrong" ;
            }
            echo json_encode($return);die;
        } else {
           return redirect(base_url());
        }
    }
    public function note_model($patient_id = 0,$id = 0) {
        $return             = array();
        $patient            = collect(Patient::getPatient($patient_id));
        $patient_notes      = collect(array());
        if ($id > 0) {
            $patient_notes      = collect(Patient_notes::where('id',$id)->first());
        }
        $data['time_slots']     = collect(Appointment::getTimeSlot());
        $payment_modes          = collect(payment_mode::all());
        $data['payment_modes']  = $payment_modes;
        $data['notes']          = $patient_notes;
        $data['patient']        = $patient;
        $data['patient_id']     = $patient_id;
        $appointment_id         = isset($patient_notes) && !empty($patient_notes['appointment_id']) ? $patient_notes['appointment_id'] : 0;
        if ($patient_id > 0) {
            $appointment = collect(array());
            if ($appointment_id > 0) {
                $appointment                        = Appointment::where('id', $appointment_id)->first()->toArray();
                $appointment['appointment_time']    = date("h:i A", strtotime($appointment['appointment_time']));
            }
            $data['appointment']= collect($appointment);
            $data['patient_id'] = $patient_id;
            $html               = view('portal.patient.ajax_note_model',$data)->render();
            $return['html']     = $html;
            $return['status']   = TRUE ;
            $return['message']  = "Success" ;
        } else {
            $return['status']  = FALSE ;
            $return['message'] = "Something went wrong" ;
        }
        echo json_encode($return);die;
    }
    public function get_notes($patient_id = 0,Request $request) {
       $method  = $request->method();
       $return  = array();
       if ($request->isMethod('post') && $patient_id > 0) {
             $data['notes']         = collect(Patient_notes::where('patient_id' ,$patient_id)->with('Appointment')->paginate($this->pagination));
             $data['patient']       = collect(Patient::getPatient($patient_id));
//             p($data['notes']);
             $html                  = view('portal.patient.ajax_notes_view',$data)->render();
             $return['html']        = $html ;
             $return['status']      = TRUE ;
             $return['message']     = "Success" ;
             echo json_encode($return);die;
       } else {
            return redirect(base_url());
       }
    }
    public function delete_notes($patient_id = 0 , $id = 0, Request $request) {
       $method  = $request->method();
       $return  = array();
       if ($request->isMethod('post')) {
           if($id > 0) {
                $notes                 = Patient_notes::where('id' ,$id)->first();
                if (!empty($notes)) {
                    $notes->delete();
                    $return['status']  = TRUE ;
                    $return['message'] = "Data Successfully deleted" ;
                } else {
                   $return['status']   = FALSE ;
                   $return['message']  = "Data not deleted" ; 
                }
           } else {
                $result['status']  = false;
                $result['message'] = "something wnt wrong";
           }
           echo json_encode($return);die;
       } else {
            return redirect(base_url());
       }
    }
    public function get_ajax_invoice(Request $request,$patient_id = 0)
    {
        $invoice = Invoice::query()
            ->select('angel_invoice.id','n.amount','n.notes','n.medicines','a.appointment_date','p.email')
            ->leftjoin("angel_appointment  as a", 'a.id', '=', 'angel_invoice.appointment_id')
            ->leftjoin("angel_patient  as p", 'p.id', '=', 'angel_invoice.patient_id')
            ->leftjoin("angel_patient_notes  as n", 'n.appointment_id', '=', 'a.id');
        
        if($request['query'])
        {
            $search = $request['query'];
            $invoice->where(function ($query) use($search) {
                $query->where('a.appointment_date', 'like', '%' . $search . '%')
                   ->orWhere('n.amount', 'like', '%' . $search . '%')
                   ->orWhere('n.medicines', 'like', '%' . $search . '%');
              });
        }
        elseif($request->orderBy)
        {
            $invoice->orderBy($request->orderBy, $request->ascending == 1 ? 'ASC' : 'DESC');
        }
        $data = $invoice->where('angel_invoice.patient_id',$patient_id)->paginate($request->limit ? $request->limit : 20);
        return response()->json($data); die;
    }
    public function invoice_report(Request $request, $invoice_id = 0) {
        $method         = $request->method();
        $data           = array();
        $data['invoice']= Invoice::getInvoice($invoice_id);
        if ($request->isMethod('post')) {
            $folderPath = getcwd() . '/uploads/invoice-pdf/';
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $filePath   = $folderPath.'patient-invoice.pdf';
            $pdf        = PDF::loadView('portal.patient.invoice_pdf', $data);
            $pdf->save($filePath);
            $sent_data['subject']       = "Invoice Copy | HETVI CLINIC";
            $sent_data['to']            = $data['invoice']['email'];
            $sent_data['message']       = 'portal.email.invoice';
            $sent_data['attachement']   = array($filePath);
            if ($this->send_mail($sent_data)) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $return['status']   = true;
                $return['message']  = "Email sucessfully sent.";
            } else {
                $return['status']   = false;
                $return['message']  = "Email not sent.";
            }
            echo json_encode($return);
        } else {
            $pdf    = PDF::loadView('portal.patient.invoice_pdf', $data);
            return $pdf->stream('invoice.pdf');
        }
    }
}   
