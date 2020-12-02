<template>
    <div class="modal fade" id="appointment_card">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">New Appointment</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="custom-control custom-radio">
                            <input type="radio" name="type" value="1" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">New Appointment</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="type" value="2" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Follow Up</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="type" value="3" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Emergency</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Patient</label>
                        <select  name="patient_id" class="form-control patient_list">
                            <option value="">-Select Patients-</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Appointment Date (DD-MM-YYYY)</label>
                        <input type="text" name="appointment_date" class="form-control date-mask" value="">
                    </div>
                    <div class="form-group">
                        <label>Appointment Time</label>
                        <select id="appointment_time" name="appointment_time" class="form-control">
                        </select>
                    </div>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" id="sms_notification" name="sms_notification" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">SMS Notifications</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" id="email_notification"  name="email_notification" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Email Notifiaction</span>
                    </label>
                    <input type="hidden" class="new-event__start" />
                    <input type="hidden" class="new-event__end" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import 'fullcalendar/dist/fullcalendar.css';
    import FullCalendar from 'vue-full-calendar';
    Vue.use(FullCalendar);

    export default {
    data() {
        return {
            events: [
                {
                    title : 'event1',
                    start : '2019-12-28',
                },
                {
                    title : 'event1',
                    start : '2019-12-29',
                }
            ]
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        ViewCard() {
            let currentObj  = this;
            $("#appointment_card").modal('show');
            currentObj.showCardModal = true;
        }
    }
  }
</script>