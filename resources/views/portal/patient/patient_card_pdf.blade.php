<div style="width: 70%;float: left;margin: 0 auto;border: 2px solid #b92026;position: relative;min-height: 1px;box-sizing: border-box;display: block;" class="main_container">
    <h3 style="color: #b92026;font-size: 13pt;text-align: center;margin-top: 12px;margin-bottom: 0px;line-height: 1.1;font-weight: bold;display: block;box-sizing: border-box;">Hospital name goes here</h3>
    <hr style="border-top: 1px solid #b92026;box-sizing: content-box;height: 0;margin-bottom: 0.2rem;overflow: visible;">
    <div style="box-sizing: border-box;display: block; height:23%;">
        <div style="margin-right: -15px;margin-left: -15px;box-sizing: border-box;display: block; padding-top: 15px;">
            <div style="width: 20%;float: left;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;display: block;">
                @if(!empty($card_detail) && in_array('img',$card_detail) && isset($patient['image_info']['path']))
                <img src="{{asset($patient['image_info']['path'])}}" style="width: 108px; height: 108px;margin-top: 0px;margin-left: 12px;border: 1px solid #d3d3d3;display: block;box-sizing: border-box;" alt="">
                @else
                <img src="{{asset('assets/portal-side/img/avatar.png')}}" style="width: 108px; height: 108px;margin-top: 0px;margin-left: 12px;border: 1px solid #d3d3d3;display: block;box-sizing: border-box;" alt="">
                @endif
            </div>
            <div style="width: 45%;margin-left: 150px;margin-top: 5px;float: left;position: relative;min-height: 1px;padding-right: 15px;display: block;padding-left: 15px;box-sizing: border-box;">
               @if(!empty($card_detail) && in_array('phisician',$card_detail))
                    <p style="color: #231f20;font-weight: bold;font-size: 10pt;line-height: 10px;margin: 0 0 15px;box-sizing: border-box;display: block;font-family: Gill Sans MT;text-transform: uppercase;">Hospital name goes here</p>
                @else
                    <p style="color: #231f20;font-weight: bold;font-size: 10pt;line-height: 10px;margin: 0 0 15px;box-sizing: border-box;display: block;font-family: Gill Sans MT;text-transform: uppercase;">Dr.</p>
                @endif
                @if(!empty($card_detail) && in_array('date',$card_detail))
                    <p style="color: #231f20;font-size: 10pt;line-height: 10px;margin: 0 0 12px;box-sizing: border-box;display: block;font-family: Gill Sans MT;"><strong style="color: #231f20">Date :</strong> {{isset($patient['created_date']) ? date('d-m-Y', strtotime($patient['created_date'])) : "" }}</p>
                @else
                    <p style="color: #231f20;font-size: 10pt;line-height: 10px;margin: 0 0 12px;box-sizing: border-box;display: block;font-family: Gill Sans MT;"><strong style="color: #231f20">Date :</strong> N/A</p>
                @endif
                @if(!empty($card_detail) && in_array('register',$card_detail))
                    <p style="color: #231f20;font-size: 10pt;line-height: 10px;margin: 0 0 12px;box-sizing: border-box;display: block;font-family: Gill Sans MT;"><strong style="color: #231f20">Patient Reg No.:</strong> {{isset($patient['id']) ? $patient['id'] : ""}}</p>
                @else
                    <p style="color: #231f20;font-size: 10pt;line-height: 10px;margin: 0 0 12px;box-sizing: border-box;display: block;font-family: Gill Sans MT;"><strong style="color: #231f20">Patient Reg No.:</strong> N/A</p>
                @endif
                @if(!empty($card_detail) && in_array('patient',$card_detail))
                    <p style="color: #231f20;font-size: 10pt;line-height: 10px;margin: 0 0 12px;box-sizing: border-box;display: block;font-family: Gill Sans MT;"><strong style="color: #231f20">Name:</strong> {{ucfirst($patient['title']) . " " . ucfirst($patient['firstname'])." ". ucfirst($patient['middlename']) . " " . ucfirst($patient['lastname'])}}</p>
                @else
                    <p style="color: #231f20;font-size: 10pt;line-height: 10px;margin: 0 0 12px;box-sizing: border-box;display: block;font-family: Gill Sans MT;"><strong style="color: #231f20">Name:</strong> {{ucfirst($patient['title']) . " " . ucfirst($patient['firstname'])." ". ucfirst($patient['lastname'])}}</p>
                @endif
                
            </div>
            <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: 30px;padding-left: 0px;box-sizing: border-box;display: block;">
                  @if(!empty($card_detail) && in_array('logo',$card_detail))
                    <img src="{{asset('assets/portal-side/img/logo.png')}}" style="width: 100px;margin-top: 0px;padding-right: 10px;margin-left: 12px;display: block;box-sizing: border-box;" alt="">
                    @endif
            </div>
            <div style="width: 100%;margin-top: 110px;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;display: block;">
                <table>
                       <tbody>
                           <tr>
                               <td style="width: 20%;padding-left: 15px;">
                                   @if(!empty($card_detail) && in_array('age',$card_detail))
                                   <p style="color: #231f20;font-size: 10pt;line-height: 10px;width: 200%;box-sizing: border-box;display: inline-block;font-family: Gill Sans MT;"><strong style="color: #231f20">Age:</strong> {{ (isset($patient['age']) && $patient['age'] != "" ) ? $patient['age'] : "N/A" }}</p>
                                   @else
                                   <p style="color: #231f20;font-size: 10pt;line-height: 10px;width: 200%;box-sizing: border-box;display: inline-block;font-family: Gill Sans MT;"><strong style="color: #231f20">Age:</strong> N/A</p>
                                   @endif
                               </td>
                               <td style="width: 30%; padding-left: 70px;">
                                   @if(!empty($card_detail) && in_array('blood',$card_detail))
                                   <p style="color: #231f20;font-size: 10pt;line-height: 10px;width: 200%;box-sizing: border-box;display: inline-block;font-family: Gill Sans MT;"><strong style="color: #231f20">Blood Group:</strong> {{ (isset($patient['blood_info']['name']) && $patient['blood_info']['name'] != "" ) ? $patient['blood_info']['name'] : "N/A" }}</p>
                                   @else
                                   <p style="color: #231f20;font-size: 10pt;line-height: 10px;width: 200%;box-sizing: border-box;display: inline-block;font-family: Gill Sans MT;"><strong style="color: #231f20">Blood Group:</strong> N/A</p>
                                   @endif
                               </td>
                               <td style="width: 30%;text-align: left;  padding-left: 65px;">
                                   @if(!empty($card_detail) && in_array('emergency',$card_detail))
                                   <p style="color: #231f20;font-size: 10pt;line-height: 10px;width: 200%;box-sizing: border-box;display: inline-block;font-family: Gill Sans MT;"><strong style="color: #231f20">Emergency No:</strong> {{ isset($patient['phone']) ? $patient['phone'] : "" }}</p>
                                   @else
                                   <p style="color: #231f20;font-size: 10pt;line-height: 10px;width: 200%;box-sizing: border-box;display: inline-block;font-family: Gill Sans MT;"><strong style="color: #231f20">Emergency No:</strong> N/A</p>
                                   @endif
                               </td>
                           </tr>
                       </tbody>
                   </table>
            </div>
        </div>
        <div style="margin-right: -15px;margin-left: -15px;box-sizing: border-box;display: block; padding-top: 0px;">
            <div style="text-align: center;width: 100%;float: left;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;display: block;">
                <hr style="border-top: 1px solid #b92026;box-sizing: content-box;height: 0;overflow: visible;">
                <h6 style="padding: 0px 0px 5px;font-size: 10pt;color: #000;font-weight: normal;margin-bottom: 10px;margin-top: 0;box-sizing: border-box;display: block;"><strong>Address:</strong>{{ isset($patient['address_info']['address']) ? $patient['address_info']['address'] : ""}}</h6>
            </div>
        </div>
    </div>
</div>