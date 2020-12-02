<template>
    <div class="card">
        <div class="card-block">
            <div class="tab-container" id="tabs">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home_2" role="tab" aria-expanded="true" @click="showtab('#home_2')">Personal Details</a>
                    </li>
                    <li  class="nav-item">
                        <a v-if="this.patient_id && this.patient_id > 0 " class="nav-link" data-toggle="tab" @click="showtab('#profile_2')" href="#profile_2" role="tab" aria-expanded="false">General Details</a>
                        <a v-if="!this.patient_id" class="nav-link" href="javascript:void(0)">General Details</a>
                    </li>
                    <li class="nav-item">
                        <a v-if="this.patient_id && this.patient_id > 0 " class="nav-link" data-toggle="tab" @click="showtab('#messages_2')" href="#messages_2" role="tab" aria-expanded="false">contact Details</a>
                        <a v-if="!this.patient_id" class="nav-link" href="javascript:void(0)">contact Details</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="home_2" role="tabpanel" aria-expanded="true">
                        <div class="col-sm-12">
                            <form v-on:submit.prevent="personalCommit()" id="personal_detail">
                                <input type="hidden" name="patient_id" :value="patient_id" id="patient_id"/> 
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <select class="form-control custom_state error" v-model="patientFields.title" name="title" id="title">
                                                <option value="dr" selected >Dr.</option>
                                                <option value="mr" >Mr.</option>
                                                <option value="mrs" >Mrs.</option>
                                                <option value="miss" >Miss.</option>
                                                <option value="master" >Master</option>
                                            </select>
                                            <span v-if="allErrors.title" :class="['help-inline']">{{ allErrors.title[0] }}</span>
                                        </div>
                                    </div>                                
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" v-model="patientFields.firstname" name="firstname" value="">
                                            <span v-if="allErrors.firstname" :class="['help-inline']">{{ allErrors.firstname[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" v-model="patientFields.middlename" name="middlename" value="">
                                            <span v-if="allErrors.middlename" :class="['help-inline']">{{ allErrors.middlename[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" v-model="patientFields.lastname" name="lastname" value="">
                                            <span v-if="allErrors.lastname" :class="['help-inline']">{{ allErrors.lastname[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" id="email" class="form-control" v-model="patientFields.email" name="email" value="">
                                            <span v-if="allErrors.email" :class="['help-inline']">{{ allErrors.email[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="number" class="form-control phone-mask1" v-model="patientFields.phone" name="phone"  id="phone">
                                            <span v-if="allErrors.phone" :class="['help-inline']">{{ allErrors.phone[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Alternate Phone</label>
                                            <input type="number" class="form-control phone-mask1" v-model="patientFields.alternate_phone" name="alternate_phone" value="">
                                             <span v-if="allErrors.alternate_phone" :class="['help-inline']">{{ allErrors.alternate_phone[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Birth Date (MM/DD/YYYY)</label>
                                            <datepicker name="birthdate"  :value="patientFields.birthdate" format="MM/dd/yyyy" input-class="form-control" ></datepicker>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <div class="gender_box">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" Checked name="gender" value="male" v-model="patientFields.gender" id="gender" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Male</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio"  name="gender" id="gender" v-model="patientFields.gender" value="female" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Female</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <select class="form-control custom_state error" v-model="patientFields.blood_group" id="blood_group" name="blood_group">
                                                <option value="">Select Blood Group</option>
                                                <option v-for="bl in blood_options"  :value="bl.id"  >{{ bl.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <select class="form-control custom_state error" v-model="patientFields.religion" id="religion" name="religion">
                                                <option value="">Select Religion</option>
                                                <option v-for="rg in religion_options"  :value="rg.id" >{{ rg.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Reference</label>
                                            <input type="text" class="form-control" v-model="patientFields.refereace" name="refereace" value="" id="refereace">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div id="img"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Profile Image</label>
                                            <input type='file'  @change="showimage()" name="avatar" ref="avatar" id="avatar" class="form-control"/>
                                        </div>  
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                             <img v-if="image_path != '' "  v-bind:src="base_url + image_path"   width="85" heigth="85" id="show_image">
                                             <img v-else v-bind:src="base_url + 'assets/portal-side/img/avatar.png'"   width="85" heigth="85" id="show_image">
                                         </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" id="submit" class="btn btn-success btn-lg waves-effect">Save Details</button>
                                    </div>
                                </div>                                                        
                            </form>    
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile_2" role="tabpanel" aria-expanded="false">
                        <div class="col-sm-12">
                            <form v-on:submit.prevent="generalDetailsCommit()" id="general_details">
                                <input type="hidden" name="patient_id" :value="patient_id">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Occupation</label>
                                            <select class="form-control custom_state error" id="occupation" name="occupation" v-model="patientFields.occupation" >
                                                <option value="">-Select Occupation-</option>
                                                <option v-for="oc in occupation_options"  :value="oc.id" >{{ oc.name }}</option>
                                            </select>
                                            <span v-if="allErrors.occupation" :class="['help-inline']">{{ allErrors.occupation[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Maritial status</label>
                                            <select class="form-control custom_state error" id="maritial_status" name="maritial_status" v-model="patientFields.maritial_status">
                                                <option value="">-Select-</option>
                                                <option v-for="ms in marital_status_options"  :value="ms.id" >{{ ms.name }}</option>
                                            </select>
                                            <span v-if="allErrors.maritial_status" :class="['help-inline']">{{ allErrors.maritial_status[0] }}</span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Diet</label>
                                            <select class="form-control custom_state error" id="diet" name="diet" v-model="patientFields.diet" >
                                                <option value="">-Select-</option>
                                                <option v-for="dt in diet_options"  :value="dt.id" >{{ dt.name }}</option>
                                            </select>
                                            <span v-if="allErrors.diet" :class="['help-inline']">{{ allErrors.diet[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Organization</label>
                                            <select class="form-control custom_state error" id="organization" name="organization" v-model="patientFields.organization" >
                                                <option value="">-Select-</option>
                                                <option v-for="org in organisation_options"  :value="org.id" >{{ org.name }}</option>
                                            </select>
                                            <span v-if="allErrors.organization" :class="['help-inline']">{{ allErrors.organization[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Prognosis</label>
                                            <select class="form-control custom_state error" id="prognosis" name="prognosis" v-model="patientFields.prognosis" >
                                                <option value="">-Select-</option>
                                                <option v-for="pr in prognosis_options"  :value="pr.id" >{{ pr.name }}</option>
                                            </select>
                                            <span v-if="allErrors.prognosis" :class="['help-inline']">{{ allErrors.prognosis[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" id="submit" class="btn btn-success btn-lg waves-effect">Save Details</button>
                                    </div>
                                </div>
                            </form>   
                        </div>
                    </div>
                    <div class="tab-pane fade" id="messages_2" role="tabpanel">
                        <form v-on:submit.prevent="contactDetailsCommit()" id="contact_details">
                            <input type="hidden" name="address_id" :value="address_id">
                            <input type="hidden" name="patient_id" :value="patient_id">

                            <div class="row">
                                <div class="card-header">
                                    <h2 class="card-title">Current address</h2>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group"> 
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address" id="address" value="" v-model="addressFields.address"> 
                                            <span v-if="allErrors.address" :class="['help-inline']">{{ allErrors.address[0] }}</span>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group"> 
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city" id="city" value=""  v-model="addressFields.city">
                                            <span v-if="allErrors.city" :class="['help-inline']">{{ allErrors.city[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group"> 
                                            <label>State</label>
                                            <input type="text" class="form-control" name="state" id="state" value="" v-model="addressFields.state">
                                            <span v-if="allErrors.state" :class="['help-inline']">{{ allErrors.state[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group"> 
                                            <label>Country</label>
                                            <input type="text" class="form-control" name="country" id="country" value=""  v-model="addressFields.country">
                                            <span v-if="allErrors.country" :class="['help-inline']">{{ allErrors.country[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group"> 
                                            <label>Zipcode</label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="" v-model="addressFields.zipcode" >
                                            <span v-if="allErrors.zipcode" :class="['help-inline']">{{ allErrors.zipcode[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"> 
                                    <input type="checkbox" @click="same_address();" name="same_address" id="same_address">
                                    <label for="same_address">Same as Current Address</label>
                                </div>
                            </div>
                            <div class="parmanent_box">
                                <div class="row">
                                    <div class="card-header">
                                        <h2 class="card-title">Permanent address</h2>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group"> 
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="" v-model="addressFields.permanent_address" >
                                                <span v-if="allErrors.permanent_address" :class="['help-inline']">{{ allErrors.permanent_address[0] }}</span>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group"> 
                                                <label>City</label>
                                                <input type="text" class="form-control" name="permanent_city" id="permanent_city" value="" v-model="addressFields.permanent_city">
                                                <span v-if="allErrors.permanent_city" :class="['help-inline']">{{ allErrors.permanent_city[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"> 
                                                <label>State</label>
                                                <input type="text" class="form-control" name="permanent_state" id="permanent_state" value=""  v-model="addressFields.permanent_state">
                                                <span v-if="allErrors.permanent_state" :class="['help-inline']">{{ allErrors.permanent_state[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group"> 
                                                <label>Country</label>
                                                <input type="text" class="form-control" name="permanent_country" id="permanent_country" value=""  v-model="addressFields.permanent_country">
                                                <span v-if="allErrors.permanent_country" :class="['help-inline']">{{ allErrors.permanent_country[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"> 
                                                <label>Zipcode</label>
                                                <input type="text" class="form-control" name="permanent_zipcode" id="permanent_zipcode" value="" v-model="addressFields.permanent_zipcode">
                                                <span v-if="allErrors.permanent_zipcode" :class="['help-inline']">{{ allErrors.permanent_zipcode[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="submit" class="btn btn-success btn-lg waves-effect">Save Details</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
    import Datepicker from 'vuejs-datepicker';
   export default {
        components: {
            Datepicker
        },
        props: {
            patient: {
               type     : Array,
               required : true,
            },
            address_info: {
               type     : Array,
               required : true,
            },
            blood_options: {
               type     : Array,
               required : true,
            },
            religion_options: {
               type     : Array,
               required : true,
            },
            prognosis_options: {
               type     : Array,
               required : true,
            },
            occupation_options: {
               type     : Array,
               required : true,
            },
            organisation_options: {
               type     : Array,
               required : true,
            },
            marital_status_options: {
               type     : Array,
               required : true,
            },
            diet_options: {
               type     : Array,
               required : true,
            },
        },
       data(){
           return {
                patientFields   : ((typeof(this.patient) != "undefined" && this.patient  !== null) ? this.patient : {}),
                addressFields   : ((typeof(this.address_info) != "undefined" && this.address_info  !== null ) ? this.address_info : {}),
                image_path      : ((typeof(this.patient.image_info) != "undefined" && this.patient.image_info  !== null) ? this.patient.image_info.path : ''),
                patient_id      : this.patient['id'],
                address_id      : ((typeof(this.patient.address_info) != "undefined" && this.patient.address_info  !== null) ? this.patient.address_info.id : ''),
                errors          : [],
                allErrors       : [],
                base_url        : base_url,
           }
       },
       mounted()
       {
       },
       methods: {
            personalCommit() {

                let currentObj      = this;
                var form_data       = document.getElementById('personal_detail');
                var p_data          = new FormData(form_data);
                axios.post(portal_url + '/patient/commit',p_data,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }})
                .then(function (response) {
                    if(response.data.status) {
                        currentObj.patient_id = response.data.patient_id;
                        showMessage('success', response.data.message);
                    }
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
            },
            generalDetailsCommit() {

                let currentObj          = this;
                var g_form_data         = document.getElementById('general_details');
                var g_data              = new FormData(g_form_data);
                axios.post(portal_url + '/patient/save_general_detail', g_data )
                .then(function (response) {
                    if(response.data.status) {
                        showMessage('success', response.data.message);
                    }
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
            },
            contactDetailsCommit() {

                let currentObj      = this;
                var c_form_data       = document.getElementById('contact_details');
                var c_bodyFormData    = new FormData(c_form_data);

                axios.post(portal_url + '/patient/save_contact_detail', c_bodyFormData)
                .then(function (response) {
                    if(response.data.status) {
                        currentObj.address_id = response.data.address_id;
                        showMessage('success', response.data.message);
                    }
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
            },
            same_address:function() {
                if ($('#same_address').is(':checked')) {
                    $('#permanent_address').val($('#address').val());
                    $('#permanent_city').val($('#city').val());
                    $('#permanent_state').val($('#state').val());
                    $('#permanent_country').val($('#country').val());
                    $('#permanent_zipcode').val($('#zipcode').val());
                } else {
                    $('#permanent_address').val("");
                    $('#permanent_city').val("");
                    $('#permanent_state').val("");
                    $('#permanent_country').val("");
                    $('#permanent_zipcode').val("");
                }
            },
            showtab:function(id) {
                $('.nav-link').removeClass('active');
                $(id).tab('show');
            },
            showimage:function() {
                var image = $('#avatar')[0].files[0];
                if (image) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('#show_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(image);
              }
            }
            
       }
   }
</script>
