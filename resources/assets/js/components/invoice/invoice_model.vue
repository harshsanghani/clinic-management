<template>
    <form method="post" id="add_notes" action="" v-on:submit.prevent="NoteCommit()">
        <div class="modal-body">
            <div class="card-header">
                <h2 class="card-title">New Invoice</h2>        
            </div>
            <div class="row">
                 
            </div>  
            <input type="hidden" name="patient_id" :value="patient_id">
            <input type="hidden" name="appointment_id" :value="appointment_id">
            <input type="hidden" name="note_id" :value="notes.id">
            <div>
                <div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Consulting Amount</label>
                                    <input type="text" class="form-control amount-mask" name="consulting_amount" dir="ltr" value=""  v-on:keyup="TotalAmount"  v-model="notes.consulting_amount">
                                    <span v-if="allErrors.consulting_amount" :class="['help-inline']">{{ allErrors.consulting_amount[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Medicine Amount</label>
                                    <input type="text" class="form-control amount-mask" name="medicine_amount" dir="ltr" v-on:keyup="TotalAmount" value="" v-model="notes.medicine_amount">
                                    <span v-if="allErrors.medicine_amount" :class="['help-inline']">{{ allErrors.medicine_amount[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Total Amount</label>
                                    <input type="text" class="form-control amount-mask total_amount" name="total_amount" dir="ltr" value="" v-model="total_amount" readonly>
                                    <span v-if="allErrors.total_amount" :class="['help-inline']">{{ allErrors.total_amount[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Payment Received</label>
                                    <input type="text" class="form-control amount-mask" name="received_amount" dir="ltr" value="" v-on:keyup="BalanceTotalAmount" v-model="notes.received_amount">
                                    <span v-if="allErrors.received_amount" :class="['help-inline']">{{ allErrors.received_amount[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Balance Amount</label>

                                    <input type="text" class="form-control balace_amount" name="balace_amount" dir="ltr"   v-model="balance_amount" value="" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select name="payment_mode" class="form-control"  v-model="(notes.payment_mode == null) ? 1 : notes.payment_mode" >
                                            <option v-for="p in payment_modes"  :value="p.id" >{{ p.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 extra_payment_box hide">
                                <div class="form-group">
                                    <label>Extra Payment Reason</label>
                                    <select name="extra_payment_reason" class="form-control" v-model="notes.extra_payment_reason" >
                                        <option value="0">Select Reason</option>
                                        <option value="1" >Previous pending payment</option>
                                        <option value="2" >Extra advance payment</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer modal-footer--bordered">
            <button type="button" class="btn btn-danger btn-lg close_note_model"  data-dismiss="modal" aria-label="close" >Dismiss</button>
            <button type="submit" class="btn btn-success btn-lg">Update</button>
        </div>
    </form>
</template>
<script>
    import { VueEditor, Quill } from "vue2-editor";
    import Datepicker from 'vuejs-datepicker'
   export default {
        components: {
            Datepicker
          },
        props: {
            notes:{},
            patient: {
               type: Array,
               required: true,
            },
            time_slots: {
               type: Array,
               required: true,
            },
            payment_modes: {
               type: Array,
               required: true,
            },
            appointment:{},

        },
        data(){
           return {
                appointment_date : ((typeof(this.appointment) != "undefined" && this.appointment  !== null) ? this.appointment['appointment_date'] :''),
                appointment_time : ((typeof(this.appointment) != "undefined" && this.appointment  !== null) ? this.appointment['appointment_time'] :''),
                appointment_id  : ((typeof(this.notes.appointment_id) != "undefined" && this.notes.appointment_id  !== null) ? this.notes.appointment_id :'0'),
                note_data       : ((typeof(this.notes.notes) != "undefined" && this.notes.notes  !== null) ? this.notes.notes :''),
                extraNotesField : {},
                patient_id      : this.patient['id'],
                base_url        : base_url,
                total_amount    : ((typeof(this.notes.consulting_amount) != "undefined" && this.notes.consulting_amount  !== null) ? parseInt(this.notes.consulting_amount) + parseInt(this.notes.medicine_amount) :'0.00'),
                balance_amount  : ((typeof(this.notes.consulting_amount) != "undefined" && this.notes.consulting_amount  !== null) ? parseInt(this.notes.consulting_amount) + parseInt(this.notes.medicine_amount) -  parseInt(this.notes.received_amount) :'0'),
                allErrors       : [],
            }
       },
       mounted()
       {
            $(".nav-link").click(function() {
                 $('.nav-link').removeClass('active');
                 var id = $(this).attr('href');
                 $(this).addClass('active');
                 $(id).addClass('active in show');
                 $(id).show();
            });
            this.BalanceTotalAmount();
       },
       methods: {
            Addnote(patient_id) {
                let currentObj  = this;
                currentObj.Load_notes(patient_id);
                
            },
            Load_notes(patient_id) {
                let currentObj  = this;
               $("#edit-note").modal('show');
            },
            NoteCommit() {
                var form_data           = document.getElementById('add_notes');
                var n_bodyFormData      = new FormData(form_data);
                n_bodyFormData.append('notes', this.note_data);
                let currentObj          = this;
                axios.post(portal_url + '/patient/add_notes',n_bodyFormData)
                .then(function (response) {
                    if(response.data.status) {
                        $("#edit-note").modal('hide');
                        showMessage('success', response.data.message);
                    } else {
                        showMessage('success', response.data.message);
                    }
                    currentObj.getAllNotesList();
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
            },
            TotalAmount() {
                let  consulting          =  this.notes.consulting_amount;
                let  medicine_amount     =  this.notes.medicine_amount;
                let total_amount         =  parseInt(consulting) + parseInt(medicine_amount);
                if (!Number.isNaN(total_amount)) {
                    $(".total_amount").val(total_amount);
                }
            },
            BalanceTotalAmount() {
                let  consulting          =  this.notes.consulting_amount;
                let  medicine_amount     =  this.notes.medicine_amount;
                let  received_amount     =  this.notes.received_amount;
                let  total               =  parseInt(consulting) + parseInt(medicine_amount) - parseInt(received_amount);
                if (!Number.isNaN(total) ) {
                    if (total > 0) {
                        $('.balace_amount').val(total+' DR');
                        $('.extra_payment_box').addClass('hide');
                    } else if (total < 0) {
                        total = total.toString().substr(1, total.length);
                        $('.balace_amount').val(total+' CR');
                        $('.extra_payment_box').removeClass('hide');
                    } else {
                        $('.balace_amount').val(total);
                        $('.extra_payment_box').addClass('hide');
                    }
                }
            },
            getAllNotesList() {
                let currentObj  = this;
                axios.post(portal_url + '/patient/get_notes/'+this.patient_id)
                .then(function (response) {
                    $(".note_container").html(response.data.html);
                })
                .catch(function (error) {
                
                });
            }
       }
   }
</script>
