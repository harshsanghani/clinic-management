<template>
    <div>
        <div class="card profile">
            <div class="profile__img">
                <img v-if="image_path != '' "  v-bind:src="base_url + image_path"   >
                <img v-else v-bind:src="base_url + 'assets/portal-side/img/avatar.png'">
                <div class="file_box">
                    <div class="file_box_title">20</div>
                    <p>File Number</p>
                </div>
            </div>
            <div class="profile__info">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="icon-list">
                            <li><i class="zmdi zmdi-account"></i><span>Name: </span> {{ this.patient["title"] }} {{ this.patient["firstname"] }} {{ this.patient["middlename"] }} {{ this.patient["lastname"] }}</li>
                            <li><i class="zmdi zmdi-phone"></i><span>Phone: </span> {{ this.patient["phone"] }} </li>
                            <li><i class="zmdi zmdi-email"></i><span>Email: </span> {{ this.patient["email"] }} </li>
                            <li><i class="zmdi zmdi-calendar-alt"></i><span>Birthdate: </span> {{ this.patient["birthdate"] }} </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="icon-list">
                            <li><i class="zmdi zmdi-eye"></i><span>Age: </span> {{ this.patient["age"] }} </li>
                            <li v-if="this.patient['blood_info']" ><i class="zmdi zmdi-coffee"></i><span>Blood Group: </span> {{ this.patient["blood_info"].name }} </li>
                            <li v-if="this.patient['address_info']" ><i class="zmdi zmdi-home"></i><span>City: </span> {{ this.patient["address_info"].city }} </li>
                            <li v-if="this.patient['address_info']" ><i class="zmdi zmdi-globe"></i><span>Address: </span> {{ this.patient["address_info"].address }} </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="profile_bottom">
                    <button @click="setupUrl(patient_id)" class="btn btn-outline-primary waves-effect">Edit Profile</button>
                    <a href="" class="btn btn-success waves-effect"  data-patient=""  @click.prevent="Addnote(patient_id)" >Add Notes</a>
                    <button  class="btn btn-info waves-effect "  @click="setupReportUrl(patient_id)">View Reports</button>
                    <a :href="base_url + 'portal/patient/invoice/'+patient_id" class="btn btn-info waves-effect">Invoice</a>

                    <a href="" class="btn btn-info waves-effect view-card-11" @click.prevent="ViewCard(patient_id)"  >Patient Card</a>
                    <a href="" class="btn btn-info waves-effect note-extra" data-id="" data-ma-action="aside-open" data-ma-target=".chat">Extra notes</a>
                    <a href="" data-href="" data-id="" @click.prevent="removepatient(patient_id)" class="btn btn-danger waves-effect float-right remove_patient" title="Delete Patient"><i class="zmdi zmdi-delete"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="color-demo blue">
                    <div class="color-demo__color">
                        <h5>Total Appointments : </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="color-demo orage">
                    <div class="color-demo__color">
                        <h5>Next Appointment :</h5>
                    </div>
                </div>
            </div>
        </div>
        <aside class="chat">
            <div class="chat__header">
                <h2 class="chat__title">Extra Notes</h2>
            </div>
            <div class="listview listview--hover chat__buddies scrollbar-inner">
                <div class="messages__body">
                    <div class="messages__content">
                        <div class="extra_notes"></div>
                        <div class="messages__reply">
                            <form  v-on:submit.prevent="ExtraNotesCommit()" id="extra_notes_frm">
                                <input type="hidden" name="patient_id" :value="patient_id">
                                <textarea class="messages__reply__text" rows="4" name="message" value="" v-model="extraNotesField.message" placeholder="Write extra note..."></textarea>
                                <button type="submit" class="btn btn-success">
                                    Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="modal fade card-view" id="patient_card">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Patient Card</h3>
                    </div>
                    <div class="modal-body">
                         <view_card_modal v-if="showCardModal" @close="showCardModal = false"  :patient="patient" >
                        </view_card_modal>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="patient_remove">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h4>Are you sure?</h4> 
                        <hr>
                        <a href="javascript:void(0)" class="btn btn-danger btn-lg" data-dismiss="modal">No</a>
                        <a href="javascript:void(0)" class="btn btn-success btn-lg patients_removes">Yes, Delete it</a> 
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade note-view" id="edit-note">
            <div class="modal-dialog modal-lg">
                <div class="modal-content edit-note">
                    
                </div>
            </div>
        </div>  
        
    </div>
