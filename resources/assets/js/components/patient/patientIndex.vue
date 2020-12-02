<template>
    <div  class="" v-if="patients.data">
        <div  class="contacts row" v-if="patients.data">
            <div class="col-xl-3 col-lg-3 col-sm-4 col-6" v-for="(row, key) in patients.data">
                <div class="contacts__item">
                    <a  class="contacts__img" @click="getDetailLink(row.id)">
                         <img v-if="row.path != '' && row.path !== null "  v-bind:src="base_url + row.path"   width="85" heigth="85">
                         <img v-else v-bind:src="base_url + 'assets/portal-side/img/avatar.png'" width="85" heigth="85">
                    </a>
                    <div class="contacts__info">
                        <strong>{{ row.title }} {{row.firstname}} {{row.middlename}} {{ row.lastname}}</strong>
                    </div>
                    <hr>
                    <div class="contacts__info">
                        <button @click="getDetailLink(row.id)" class="btn btn-success">View Details</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="pagination">
             <div class="col-md-12 text-center">
                 <div class="btn-group pull-right">
                    <pagination :data="patients" @pagination-change-page="readPatients"></pagination> 
                 </div>
             </div>
         </div>
    </div>
    <div  class="contacts row" v-else>
         <div class="no-found">
            <div class="card">
                <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
                <h2>No Record Yet.</h2>
            </div>
        </div>
    </div>
</template>
<script>
   export default {
       data(){
           return {
                errors:[],
                patients: [],
                imagepath: image_url,
                patientTotal: 0,
                id: '',
                base_url           : base_url,
           }
       },
       mounted()
       {
           this.readPatients();
       },
       methods: {
            readPatients(page)
            {
                 if (typeof page === 'undefined') {
                     page = 1;
                 }
                axios.get(portal_url+'/patient/lists?page='+page)
                .then(response => {
                    this.patients        = response.data;
                    this.patientTotal    = response.total;
                });
            },
            getImgUrl(image) {
                 var img_path = image_url+'/'+image;
                 return img_path;
            },
            getDetailLink(patient_id) {
                location.href = portal_url+'/patient/view/'+patient_id;
            }
       }
   }
   
</script>
