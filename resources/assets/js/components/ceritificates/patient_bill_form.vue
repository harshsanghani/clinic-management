<template>
    <form :action="base_url + 'portal/certificate/commit/'+report_id" method="post" class="paitient_bill_form">
        <input type="hidden" :value="csrftoken" name="_token"/>
        <input type="hidden" :value="cer_id" name="cer_id"/>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">{{report_val.name}}</h2>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Bill No</label>
                            <input type="text" class="form-control" name="certificate[bill_no]" v-model="cert_detail.bill_no" value="">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Patient</label>
                            <select class="form-control patient_list" name="patient" v-model="rep_detail.patient_id">
                                <option value="">-All-</option>
                                <option v-for="pt in patient_options"  :value="pt.id" >{{ pt.firstname }} {{ pt.lastname }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Date (DD-MM-YYYY)</label>
                            <input type="date" v-model="rep_detail.date" class="form-control date-mask" name="date" placeholder="Select date" value="">
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
            </div>
            <div class="card-header"><h2 class="card-title">Fees Detail</h2></div>
            <div class="card-block">
                 <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Consultation Charges</label>
                            <input type="text" v-model="cert_detail.consultation_charges" class="form-control amount-mask consultation_charges" name="certificate[consultation_charges]" value="" >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Medicine Charges</label>
                            <input type="text" v-model="cert_detail.medicine_charges" class="form-control amount-mask medicine_charges" name="certificate[medicine_charges]" value="" >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Days</label>
                            <input type="text" v-model="cert_detail.medicine_charges_days" class="form-control day-mask" name="certificate[medicine_charges_days]" value="" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Balance Payable</label>
                            <input type="text" class="form-control balance_payable" value="" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header"><h2 class="card-title">Period of Treatment</h2></div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start Date (DD-MM-YYYY)</label>
                            <input type="text" v-model="cert_detail.treatment_start_date" class="form-control date-mask" name="certificate[treatment_start_date]" value="" placeholder="Select date">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>End Date (DD-MM-YYYY)</label>
                            <input type="text" v-model="cert_detail.treatment_end_date" class="form-control date-mask" name="certificate[treatment_end_date]" value="" placeholder="Select date" >
                        </div>
                    </div>
                </div>
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
            id: {
               type     : Number,
               required : true,
            },
            report_detail: {
               type     : Object,
               required : true,
            },
            certificate_detail: {
               type     : Object,
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
        calculation_charge();
        $(document).on('change','.consultation_charges',function(){
            calculation_charge();
        });
        $(document).on('change','.medicine_charges',function(){
            calculation_charge();
        });
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
            prescriptionsetupUrl(prescription_id) {
                 location.href = portal_url+'/prescription/setup/'+prescription_id;
            },
            removeprescription:function(prescription_id) {
                $('#prescription_remove').modal('show');
                $('.prescription_removes').attr('href', portal_url+'/prescription/delete_prescription/'+prescription_id);
                return false;
            }
       }
   }
    function calculation_charge() {
        var con_charge  = parseFloat($('.consultation_charges').val());
        var med_charge  = parseFloat($('.medicine_charges').val());
        
        var con_ch      = (isNaN(con_charge) ? 0 : con_charge);
        var med_ch      = (isNaN(med_charge) ? 0 : med_charge);
        
        var total       = (con_ch + med_ch);

        $('.balance_payable').val(total);
    }
   
</script>