
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Invoice
Vue.component('invoice', require('./components/invoice/invoice.vue'));
Vue.component('invoice_model', require('./components/invoice/invoice_model.vue'));

Vue.component('example', require('./components/Example.vue'));
Vue.component('patient', require('./components/patient/patientIndex.vue'));
Vue.component('certificate', require('./components/ceritificates/certificateIndex.vue'));
Vue.component('patient_bill', require('./components/ceritificates/patient_bill_form.vue'));
Vue.component('receipt', require('./components/ceritificates/receipt_form.vue'));
Vue.component('abroad_certificate', require('./components/ceritificates/abroad_certificate.vue'));
Vue.component('fitness_certificate', require('./components/ceritificates/fitness_certificate.vue'));
Vue.component('sickness_certificate', require('./components/ceritificates/sickness_certificate.vue'));
Vue.component('patients_report', require('./components/ceritificates/patient_report.vue'));
Vue.component('reference_latter', require('./components/ceritificates/reference_latter.vue'));
Vue.component('customized', require('./components/ceritificates/customized_form.vue'));
Vue.component('request_investigation', require('./components/ceritificates/request_investigation.vue'));
Vue.component('tools', require('./components/tools/toolsIndex.vue'));
Vue.component('investigation', require('./components/investigation/investigationIndex.vue'));
Vue.component('prescription_form', require('./components/ceritificates/prescription_form.vue'));
Vue.component('patient_setup', require('./components/patient/patient_setup.vue'));
Vue.component('patient_view', require('./components/patient/patient_view.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('searchbox', require('./components/patient/search.vue'));
Vue.component('patient_report', require('./components/patient/patientReport.vue'));
Vue.component('patient_invoice', require('./components/patient/patient_invoice.vue'));
Vue.component('view_card_modal', require('./components/patient/view_card_model.vue'));
//home
Vue.component('calendar', require('./components/home/calendar.vue'));
//Vue.component('appointment_model', require('./components/home/appointment_model.vue'));
Vue.component('note_model', require('./components/patient/note_model.vue'));
Vue.component('patient_notes', require('./components/patient/patient_notes.vue'));
Vue.component('note_view', require('./components/patient/note_view.vue'));
//Vue.component('view_card_modal', require('./components/patient/view_card2.vue'));

//master
Vue.component('master_form', require('./components/master/master_form.vue'));
Vue.component('master_index', require('./components/master/master_index.vue'));

//receptionist
Vue.component('receptionist_form', require('./components/receptionist/receptionist_form.vue'));
Vue.component('receptionist_index', require('./components/receptionist/receptionist_index.vue'));

//doctor
Vue.component('doctor_form', require('./components/doctor/doctor_form.vue'));
Vue.component('doctor_index', require('./components/doctor/doctor_index.vue'));

const app = new Vue({
   el: '#app'
});
