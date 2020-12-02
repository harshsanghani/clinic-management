<template>
    <div class="notes note_container">
        <div class="no-found">
            <div class="card">
                <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
                <h2>No Record Yetasasas.</h2>
            </div>
        </div>
    </div>
</template>
<script>
   export default {
        props: {
            patient: {
               type: Object,
               required: true,
            },
        },
        data(){
           return {
                patient_id:this.patient['id'],
           }
       },
       mounted()
       {    
            this.getAllNotesList();
       },
       methods: {
            getAllNotesList(page=1) {
                let currentObj  = this;
                axios.post(portal_url + '/patient/get_notes/'+this.patient_id+'?page='+page)
                .then(function (response) {
                    $(".note_container").html(response.data.html);
                })
                .catch(function (error) {
                
                });
            }
       }
   }
</script>