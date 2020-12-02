<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Medicine;
use App\Potency;
use App\Dosage;
use App\Blood;

class ToolsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        
        $toolType = collect(array(
                array('name' => 'blood', 'title' => 'Blood Group', 'data' => \App\Blood::all()),
                array('name' => 'religion', 'title' => 'Religion', 'data' => \App\Religion::all()),
                array('name' => 'medicine', 'title' => 'Medicine', 'data' => \App\Medicine::all()),
                array('name' => 'potency', 'title' => 'Potency', 'data' => \App\Potency::all()),
                array('name' => 'dosage', 'title' => 'Dosage', 'data' => \App\Dosage::all()),
                array('name' => 'repetition', 'title' => 'Repetition', 'data' => \App\Repetition::all()),
                array('name' => 'relative', 'title' => 'Relatives', 'data' => \App\Relative::all()),
                array('name' => 'payment_mode', 'title' => 'Payment Mode', 'data' => \App\Payment_mode::all()),
                array('name' => 'occupation', 'title' => 'Occupation', 'data' => \App\Occupation::all()),
                array('name' => 'organisation', 'title' => 'Organisation', 'data' => \App\Organisation::all()),
                array('name' => 'marital_status', 'title' => 'Marital Status', 'data' => \App\Marital_status::all()),
                array('name' => 'diet', 'title' => 'Diet', 'data' => \App\Diet::all()),
                array('name' => 'prognosis', 'title' => 'Prognosis', 'data' => \App\Prognosis::all())
            ));
        $data['tool_type']  = $toolType;
//        echo "<pre>"; print_r($data['tool_type']);die;
        return view('portal.tool.index',$data);
    }
    public function commit(Request $request) {
        $tool_type      = "angel_".$request->tool_type;
        $tool_id        = $request->tool_id;
        $insert_data    = array (
                            'name'        => $request->name,
                            );
        if($tool_id != "") {
            if(!empty($insert_data)) {
                
                if(DB::table($tool_type)->where('id',$tool_id)->update($insert_data)) {
                    $return['status']   = true;
                    $return['message']  = "Record Successfully Updated";
                } else {
                    $return['status']   = false;
                    $return['message']  = "Something went wrong";
                }
            } else {
                $return['status']   = false;
                $return['message']  = "Something went wrong";
            }
        } else {
            if(!empty($insert_data)) {
                
                if(DB::table($tool_type)->insert($insert_data)) {
                    $return['status']   = true;
                    $return['message']  = "Record Successfully Added";
                } else {
                    $return['status']   = false;
                    $return['message']  = "Something went wrong";
                }
            } else {
                $return['status']   = false;
                $return['message']  = "Something went wrong";
            }
        }
        $return['type']    = $request->tool_type;
        
        return response()->json($return);
    }
    public function delete(Request $request) {
        $tool_type = "angel_".$request->type;    
        $id        = $request->id;
        
         if($tool_type != "" && $id != "") {
            if(DB::table($tool_type)->where('id',$id)->delete()) {
                $return['status']   = true;
                $return['message']  = "Record Successfully Deleted";
            } else {
                $return['status']   = false;
                $return['message']  = "Something went wrong";
            }
           
         } else {
            $return['status']   = false;
            $return['message']  = "Something went wrong";
         }
         $return['type']    = $request->type;
         
         return response()->json($return);
    }
    public function tool_data(Request $request) {
        $tool_table         = "angel_".$request->type;
        $data['tool_type']  = $request->type;
        $data['tools']      = DB::table($tool_table)->get();
        $html               = view('portal.tool.tool_view',$data)->render();
        $return['html']     = $html;
        $return['type']     = $request->type;
        return response()->json($return);
    }

}
