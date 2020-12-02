<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;

class MasterController extends Controller
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
        return view('portal.master.index');
    }
    public function setup($id = "") {
        $data['user_detail']        = collect(array());
        if($id != "") {
            $user_data              = \App\User::where(array('id' => $id ,'type' => 2))->first();
            $data['user_detail']    = collect($user_data);            
        }
        return view('portal.master.form',$data);
    }
    public function commit(Request $request) {
        if($request->isMethod('POST')) {
            
            $id         = $request->master_id;
            $validate   = array();
            
            $validate['full_name']  =  'required';
            $validate['email']      =  'required';
            $validate['phone']      =  'required|numeric';
            $validate['username']   =  'required';
            
            if($id == "") {
                $validate['password']           =  'required';
                $validate['confirm_password']   =  'required';
            }
            
            $this->validate($request,$validate);

            
            $post_data['full_name']     = $request->full_name;
            $post_data['email']         = $request->email;
            $post_data['phone']         = $request->phone;
            $post_data['username']      = $request->username;
            $post_data['isActive']      = ($request->isActive == 'on') ? '1' :'0';;
            $password                   = $request->password;
            $confirm_password           = $request->confirm_password;
            
            if ($password != '' && ($password == $confirm_password)) {
                $post_data['visiblePassword']    = $password;
                $post_data['password']           = bcrypt($password);
            }
            $post_data['type']   = 2;
            if($id != "") {
                $user_data   = User::where('id',$id)->update($post_data);
                    
                if($user_data) {
                    Session::flash('success','Record Updated successfully');
                } else {
                    Session::flash('danger','Something went wrong');
                }
            } else {
                $post_data['createdDate']         = date('Y-m-d h:i:s');

                $user_data   = User::create($post_data);
                if($user_data) {
                    Session::flash('success','Record insert successfully');
                } else {
                    Session::flash('danger','Something went wrong');
                }
            }
            return redirect('/portal/master');
        } else {
            return redirect(base_url());
        }
    }
    public function delete($id = '') {
        $return   = array();
        if ($id != "") {
            if(User::where('id' ,$id)->delete()) {
                Session::flash('success','Record successfully Deleted');
            } else {
                Session::flash('danger','Something went wrong');
            }
        }else {
             Session::flash('danger','Something went wrong');
        }
       return redirect('/portal/master');
    }
    public function get_list(Request $request) {
        $method         = $request->method();
        $data           = array();
        $filter         = array();
        $filter_data    = json_decode(base64_decode($request->custom_filter));
        //p($filter_data);
       
        
        $user = User::query()
            ->select('id','full_name','email','phone','createdDate');           
        
        if($request['query'])
        {
            $search     = $request['query'];
            $user->where(function ($query) use($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                   ->orWhere('email', 'like', '%' . $search . '%')
                   ->orWhere('phone', 'like', '%' . $search . '%')
                   ->orWhere('createdDate', 'like', '%' . $search . '%');
              });
        }
        else if($request->orderBy)
        {
            $user->orderBy($request->orderBy, $request->ascending == 1 ? 'ASC' : 'DESC');
        }
        $user->where('type','=',2);
        
        $data           = $user->paginate($request->limit ? $request->limit : 20)->toArray();
        $return_data    = array();
        if (!empty($data['data'])) {
            foreach ($data['data'] as $row) {
                $row_data                       = array();
                $row_data['id']                 = $row['id'];
                $row_data['full_name']          = $row['full_name'];
                $row_data['email']              = $row['email'];
                $row_data['phone']              = $row['phone'];
                $row_data['createdDate']        = date('d-m-Y', strtotime($row['createdDate']));
                $return_data[]                  = $row_data;
            }
        }
        if (!empty($return_data)) {
            $data['data']               = $return_data; 
        }
        return response()->json($data); die;
    }
   
}
