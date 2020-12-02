<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investigation_type;
use App\Investigation;
use DB;

class InvestigationController extends Controller
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
        
        $toolType           = Investigation_type::all();
        $new_data           = array();
        if(!empty($toolType)) {
            foreach ($toolType as $type) {
                $new_data[$type['id']]["id"]    = $type["id"];
                $new_data[$type['id']]["name"]  = $type["name"];
                $new_data[$type['id']]["class"] = "inv".$type["id"];
            }
        }
        $data['tool_type']  = collect($new_data);
        //p($data['tool_type']);
        return view('portal.investigation.index',$data);
    }
    public function commit(Request $request) {
        $tool_id        = $request->tool_id;
        $insert_data    = array (
                            'type'        => $request->type_id,
                            'name'        => $request->name,
                            );
        if($tool_id != "") {
            if(!empty($insert_data)) {
                if(Investigation::where('id', $tool_id)->update($insert_data)) {
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
                if(Investigation::create($insert_data)) {
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
        $return['type_id']  = $request->type_id;
        $return['type']     = $request->tool_type;
        return response()->json($return);
    }
    public function delete(Request $request) {
        $tool_type  = $request->type;    
        $id         = $request->id;
        $type_id    = $request->type_id;

        if($id != "") {
           if(Investigation::where('id',$id)->delete()) {
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
        
        $return['type']     = $tool_type;
        $return['type_id']  = $type_id;
        
        return response()->json($return);
    }
     public function tool_data(Request $request) {
        $tool_id            = $request->type_id;
        //p($tool_id);
        $data['tool_type']  = $request->type;
        $data['tool_id']    = $tool_id;
        $data['tools']      = Investigation::where('type', $tool_id)->get();
        //p($data['tools']);
        $html               = view('portal.investigation.tool_view',$data)->render();
        $return['html']     = $html;
        $return['type']     = $request->type;
        $return['type_id']  = $request->type_id;
        return response()->json($return);
    }

}
