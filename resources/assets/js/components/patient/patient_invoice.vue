<template>
        
     <div class="">
        <div class="row">
            <div class="table-responsive">
                <v-server-table ref="myTable" columnsClasses="table table-bordered invoice_table"
                        :columns="columns"
                        :options="options">
                    <div slot="action" slot-scope="{ row }">
                        <button type="button" data-toggle="dropdown" class="btn btn-warning waves-effect" aria-expanded="false">Actions <b class="caret"></b></button>
                        <div class="dropdown-menu invoice_action">
                            <a class="dropdown-item" :href="report_url+row.id"  target="_blank">View PDF</a>
                            <a class="dropdown-item send_email" :href="report_url+row.id"  @click.prevent="email_invoice_model(row.id,row.email)">Send Email</a>
                        </div>  
                    </div>
                </v-server-table>
            </div>
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
</template>
 
<script>
import { ServerTable } from 'vue-tables-2';
Vue.use(ServerTable);
    export default {
        props: {
            patient: {
               type: Object,
               required: true,
            },
        },
        data() {
            let currentObj2      = this;
            return {
                report_url : portal_url+'/patient/invoice_report/',
                patient_id : this.patient['id'],
                columns: ['appointment_date', 'medicines', 'amount','action'],
                options: {
                    headings: {
                        appointment_date    : 'Appointment Date',
                        medicines           : 'Medicine',
                        amount              : 'Amount',
                        action              : 'Action',
                    },
                    perPage: 10,
                    perPageValues: [5,10,20,30,50,100], 
                    sortable: ['appointment_date', 'medicines'],
                    filterable: ['appointment_id'],
                    requestFunction: function (data) {
                        let currentObj      = this;
                        return axios.get(portal_url+'/patient/get_ajax_invoice/'+currentObj2.patient_id, { params: data }).catch(function (e) {
                            currentObj.dispatch('error', e);
                        }.bind(this));
                    },
                    responseAdapter: function(resp) {
                        return {
                            data: resp.data.data,
                            count: resp.data.total,
                        }
                    }
                }
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
                    axios.post(currentObj.report_url+invoice_id)
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
            }
        },
        mounted() {
            let currentObj      = this;
            $(document).on('click','.invoice_email',function(e)  {
                e.preventDefault();
                var invoice_id = $(this).attr('invoice_id');
                currentObj.email_invoice(invoice_id);
            })
        }
}
</script>