</template>
<script>
   import { VueEditor, Quill } from "vue2-editor";
   export default {
        props: {
            patient: {
               type: Object,
               required: true,
            },

        },
        data(){
           return {
                showCardModal  :false,
                same_address:0,
                extraNotesField   : {},
                patient_id:this.patient['id'],
                appointment_id:this.appointment_id,
                address_id:'',
                default_image: '',
                base_url        : base_url,
                image_path      : ((typeof(this.patient.image_info) != "undefined" && this.patient.image_info  !== null) ? this.patient.image_info.path : ''),
           }
       },
       mounted()
       {    
            this.getExtraNotes(this.patient_id);
            let currentObj      = this;
            $(document).on('click','.remove-extra-notes',function(e)  {
                e.preventDefault();
                if(confirm('Are you sure you want to delete ?')) {
                    var note_id      = $(this).attr('data-id');
                    var patient_id   = $(this).attr('data-patient');
                    currentObj.DeleteExtraNotes(note_id);
                }
            })
       },
       methods: {
            setupUrl(patient) {
                 location.href = portal_url+'/patient/setup/'+patient;
            },
            removepatient:function(patient_id) {
                $('#patient_remove').modal('show');
                $('.patients_removes').attr('href', portal_url+'/patient/delete_patient/'+patient_id);
                return false;
            },
            setupReportUrl(patient) {
                 location.href = portal_url+'/patient/report/'+patient;
            },
            ExtraNotesCommit() {
                var form_data           = document.getElementById('extra_notes_frm');
                var n_bodyFormData      = new FormData(form_data);
                let currentObj          = this;
                axios.post(portal_url + '/patient/add_extra_notes', n_bodyFormData)
                .then(function (response) {
                    if(response.data.status) {
                        $('.messages__reply__text').val('');
                        currentObj.getExtraNotes(response.data.patient_id);
                    } else {
                        showMessage('danger', response.data.message);
                    }
                })
                .catch(function (error) {

                });
            },
            getExtraNotes(patient_id) {
                let currentObj  = this;
                axios.post(portal_url + '/patient/get_extra_notes/'+patient_id)
                .then(function (response) {
                    if(response.data.status) {
                        $('.extra_notes').html(response.data.html);
                            $(".scrollbar-inner")[0] && $(".scrollbar-inner").scrollbar().scrollLock();
                            var scroll_height = $('.listview ')[0].scrollHeight + 200;
                            $(".listview ").animate({ scrollTop:  scroll_height}, 1000);
                    }
                })
                .catch(function (error) {

                });
            },
            DeleteExtraNotes(note_id) {
                let currentObj  = this;
                axios.post(portal_url + '/patient/delete_extra_notes/'+note_id)
                .then(function (response) {
                    showMessage('success', response.data.message);
                    if(response.data.status) {
                         $(".extra_notes_"+note_id).parents('.messages__item').remove().fadeOut("normal");
                    }
                })
                .catch(function (error) {

                });
            },
            ViewCard() {
                let currentObj  = this;
                $("#patient_card").modal('show');
                currentObj.showCardModal = true;
            },
            Addnote(patient_id) {
                let currentObj  = this;
                axios.post(portal_url + '/patient/note_model/'+patient_id)
                .then(function (response) {
                    $(".edit-note").html(response.data.html);
                })
                .catch(function (error) {

                });
                currentObj.Load_notes(patient_id);
                
            },
            Load_notes(patient_id) {
                let currentObj  = this;
               $("#edit-note").modal('show');
            },
            
       }
   }
</script>
