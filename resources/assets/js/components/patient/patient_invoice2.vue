<template>
    <div class="">
        <div class="row">
            <div class="table-responsive">
                <datatable :columns="columns" :data="rows"></datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</template>
<script>
    import DatatableFactory from 'vuejs-datatable';
    export default {
        props: {
            patient: {
               type: Object,
               required: true,
            },
        },
        components: { 
            DatatableFactory 
        },
        mounted() {
            let currentObj      = this;
        },
        data(){
            return {
                columns: [
                        {label: 'id', field: 'id'},
                        {label: 'patient_id', field: 'patient_id'},
                        {label: 'appointment_id', field: 'appointment_id'}
                    ],
                rows: [],
                page: 1,
                per_page: 10,
            }
        },
        methods: {
            getUsers: function() {
                axios.post(portal_url + '/patient/invoice/'+this.patient.id).then(function(response){
                    this.rows = response.data;
                }.bind(this));
            }
        },
        created: function(){
            this.getUsers()
        },
    }
</script>