<template>
    <form :action="base_url + 'portal/certificate/commit/'+report_id" method="post" class="abroad_form">
        <input type="hidden" :value="csrftoken" name="_token"/>
        <input type="hidden" :value="cer_id" name="cer_id"/>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">{{report_val.name}}</h2>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date (DD-MM-YYYY)</label>
                            <input type="date" v-model="rep_detail.date" class="form-control date-mask" name="date" placeholder="Select date" value="">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Patient</label>
                            <select class="form-control patient_list" name="patient" v-model="rep_detail.patient_id">
                                <option value="">-All-</option>
                                <option v-for="pt in patient_options"  :value="pt.id" >{{ pt.firstname }} {{ pt.lastname }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h2 class="card-title">Info. of person carrying the medicine(s)</h2>
            </div>
            <div class="card-block">
                 <div class="row">
                    <div class="col-md-4">
                        <label>Title</label>
                        <select class="form-control custom_state error" v-model="cert_detail.carry_person_title" name="certificate[carry_person_title]">
                            <option value="dr">Dr.</option>
                            <option value="mr">Mr.</option>
                            <option value="mrs">Mrs.</option>
                            <option value="miss">Miss.</option>
                            <option value="master">Master</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Name</label>
                        <input type="text" v-model="cert_detail.carry_person_name" class="form-control" name="certificate[carry_person_name]" value=""/>
                    </div>
                    <div class="col-sm-4">
                        <label>Relative of Patient</label>
                        <div class="form-group">
                            <select class="form-control" v-model="cert_detail.carry_person_relation" name="certificate[carry_person_relation]">
                                <option v-for="re in relatives"  :value="re.id" >{{ re.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" name="certificate[comment]">{{cert_detail.comment}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-lg actions">Save</button>
                        <button type="button" class="btn btn-warning btn-lg actions preview_button">Preview</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
</template>
<script>
   export default {
        props: {
            report_type: {
               type     : Number,
               required : true,
            },
            report_name: {
               type     : Object,
               required : true,
            },
            patient_options: {
               type: Array,
               required: true,
            },
            relatives: {
               type: Array,
               required: true,
            },
            id: {
               type     : Array,
               required : true,
            },
            report_detail: {
               type     : Array,
               required : true,
            },
            certificate_detail: {
               type     : Array,
               required : true,
            },
        },
       data(){
           return {
                errors              : [],
                prescription        : [],
                csrftoken           : "",
                base_url            : base_url,
                report_val          : this.report_name,
                report_id           : this.report_type,
                cer_id              : this.id,
                rep_detail          : this.report_detail,
                cert_detail         : this.certificate_detail,
                
           }
       },
       mounted()
       {

        this.csrftoken = document.querySelector('meta[name="csrf-token"]').content
        this.readPrescription(this.report_type);
       },
       methods: {
             readPrescription(report_type){   
                var $this = this;
                if (typeof report_type  === 'undefined') {
                        report_type = 1;
                }
                axios.post(portal_url + '/certificate/index',{report_type : report_type}).then(function (response) {
                        $this.prescription = response.data;
                });
            },
            getAddLink(report_type) {
                location.href = portal_url+'/certificate/setup/'+report_type;
            },
       }
   }
   
</script>