<template>
    <div class="">
        <header class="content__title content__title--calendar" style="padding: 0;">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="calendar_main_title hidden-xs">MANAGE YOUR APPOINTMENTS</h4>
                </div>
                 <div class="col-md-3 text-right">
                    <div class="form-group" v-if="doctors.length > 0">
                        <select name="doctor_id" id="doctor_id" class="form-control" @change.prevent="changeDoctor($event)">
                            <option value="">-Select Doctor-</option>
                            <option v-for="d in doctors"  :value="d.id" >{{ d.full_name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 text-right">
                    <button class="btn btn-success btn-lg appointment_model" @click.prevent="ViewAppointment()" >Add Appointment</button>
                </div>
            </div>
        </header>
        <div class="calendar card">
            <full-calendar :events="events" @event-selected="dayClick" @day-click="dayClick" ref='calendar' ></full-calendar>
        </div>
        <div class="modal fade edit_event" id="edit_event">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <a href="javascript:void(0)" :value="event_id" @click.prevent="ViewAppointment(event_id)" class="btn btn-success btn-lg edit-appointment appointment_model" >Edit Appointment</a>
                        <a href="javascript:void(0)"  class="btn btn-primary btn-lg view-profile" @click.prevent="ViewPatient(event_id)">View Patient</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-lg delete-appointment" @click.prevent="DeleteAppointment(event_id)">Delete Appointment</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade model_scroll" id="appointment_card">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">New Appointment</h3>
                    </div>
                    <div class="appointment_data">
                        <form class="new-event__form" v-on:submit.prevent="appointmentCommit()" id="add_appointment" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="type" value="1"  class="custom-control-input" checked="" v-model="edit_data.type">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">New Appointment</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="type" value="2"  class="custom-control-input" v-model="edit_data.type">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Follow Up</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="type" value="3" class="custom-control-input" v-model="edit_data.type">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Emergency</span>
                                    </label>
                                    <span v-if="allErrors.type" :class="['help-inline']">{{ allErrors.type[0] }}</span>
                                </div>
                                <div class="form-group" v-if="doctors.length > 0">
                                    <label>Doctor</label>
                                    <select name="doctor_id" id="doctor_id" class="form-control" v-model="edit_data.doctor_id">
                                        <option value="">-Select Doctor-</option>
                                        <option v-for="d in doctors"  :value="d.id" >{{ d.full_name }}</option>
                                    </select>
                                    <span v-if="allErrors.patient_id" :class="['help-inline']">{{ allErrors.patient_id[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Patient</label>
                                    <select name="patient_id" id="patient_id" class="form-control" v-model="edit_data.patient_id">
                                        <option value="">-Select-</option>
                                        <option v-for="pi in patients"  :value="pi.id" >{{ pi.firstname }}  {{ pi.lastname }} </option>
                                    </select>
                                    <span v-if="allErrors.patient_id" :class="['help-inline']">{{ allErrors.patient_id[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Appointment Date (DD-MM-YYYY)</label>
                                     <datepicker name="appointment_date"  :value="edit_data.appointment_date" format="MM/dd/yyyy" input-class="form-control" ></datepicker>
                                     <span v-if="allErrors.appointment_date" :class="['help-inline']">{{ allErrors.appointment_date[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Appointment Time</label>
                                    <select id="appointment_time" name="appointment_time" class="form-control" v-model="edit_data.appointment_time">
                                        <option v-for="ts in time_slots" >{{ ts }}</option>
                                    </select>
                                    <span v-if="allErrors.appointment_time" :class="['help-inline']">{{ allErrors.appointment_time[0] }}</span>
                                </div>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sms_notification" name="sms_notification" class="custom-control-input" v-model="edit_data.sms_notification">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">SMS Notifications</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" id="email_notification"  name="email_notification" class="custom-control-input" v-model="edit_data.email_notification">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Email Notifiaction</span>
                                </label>
                                <span v-if="allErrors.email_notification" :class="['help-inline']">{{ allErrors.email_notification[0] }}</span>
                                <input type="hidden" name="id" v-model="edit_data.id"/>
                                <input type="hidden" class="new-event__start" />
                                <input type="hidden" class="new-event__end" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-lg new-event__add">Add Appointment</button>
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
    import 'fullcalendar/dist/fullcalendar.css';
    import FullCalendar from 'vue-full-calendar';
    Vue.use(FullCalendar);
    import Datepicker from 'vuejs-datepicker';
    export default {
        components: {
            Datepicker
        },
        props: {
            patients: {
               type     : Array,
               required : true,
            },
            appointments: {
               type     : Array,
               required : true,
            },
            time_slots: {
               type     : Array,
               required : true,
            },
            doctors: {
               type     : Array,
               required : true,
            },
        },
        data() {
            return {
                appointmentFields   : {},
                appointment_date    : "",
                event_id            : 0,
                events              : {},
                edit_data           : {},
                allErrors           : [],
            }
        },
    mounted() {
        let currentObj      = this;
        currentObj.get_events()
    },
    methods: {
        get_events(doctor_id = 0) {
            let currentObj      = this;
            axios.get(portal_url + '/home/get_appointment/'+doctor_id)
                .then(function (response) {
                    currentObj.events = response.data.appointments;
                })
                .catch(function (error) {

                });
                
        },
        RefreshEvent() {
            let currentObj      = this;
            currentObj.get_events();
            currentObj.$refs.calendar.$emit('refetchEvents')
        },
        loadAppointment(appointment_id = "") {
            let currentObj  = this;
            $("#edit_event").modal('hide');
            currentObj.ViewAppointment(appointment_id);
        },
        dayClick(date, jsEvent,event, view) {
            let currentObj  = this;
            var start_date  = moment(date._d).toISOString();
            var todaydate   = moment(start_date).format("DD-MM-YYYY");
            this.appointment_date = todaydate;
            if (typeof date.id !== 'undefined') {
                this.event_id = date.id;
                $("#edit_event").modal('show');
            } else {
                currentObj.loadAppointment();
            }
        },
        ViewAppointment(appointment_id) {
            let currentObj  = this;
            axios.post(portal_url + '/home/add_appoiment_model/'+appointment_id)
            .then(function (response) {
                currentObj.edit_data = response.data.appointment_data;
                 console.log(appointment_id);
                if (typeof appointment_id !== 'undefined') {
                    $("#edit_event").modal('hide');
                }
                $("#appointment_card").modal('show');
                
            })
            .catch(function (error) {

            });
        },
        DeleteAppointment(appointment_id) {
            if (appointment_id !="") {
                let currentObj      = this;
                if(confirm('Are you sure you want to delete ?')) {
                    var appointment_id  = window.btoa(appointment_id);
                    axios.post(portal_url + '/home/delete_appointment/'+appointment_id)
                    .then(function (response) {
                        $("#edit_event").modal('hide');
                        showMessage('success', response.data.message);
                        currentObj.get_events();
                    })
                    .catch(function (error) {

                    });
                } else {
                    return false;
                }
            }
        },
        appointmentCommit() {
            let currentObj      = this;
            var form_data       = document.getElementById('add_appointment');
            var p_data          = new FormData(form_data);
            axios.post(portal_url + '/home/add_appointment',p_data,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }})
            .then(function (response) {
                if(response.data.status) {
                    $("#appointment_card").modal('hide');
                    currentObj.RefreshEvent();
                    showMessage('success', response.data.message);
                }
            })
            .catch(function (error) {
                currentObj.allErrors    = error.response.data;
            });
        },
        changeDoctor(event) {
            let currentObj  = this;
            var doctor_id   = event.target.value;
            if(doctor_id !="") {
                currentObj.get_events(doctor_id);
            } else {
                currentObj.get_events();
            }
        },
        ViewPatient(appointment_id) {
            let currentObj  = this;
            axios.post(portal_url + '/home/add_appoiment_model/'+appointment_id)
            .then(function (response) {
                var patient_id = response.data.appointment_data.patient_id;
                window.location.href = portal_url + '/patient/view/'+patient_id;
            })
            .catch(function (error) {

            });
        }
    }
  }
</script>