<template>
    <form :action="base_url + 'portal/certificate/commit/'+report_id" method="post" class="request_investigation">
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Dignosis</label>
                            <input type="text" class="form-control" v-model="cert_detail.dignosis" name="certificate[dignosis]" value="" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Brief Medical History</label>
                            <textarea class="form-control" name="certificate[medical_history]">{{cert_detail.medical_history}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name of Laboratory/ Physician</label>
                            <input type="text" class="form-control" name="certificate[lab_name]" value="" v-model="cert_detail.lab_name" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Investigation Type</label>
                            <select class="form-control patient_list investigation_type" name="certificate[investigation_type]" v-model="cert_detail.investigation_type">
                                <option value="">Select Investigation type</option>
                                    <option v-for="iv in investigations"  :value="iv.name" >{{iv.name}}</option>
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
            investigations: {
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