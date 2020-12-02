<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Patient;
use App\Medicine;
use App\Potency;
use App\Dosage;
use App\Repetition;
use App\Certificates;


class CertificatesController extends Controller {
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $report_type = $request->report_type;
        if($report_type != "") {
            if($request->isMethod('POST')) {
                $data   = Certificates::getRecords($report_type);
                return response()->json($data);
                
            } elseif ($request->isMethod('GET')) {
                $data['report_type']    = $report_type;
                $data['report_name']    = \App\Report_type::get_report_name($report_type);
                return view('portal.certificates.index',$data);
            } 
        } else {
            return redirect(base_url());
        }
    }
    public function setup($report_type = "",$id = "") {
        $type = $report_type;
        $data['report_type']        = $report_type;
        $data['report_name']        = \App\Report_type::get_report_name($type);
        $data['report_detail']      = collect(array());
        $data['certificate_detail'] = collect(array());
        $data['id']                 = collect(array()); 
        if ($id != '') {
            $certificate_data   = \App\Certificates::where('id',$id)->first();
            if (!empty($certificate_data)) {
                $data['id']                 = $id;
                $data['report_detail']      = collect($certificate_data);
                $data['certificate_detail'] = collect(json_decode($certificate_data->certificate_detail));
                
            }
            //p($data);
        }
        $data['patient_options']        = collect(Patient::all());
        if ($type == 1) {
            $data['medicine_options']       = collect(Medicine::all());
            $data['potency_options']        = collect(Potency::all());
            $data['dosage_options']         = collect(Dosage::all());
            $data['repetition_options']     = collect(Repetition::all());                
            $form_name                      = 'prescription_form';
        } else if ($type == 2) {
            //done
            $data['patient_options']        = collect(Patient::all());
            $form_name                      = 'patient_bill_form';
        } else if ($type == 3) {
            //done
            $form_name                      = 'receipt_form';
            $data['relatives']              = collect(\App\Relative::all());
        } else if ($type == 4) {
            //done
            $form_name                      = 'abroad_certificate';
            $data['relatives']              = collect(\App\Relative::all());
        } else if ($type == 5) {
            //done
            $form_name                      = 'fitness_certificate';
        } else if ($type == 6) {
            //done
            $form_name                      = 'sickness_certificate';
        } else if ($type == 7) {
            //done
            $form_name                      = 'patient_report';
        } else if ($type == 8) {
            //done
            $form_name                      = 'reference_latter';
        } else if ($type == 9) {
            //done
            $form_name                      = 'customized';
        } else if ($type == 10) {
            //done
            $form_name                      = 'request_investigation';
            $data['investigations']          = collect(\App\Investigation::all());
        }
        if ($form_name != '') {
            return view('portal.certificates.'.$form_name, $data);
        } else {
            return redirect(base_url());
        }
        
    }
    public function commit(Request $request,$report_type = "") {
        if($report_type != "") {
            if($request->isMethod('POST')) {
                //p($request->all());
                $post_data['date']                  = date('Y-m-d', strtotime($request->date));
                $post_data['report_type']           = $report_type;
                $post_data['patient_id']            = $request->patient;
                $post_data['certificate_detail']    = json_encode($request->certificate);
                
                $id = $request->cer_id;
                if($id != "") {
                    $certificate_data   = Certificates::where('id',$id)->update($post_data);
                    
                    if($certificate_data) {
                        Session::flash('success','Record Updated successfully');
                    } else {
                        Session::flash('danger','Something went wrong');
                    }
                    return redirect('/portal/certificate/setup/'.$report_type.'/'.$id);
                } else {
                    $post_data['created_date']          = date('Y-m-d h:i:s');
                    
                    $certificate_data   = Certificates::create($post_data);
                    if($certificate_data) {
                        Session::flash('success','Record insert successfully');
                    } else {
                        Session::flash('danger','Something went wrong');
                    }
                }
                return redirect('/portal/certificate/'.$report_type);
            } else {
                return redirect(base_url());
            }
        } else {
            return redirect(base_url());
        }
    }
    public function delete($report_type = "",$id = '') {
        $return   = array();
        if ($id != "") {
            if(Certificates::where('id' ,$id)->delete()) {
                Session::flash('success','Record successfully Deleted');
            } else {
                Session::flash('danger','Something went wrong');
            }
        }else {
             Session::flash('danger','Something went wrong');
        }
        //return response()->json($return);
       return redirect('/portal/certificate/'.$report_type);
    }
    public function prescription_list() {
        $data   = Certificates::getRecords();
        return response()->json($data);
    }
    public function prescription_setup($id = '') {
        $data['patient_options']        = collect(Patient::all());
        $data['medicine_options']       = collect(Medicine::all());
        $data['potency_options']        = collect(Potency::all());
        $data['dosage_options']         = collect(Dosage::all());
        $data['repetition_options']     = collect(Repetition::all());
        if(isset($id) && $id > 0 ) {
            $prescription               = collect(Certificates::getCertificates($id));
            $data['prescription']       = $prescription;
            $data['certificate_detail'] = collect(json_decode($prescription['certificate_detail']));
        }
        return view('portal.certificates.prescription.form', $data);
    }
    
     public function prescription_commit(Request $request) {
        $return         = array();
        $this->validate($request, [
            'prescription_date'     => 'required',
            'patient_name'          => 'required'
        ]);
        $patient_id     = $request->patient_id;
        $insert_data    = array (
            'date'                  => date('Y-m-d', strtotime($request->prescription_date)),
            'patient_id'            => $request->patient_name,
            'report_type'           => $request->patient_name,
            'certificate_detail'    => json_encode($request->certificate),
            'created_date'          => date('Y-m-d h:i:s', time()),
            'modify_date'           => date('Y-m-d h:i:s', time())
        );
        if (!empty($insert_data)) {
            $patient_data           = Certificates::create($insert_data);
            if($patient_data->id > 0) {
                $patient_id         = $patient_data->id;
                $return['message']  = "Prescription record save successfully";
            }else{
                $return['message']  = "Record not save";
            }
        } else {
            $return['message']      = "Sometthing went wrong";
        }
        if ($patient_id > 0) {
            $return['status']       = true;
            $return['patient_id']   = $patient_id;
        } else {
            $return['status']       = false;
            $return['message']      = "Sometthing went wrong";
        }
        //redirect('/portal/prescription');
        return response()->json($return);
    }
}
