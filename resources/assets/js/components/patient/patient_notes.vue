<template>
    <div v-if="notes['data'].length > 0" class="row">
        <div class="col-sm-4 col-md-3 notes__item"  v-for="(row, key) in notes['data']">
            <a href="javascript:void(0)" class="openNoteModal" data-id="" data-patient="" @click.prevent="Addnote(row['patient_id'],row['id'])">
                <div class="notes__title">
                    <span  v-if="row['appointment'] !== null"> 
                        {{date_format(row['appointment']['appointment_date'])}}
                    </span>
                    <span v-else> 
                        000-00-00
                    </span>
                </div>
                <div class="notes__body" >
                    {{strippedContent(row['notes'])}}
                </div>
                <div  :data="getAmount(row['received_amount'],row['amount'])"></div>
                <div class="notes__footer" :class="note_class">
                    {{getAmount(row['received_amount'],row['amount'])}}
                </div>
            </a>
            <div class="notes__actions" data-demo-action="delete-listing">
                <a class="delete_notes" href="" @click.prevent="DeleteNote(row['id'],row['patient_id'])"><i class="zmdi zmdi-delete"></i></a>
            </div>
        </div>
        <div class="col-sm-12 col-md-12" id="pagination">
            <div class="col-md-12 text-center">
                <div class="btn-group pull-right">
                   <pagination :data="notes" @pagination-change-page="getAllNotesList"></pagination> 
                </div>
            </div>
        </div>
    </div>
    <div class="no-found" v-else>
        <div class="card">
            <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
            <h2>No Record Yet.</h2>
        </div>
    </div>
</template>
<script>
    import moment from 'moment'
   export default {
        props: {
            patient: {
               type: Object,
               required: true,
            },
            notes: {
                type: Object,
                required: true,
             },
        },
        data(){
           return {
                 patient_id:this.patient['id'],
                 note_class:'',
           }
       },
       mounted()
       {
       },
       methods: {
            getAmount(received_amount, amount){
                var temp_amount = '';
                let currentObj  = this;
                if (parseInt(received_amount) > parseInt(amount)) {
                  temp_amount= "+"+ (parseInt(received_amount) - parseInt(amount));
                  currentObj.note_class = 'blue';
                } else if(parseInt(received_amount) == parseInt(amount)) {
                  temp_amount = amount;
                  currentObj.note_class = 'green';
                } else {
                    temp_amount ="-"+ (parseInt(amount) - parseInt(received_amount));
                }
                if (parseInt(temp_amount) == 0) {
                    temp_amount = '0.00';
                }
                return temp_amount;
            },
            getAllNotesList(page) {
                let currentObj  = this;
                let patient_id =  this.patient_id;
                axios.post(portal_url + '/patient/get_notes/'+patient_id+'?page='+page)
                .then(function (response) {
                    $(".note_container").html(response.data.html);
                })
                .catch(function (error) {
                });
            },
            DeleteNote(id, patient_id){
                if (confirm("Are you sure you want to delete this?")) {
                    let currentObj  = this;
                    axios.post(portal_url + '/patient/delete_notes/'+patient_id+'/'+id)
                    .then(function (response) {
                        showMessage('success', response.data.message);
                        currentObj.getAllNotesList();
                    })
                    .catch(function (error) {

                    });
                } else {
                    return false;
                }
            },
            Addnote(patient_id,id) {
                let currentObj  = this;
                axios.post(portal_url + '/patient/note_model/'+patient_id+'/'+id)
                .then(function (response) {
                    $(".edit-note").html(response.data.html);
                })
                .catch(function (error) {
                });
                $("#edit-note").modal('show');
                
            },
            strippedContent(string) {
                if (string != "" && string  !== null) {
                    return string.replace(/(<([^>]+)>)/ig,"");
                } else {
                    return '';
                }
            },
            date_format(value){
                if (value) {
                  return moment(String(value)).format('DD-MM-YYYY')
                 }
             },
       }
   }
</script>