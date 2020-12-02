<template>
<div class="card">
        <div class="card-header">
            <div class="actions">
                <a href="javascript:void;" @click="getAddLink()" class="btn btn-success waves-effect btn-lg">Add Report</a>
            </div>
            <h2 class="card-title">Prescription</h2>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table id="prescription_report" class="table table-bordered" v-if="prescription.data.length > 0">
                    <thead class="thead-default">
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="(row, key) in prescription.data">
                        <tr>
                            <td>{{row.firstname}} {{row.middlename}} {{row.lastname}}</td>
                            <td>{{row.date}}</td>
                            <td> 
                                <button class="btn btn-primary" @click="prescriptionsetupUrl(row.id)">Edit</button>
                                <a @click.prevent="removeprescription(row.id)" class="btn btn-danger deleteToolData remove_prescription" style="color:white;" title="Delete Prescription">Delete</a>
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
                </table>

            <div  class="contacts row" v-else>
                <div class="no-found">
                   <div class="card">
                       <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
                       <h2>No Record Yet.</h2>
                   </div>
               </div>
           </div>

        <div class="modal fade" id="prescription_remove">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h4>Are you sure?</h4> 
                        <hr>
                        <a href="javascript:void(0)" class="btn btn-danger btn-lg" data-dismiss="modal">No</a>
                        <a href="javascript:void(0)" class="btn btn-success btn-lg prescription_removes">Yes, Delete it</a>
                    </div>
                </div>
            </div>
        </div>

            </div>
        </div>
    </div>
</template>
<script>
   export default {
       data(){
           return {
                errors:[],
                prescription: []
           }
       },
       mounted()
       {
         this.readPrescription();
       },
       methods: {
            readPrescription(page)
            {
                 if (typeof page === 'undefined') {
                     page = 1;
                 }
                axios.get(portal_url+'/prescription/prescription_lists?page='+page)
                .then(response => {
                    this.prescription           = response.data;
                    this.prescriptionTotal      = response.total;
                });
            },
            getAddLink() {
                location.href = portal_url+'/prescription/setup';
            },
            prescriptionsetupUrl(prescription_id) {
                 location.href = portal_url+'/prescription/setup/'+prescription_id;
            },
            removeprescription:function(prescription_id) {
                $('#prescription_remove').modal('show');
                $('.prescription_removes').attr('href', portal_url+'/prescription/delete_prescription/'+prescription_id);
                return false;
            },
       }
   }
   
</script>

