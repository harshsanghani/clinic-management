<template>
     <div class="">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Invoice Report</h2>        
                <div class="actions">
                    <button class="btn btn-primary btn--icon-text waves-effect search_btn">
                        <i class="zmdi zmdi-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="card-block">
                <form method="get" class="invoice_filter" id="invoice_filter" v-on:submit.prevent="filterCommit()">
                    <div class="filter_block" style="display: none;">
                        <div class="row" v-if="user.type == 0">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <datepicker name="doctor_from_date"  format="MM/dd/yyyy" input-class="form-control doctor_from_date" ></datepicker>
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <datepicker name="doctor_to_date"  format="MM/dd/yyyy" input-class="form-control doctor_to_date" ></datepicker>
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Patient</label>
                                    <select class="form-control patient_list doctor_patient_id" name="doctor_patient_id">
                                        <option value="">-All-</option>
                                        <option v-for="p in patients"  :value="p.id" >{{ p.firstname }} {{  p.middlename }} {{   p.lastname}}</option>
                                    </select>
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div class="col-sm-1 col-6">
                                <div class="form-group">
                                    <button type="submit" class="btn-success btn mt-5 filter btn-lg">Search</button>
                                    <i class="form-group__bar"></i>
                                </div>   
                            </div>
                            <div class="col-sm-2 col-6 text-center">
                                <div class="form-group">
                                    <button type="button" class="btn-danger btn mt-5 reset btn-lg" v-on:click.prevent="filterClear()">Reset</button>
                                    <i class="form-group__bar"></i>
                                </div>   
                            </div>
                        </div>
                        <div v-else-if="user.type == 2">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <datepicker name="admin_from_date"  format="MM/dd/yyyy" input-class="form-control admin_from_date" ></datepicker>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <datepicker name="admin_to_date"  format="MM/dd/yyyy" input-class="form-control admin_to_date" ></datepicker>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="form-control doctor_list admin_doctor_id" name="admin_doctor_id">
                                            <option value="">-All-</option>
                                            <option v-for="d in doctors"  :value="d.id" >{{ d.full_name }} </option>
                                        </select>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <select class="form-control patient_list admin_patient_id" name="admin_patient_id">
                                            <option value="">-All-</option>
                                             <option v-for="p in patients"  :value="p.id" >{{ p.firstname }} {{  p.middlename }} {{   p.lastname}}</option>
                                        </select>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="form-group btn-box">
                                    <button type="submit" class="btn-success btn filter btn-lg">Search</button>
                                    <button type="button" class="btn-danger btn reset btn-lg"  v-on:click.prevent="filterClear()">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row custom_invoice_amount_boxes">
                    <div class="col-sm-4">
                        <div class="quick-stats__item bg-light-blue">
                            <div class="quick-stats__info">
                                <small>Total Amount</small>
                                <h2 class="total_amount">{{totalAmount}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="quick-stats__item bg-amber">
                            <div class="quick-stats__info">
                                <small>Received Amount</small> 
                                <h2 class="received_amount">{{receivedAmount}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="quick-stats__item bg-purple">
                            <div class="quick-stats__info">
                                <small>Pending Amount</small>
                                <h2 class="pending_amount">{{pendingAmount}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="javascript:void(0)" class="btn btn-primary pull-right add_invoice" @click.prevent="add_invoice()">Add Invoice</a>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <v-server-table  ref="table" columnsClasses="table table-bordered invoice_table"
                        :columns="columns"
                        :options="options">
                        <div slot="action" slot-scope="{ row }">
                            <button type="button" data-toggle="dropdown" class="btn btn-warning waves-effect" aria-expanded="false">Actions <b class="caret"></b></button>
                            <div class="dropdown-menu invoice_action">
                                <a class="dropdown-item" :href=" view_invoice_url+row.id"  target="_blank">View PDF</a>
                                <a class="dropdown-item send_email" :href=" view_invoice_url+row.id"  @click.prevent="email_invoice_model(row.id,row.email)">Send Email</a>
                            </div>  
                        </div>
                    </v-server-table>
                </div>
                <div class="modal fade" id="email_invoice">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <p><h3>Your invoice will be sent to below Email</h3></p>
                                <p><h4><label class="patient_email"></label></h4></p>
                                <a class="btn btn-success btn-lg send-email invoice_email" href="">Send Email</a>                
                                <a href="javascript:void(0)" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</a>
                            </div>
                        </div>
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
import { ServerTable ,Event} from 'vue-tables-2';
import Datepicker from 'vuejs-datepicker'
Vue.use(ServerTable);
    export default {
        components: {
            Datepicker
        },
        props: {
            user: {
               type: Object,
               required: true,
            },
            patients: {
               type: Array,
               required: true,
            },
            doctors: {
               type: Array,
               required: true,
            },
        },
        data() {
            user                    : this.user;
            let currentObj2         = this;
            return {
                totalAmount         : 0,
                receivedAmount      : 0,
                pendingAmount       : 0,
                report_url          : portal_url+'/invoice/list',
                view_invoice_url    : portal_url+'/patient/invoice_report/',
                columns: ['file_number', 'firstname', 'consulting_amount','medicine_amount','received_amount','amount','appointment_date','action'],
                options: currentObj2.get_option(),
            }
        },
        methods: {
            email_invoice_model(invoice_id,email){
                $('#email_invoice').modal('show');
                $('.invoice_email').attr('invoice_id',invoice_id);
                $('.patient_email').html(email);
                return false;
            },
            email_invoice(invoice_id){
                if (invoice_id != "") {
                    let currentObj  = this;
                    axios.post(currentObj. view_invoice_url+invoice_id)
                    .then(function (response) {
                        if(response.data.status) {
                            showMessage('success', response.data.message);
                        } else {
                            showMessage('danger', response.data.message);
                        }
                        $('#email_invoice').modal('hide');
                    })
                    .catch(function (error) {

                    });
                }
            },
            getData(data) {
                let currentObj2      = this;
                return axios.get(currentObj2.report_url, { params: data }).catch(function (e) {
                    currentObj.dispatch('error', e);
                }.bind(this));
            },
            filterCommit1() {
                let currentObj          = this;
                var g_form_data         = document.getElementById('invoice_filter');
                var g_data              = new FormData(g_form_data);
                axios.post(currentObj.report_url, g_data )
                .then(function (response) {
                    currentObj.get_option(response);
                })
                .catch(function (error) {
                });
            },
            filterCommit() {
                let  currentObj             = this;
                var  doctor_from_date       = $('.doctor_from_date').val();
                var  doctor_to_date         = $('.doctor_to_date').val();
                var  doctor_patient_id      = $('.doctor_patient_id').val();
                var  doctor_id              = $('.doctor_id').val();
                var  admin_doctor_id        = $('.admin_doctor_id').val();
                var  admin_from_date        = $('.admin_from_date').val();
                var  admin_to_date          = $('.admin_to_date').val();
                var  admin_patient_id       = $('.admin_patient_id').val();
                var  admin_doctor_id        = $('.admin_doctor_id').val();
                var  data                   = JSON.stringify({doctor_from_date : doctor_from_date, doctor_to_date : doctor_to_date , doctor_patient_id : doctor_patient_id, admin_from_date : admin_from_date, admin_to_date : admin_to_date, admin_patient_id : admin_patient_id, admin_doctor_id : admin_doctor_id});
                var encodedString           = window.btoa(data);
                Event.$emit('vue-tables.filter::custom_filter',encodedString);
            },
            filterClear() {
                $('.doctor_from_date').val('');
                $('.doctor_to_date').val('');
                $('.doctor_patient_id').val('');
                $('.doctor_id').val('');
                $('.admin_doctor_id').val('');
                $('.admin_from_date').val('');
                $('.admin_to_date').val('');
                $('.admin_patient_id').val('');
                $('.admin_doctor_id').val('');
                Event.$emit('vue-tables.filter::custom_filter','');
            },
            get_option() {  
                let currentObj2             = this;
                var data =  {
                    headings: {
                        file_number             : 'File',
                        firstname               : 'Name',
                        consulting_amount       : 'Consulting Charges',
                        medicine_amount         : 'Medicine Charges',
                        received_amount         : 'Received',
                        amount                  : 'Balance',
                        appointment_date        : 'Appointment',
                        action                  : 'Action',
                    },
                    perPage: 10,
                    perPageValues: [5,10,20,30,50,100], 
                    sortable: ['file_number','appointment_date', 'medicine_amount','firstname','received_amount','consulting_amount','amount'],
                    filterable: ['appointment_id'],
                    customFilters: ['custom_filter'],
                    requestFunction: function (data) {
                        let currentObj          = this;
                        var response_data       = currentObj2.getData(data);
                        return response_data;
                    },
                    responseAdapter: function(resp) {
                        currentObj2.totalAmount    = resp.data.final_total_data.total_amount;
                        currentObj2.receivedAmount = resp.data.final_total_data.total_received_amount;
                        currentObj2.pendingAmount  = resp.data.final_total_data.total_pending_amount;
                        return {
                            data: resp.data.data,
                            count: resp.data.total,
                        }
                    },
                    toggleFilter: function(filterName, $event) {
                        this.$refs.serverTableRef.setPage(1);
                        setTimeout(function () {
                            let searchItem = '';
                            if (typeof $event === 'string') { searchItem = $event; } else { searchItem = $event.target.value; }
                            let table = this.$refs.serverTableRef;
                            table.customQueries[filterName] = searchItem;
                            table.getData();
                        }.bind(this), 1000);
                    }
                }
                return data;
            },
            add_invoice() {
                let currentObj  = this;
                let patient_id  = 0;
                axios.post(portal_url + '/invoice/invoice_model')
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
        },
        mounted() {
            let currentObj      = this;
            $(document).on('click','.invoice_email',function(e)  {
                e.preventDefault();
                var invoice_id = $(this).attr('invoice_id');
                currentObj.email_invoice(invoice_id);
            })
            $('.search_btn').on('click', function(e) {
                e.preventDefault();

                $('.filter_block').slideToggle();
            })
        }
}
</script>
