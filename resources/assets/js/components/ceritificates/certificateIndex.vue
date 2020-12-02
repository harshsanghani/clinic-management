<template>
<div class="card">
    <div class="card-header">
        <div class="actions">
            <a href="javascript:void;" @click="getAddLink(report_val.id)" class="btn btn-success waves-effect btn-lg">Add Report</a>
        </div>
        <h2 class="card-title">{{report_val.name}}</h2>
    </div>
    <div class="card-block">
        <div class="table-responsive">
           <table id="certificate_report" class="table table-bordered">
                    <thead class="thead-default">
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="prescription.data.length > 0">
                        <tr v-for="(row, key) in prescription.data">
                            <td>{{row.firstname}} {{row.middlename}} {{row.lastname}}</td>
                            <td>{{row.date}}</td>
                            <td> 
                                <button class="btn btn-primary" title="Edit patient bill" @click="prescriptionsetupUrl(row.id,row.report_type)">Edit</button>
                                <a @click.prevent="removeprescription(row.id,row.report_type)" class="btn btn-danger deleteToolData remove_prescription" style="color:white;" title="Delete patient bill">Delete</a>
                                <span class="dropdown_box">
                                    <button type="button" data-toggle="dropdown" class="btn btn-warning waves-effect" aria-expanded="false">Actions <b class="caret"></b></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" target="_blank">View PDF</a>
                                        <a class="dropdown-item send_email" data-email="" href="#">Send Email</a>
                                    </div>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="3" style="text-align:center;">Data Not Found</td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
    <div class="modal fade" id="certificate_remove">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4>Are you sure?</h4> 
                    <hr>
                    <a href="javascript:void(0)" class="btn btn-danger btn-lg" data-dismiss="modal">No</a>
                    <a href="javascript:void(0)" class="btn btn-success btn-lg certificate_removes">Yes, Delete it</a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
   export default {
        props: {
            report_type: {
               type     : Array,
               required : true,
            },
            report_name: {
               type     : Array,
               required : true,
            },
        },
       data(){
           return {
                errors:[],
                prescription: [],
                report_val : this.report_name,
           }
       },
       mounted()
       { 
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
            prescriptionsetupUrl(certificate_id,report_type) {
                location.href = portal_url+'/certificate/setup/'+report_type+'/'+certificate_id;
            },
            removeprescription:function(certificate_id,report_type) {
                $('#certificate_remove').modal('show');
                $('.certificate_removes').attr('href',portal_url+'/certificate/delete/'+report_type+'/'+certificate_id);
                return false;
            }
       }
   }
   
</script>

