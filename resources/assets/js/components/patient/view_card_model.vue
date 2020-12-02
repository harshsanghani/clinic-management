
<template>
    <transition name="view_card_modal">
        <form :action="base_url + 'portal/patient/patient_card/'+patient.id" method="post"  id="card_frm" target="_blank" >
            <div class="row">
                  <input type="hidden" :value="csrftoken" name="_token"/>
                <div class="col-md-6">
                    <h4 class="preview_title">Please select data to be included on the card.</h4>
                    <div class="patient_card">
                        <div class="row">
                            <div class="col-md-7">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  v-on:change="filterDetail" value="phisician"  id="phisician" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Physician Name</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  v-on:change="filterDetail" value="logo"  id="logo" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Clinic Logo</span>
                                </label>
                            </div>
                            <div class="col-md-7">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"   v-on:change="filterDetail" value="patient"  id="patient" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Patient Middle Name</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  id="img"  v-on:change="filterDetail" value="img"  checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Photo</span>
                                </label>
                            </div>
                            <div class="col-md-7">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  v-on:change="filterDetail" value="register" id="register" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Registration ID</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  id="age"  v-on:change="filterDetail"  value="age"  checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Age</span>
                                </label>
                            </div>
                            <div class="col-md-7">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  id="date" v-on:change="filterDetail" value="date"  checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Registration Date</span>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  id="blood" v-on:change="filterDetail" value="blood" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Blood Group</span>
                                </label>
                            </div>
                            <div class="col-md-7">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input active" name="card_detail[]"  id="emergency"  v-on:change="filterDetail" value="emergency" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Emergency Number</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="preview_title">Preview</h4>
                    <div class="patient_card">
                        <div class="row">
                            <div class="col-md-3 col-xs-3 p-r-0">
                                <img v-if="image_path != '' "  v-bind:src="base_url + image_path" class="pateint_img img_value">
                                <img v-else v-bind:src="base_url + 'assets/portal-side/img/avatar.png'" class="pateint_img img_value">
                                <img v-bind:src="base_url + 'assets/portal-side/img/avatar.png'"  class="pateint_img img-value" style="display:none;">
                            </div>
                            <div class="col-md-9 col-xs-9 patient_card_info">
                                <p class="phisician_name phisician_value">Dr. Dipak Soni, D.H.M.S, D.O.S</p><p class="phisician-value" style="display:none;">Dr.</p>
                                <div class="row">
                                    <div class="col-md-7 col-xs-8">
                                        <p class="date_value"><b>Date :</b>{{ this.patient["created_date"] }}</p><p class="date-value" style="display:none;"><b>Date :</b></p>
                                        <p class="register_value"><b>Patient Reg No. :</b>{{ this.patient["id"] }}</p><p class="register-value" style="display:none;"><b>Patient Reg No. :</b></p>
                                    </div>
                                    <div class="col-md-5 col-xs-3">
                                        <img class="logo_value" v-bind:src="base_url + 'assets/portal-side/img/logo.png'"  style="width: 68px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 patient_card_info">
                                <p class="patient_value" style="padding-top: 5px;"><b>Name : </b>{{ this.patient["title"]   }}  {{ this.patient["firstname"] }} {{ this.patient["middlename"] }}  {{ this.patient["lastname"] }} </p><p class="patient-value" style="padding-top: 5px;display:none;"><b>Name : </b></p>
                                <p class="age_value"><b>Age : </b>{{ this.patient["age"] }}</p><p class="age-value" style="display:none;"><b>Age : </b></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 patient_card_info">
                                <p class="blood_value"><b>Blood Group : </b><span v-if="this.patient['blood_info']">{{ this.patient["blood_info"].name }} </span> </p><p class="blood-value" style="display:none;"><b>Blood Group : </b></p>
                            </div>
                            <div class="col-md-7 patient_card_info">
                                <p class="emergency_value"><b>Emergency No. : </b>{{ this.patient["phone"] }} </p><p class="emergency-value" style="display:none;"><b>Emergency No. : </b></p>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-6 col-xs-6">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="$emit('close')">Cancel</button>
                        </div>
                        <div class="col-md-6 col-xs-6 text-right">
                            <button type="submit" class="btn btn-primary" target="_blank" @click="CardCommit()">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </transition>
</template>
<script>
   export default {
        props: {
            patient: {
               type: Object,
               required: true,
            }
        },
        data(){
           return {
                csrftoken       : "",
                base_url        : base_url,
                image_path      : ((typeof(this.patient.image_info) != "undefined" && this.patient.image_info  !== null) ? this.patient.image_info.path : ''),
            }
       },
       mounted()
       {
             this.csrftoken = document.querySelector('meta[name="csrf-token"]').content
       },
       methods: {
            filterDetail: function (event) {
                var name = event.target.getAttribute('id');
                if (event.target.classList.contains('active') ) {
                    event.target.classList.remove('active');
                    $('.'+name+'-value').css('display','block');
                    $('.'+name+'_value').css('display','none');
                } else {
                    event.target.classList.add('active');
                    $('.'+name+'-value').css('display','none');
                    $('.'+name+'_value').css('display','block');
                }
            },
            CardCommit() {
                document.getElementById("card_frm").submit();
            },
       }
   }
</script>