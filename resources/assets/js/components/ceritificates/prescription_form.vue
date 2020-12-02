<template>
    <form :action="base_url + 'portal/certificate/commit/'+report_id" method="post" class="prescription_form">
        <input type="hidden" :value="csrftoken" name="_token"/>
        <input type="hidden" :value="cer_id" name="cer_id"/>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Prescription</h2>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date (DD-MM-YYYY)</label>
                            <input type="date" class="form-control date-mask" v-model="rep_detail.date" name="date" placeholder="Enter date" value="">
                            <span v-if="allErrors.prescription_date" :class="['help-inline']">{{ allErrors.prescription_date[0] }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Patient</label>
                            <select class="form-control patient_list" name="patient" v-model="rep_detail.patient_id" id="patient_name" >
                                <option value="">-- Select patient --</option>
                                <option v-for="pt in patient_options"  :value="pt.id" >{{ pt.firstname }} {{ pt.lastname }}</option>
                            </select>
                            <span v-if="allErrors.patient_name" :class="['help-inline']">{{ allErrors.patient_name[0] }}</span>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="card-header">
                <h2 class="card-title">Prescription Detail</h2>
            </div>
            <div class="card-block">
                <div class="prescription_report" v-if="typeof(cert_detail['prescription']) !== 'undefined'">
                    <div class="row prescription_list" v-for="(row, key) in cert_detail['prescription']">
                        <div class="col-md-1">
                            <label v-if="key == 0">Sr. no.</label>
                            <p><label>{{key+1}}</label></p>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label v-if="key == 0">Medicine</label>
                            <select class="form-control error" v-model="row.medicine" :name="'certificate[prescription]['+key+'][medicine]'">
                                <option value="">Select medicine</option>
                                <option v-for="md in medicine_options"  :value="md.name" >{{ md.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label v-if="key == 0">Potency</label>
                            <select v-model="row.potency" :name="'certificate[prescription]['+key+'][potency]'" class="form-control error">
                                <option value="">Select potency</option>
                                <option v-for="pt in potency_options"  :value="pt.name" >{{ pt.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label v-if="key == 0">Dosage</label>
                            <select v-model="row.dosage" :name="'certificate[prescription]['+key+'][dosage]'" class="form-control error">
                                <option value="">Select dosage</option>
                                <option v-for="pt in dosage_options"  :value="pt.name" >{{ pt.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label v-if="key == 0">Repetition</label>
                            <select v-model="row.repetition" :name="'certificate[prescription]['+key+'][repetition]'" class="form-control error">
                                <option value="">Select repetition</option>
                                <option v-for="rp in repetition_options"  :value="rp.name" >{{ rp.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label v-if="key == 0">No. of days</label>
                            <input type="text" v-model="row.no_days" :name="'certificate[prescription]['+key+'][no_days]'" class="form-control error day-mask" value="">
                        </div>
                        <div class="col-md-1 col-xs-6">
                            <label v-if="key == 0"></label>
                            <a v-if="key == 0" href="javascript:void(0)" class="btn btn-primary btn-lg add_detail"><i class="zmdi zmdi-plus-circle-o"></i></a>
                            <a v-else href="javascript:void(0)" class="btn btn-danger btn-lg remove_detail" ><i class="zmdi zmdi-minus-circle-outline"></i></a>
                        </div>
                    </div>
                </div>
                <div class="prescription_report" v-if="typeof(cert_detail['prescription']) == 'undefined'">
                    <div class="row prescription_list">
                        <div class="col-md-1">
                            <label>Sr. no.</label>
                            <p><label>1</label></p>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label>Medicine</label>
                            <select class="form-control error" name="certificate[prescription][0][medicine]">
                                <option value="">Select medicine</option>
                                <option v-for="md in medicine_options"  :value="md.name" >{{ md.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label>Potency</label>
                            <select name="certificate[prescription][0][potency]" class="form-control error">
                                <option value="">Select potency</option>
                                <option v-for="pt in potency_options"  :value="pt.name" >{{ pt.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label>Dosage</label>
                            <select name="certificate[prescription][0][dosage]" class="form-control error">
                                <option value="">Select dosage</option>
                                <option v-for="pt in dosage_options"  :value="pt.name" >{{ pt.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label>Repetition</label>
                            <select name="certificate[prescription][0][repetition]" class="form-control error">
                                <option value="">Select repetition</option>
                                <option v-for="rp in repetition_options"  :value="rp.name" >{{ rp.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label>No. of days</label>
                            <input type="text" name="certificate[prescription][0][no_days]" class="form-control error day-mask" value="">
                        </div>
                        <div class="col-md-1 col-xs-6">
                            <label></label>
                            <a href="javascript:void(0)" class="btn btn-primary btn-lg add_detail"><i class="zmdi zmdi-plus-circle-o"></i></a>
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
    axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
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
            medicine_options: {
               type: Array,
               required: true,
            },
            potency_options: {
               type: Array,
               required: true,
            },
            dosage_options: {
               type: Array,
               required: true,
            },
            repetition_options: {
               type: Array,
               required: true,
            },
            id: {
               type     : Number,
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
                prescriptionFields  : ((typeof(this.prescription) != "undefined" && this.prescription  !== null) ? this.prescription : {}),
                errors              : [],
                allErrors           : [],
                csrftoken           : "",
                report_val          : this.report_name,
                report_id           : this.report_type,
                base_url            : base_url,
                cer_id              : this.id,
                rep_detail          : this.report_detail,
                cert_detail         : this.certificate_detail,
           }
       },
       mounted()
       {
            this.csrftoken = document.querySelector('meta[name="csrf-token"]').content
            let currentObj      = this;
            $(document).on('click','.add_detail',function(){
                currentObj.add_prescription();
            });
            $(document).on('click','.remove_detail',function(e){
                e.preventDefault();
                $(this).parents('.prescription_list').remove();
            });
            $(document).on('keypress','.day-mask',function(e){
                if ( e.which < 48 || e.which > 57) {
                    return false;
                } else {
                    return true;
                }
            });
       },
       methods: {
            prescriptionCommit() {
                let currentObj      = this;
                var form_data       = document.getElementById('prescription_detail');
                var p_data          = new FormData(form_data);
                axios.post(portal_url + '/prescription/prescription_commit',p_data,{
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
            add_prescription() {
                var medicine        = this.medicine_options;
                var potency         = this.potency_options;
                var dosage          = this.dosage_options;
                var repetitions     = this.repetition_options;
                
                var count       = $('.prescription_list').length;
                var row_html    = "";

                row_html += '<div class="row prescription_list">';
                row_html += '<div class="col-md-1"><p><label>'+(count+1)+'</label></p></div>';
                row_html += '<div class="col-md-2 col-xs-6"><select name="certificate[prescription]['+count+'][medicine]" class="form-control"><option value="">-Select Medicine-</option>'
                            $.each( medicine, function( key, value ) {
                                row_html += '<option value="'+this.name+'">'+this.name+'</option>' 
                            });
                row_html += '</select></div>';
                row_html += '<div class="col-md-2 col-xs-6"><select name="certificate[prescription]['+count+'][potency]" class="form-control"><option value="">-Select Potency-</option>'
                            $.each( potency, function( key, value ) {
                                row_html += '<option value="'+this.name+'">'+this.name+'</option>' 
                            });
                row_html += '</select></div>';
                row_html += '<div class="col-md-2 col-xs-6"><select type="text" name="certificate[prescription]['+count+'][dosage]" class="form-control"><option value="">-Select Dosage-</option>'
                            $.each( dosage, function( key, value ) {
                                row_html += '<option value="'+this.name+'">'+this.name+'</option>' 
                            });
                row_html +='</select></div>';
                row_html += '<div class="col-md-2 col-xs-6"><select name="certificate[prescription]['+count+'][repetition]" class="form-control"><option value="">-Select Repetition-</option>'
                            $.each( repetitions, function( key, value ) {
                                row_html += '<option value="'+this.name+'">'+this.name+'</option>' 
                            });
                row_html += '</select></div>';
                row_html += '<div class="col-md-2 col-xs-6"><input type="text" placeholder="No. of days" name="certificate[prescription]['+count+'][no_days]" class="form-control day-mask"></div>';
                row_html += '<div class="col-md-1 col-xs-6"><a href="javascript:void(0)" class="btn btn-danger btn-lg remove_detail" ><i class="zmdi zmdi-minus-circle-outline"></i></a></div>'
                row_html += '</div>';
                $('.prescription_report').append(row_html);
            }
            
       }
   }
    
    
</script>