<template>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Master Admin</h2>        
            <div class="actions">
                <a :href="base_url+'portal/master/setup'" class="btn btn-success waves-effect btn-lg">New Admin</a>
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <v-server-table  ref="table" columnsClasses="table table-bordered invoice_table"
                    :columns="columns"
                    :options="options">
                    <div slot="action" slot-scope="{ row }">
                        <a :href="base_url+'portal/master/setup/'+row.id" class="btn btn-primary">Edit</a>
                        <a :href="base_url+'portal/master/delete/'+row.id" class="btn btn-danger">Delete</a>
                    </div>
                </v-server-table>
            </div>
        </div>
    </div>    
</template>
<script>
    import { ServerTable } from 'vue-tables-2';
    Vue.use(ServerTable);
   export default {
        props: {
            
        },
       data(){
            let currentObj2         = this;
            return {
                base_url        : base_url,
                report_url      : portal_url+'/master/list',
                columns         : ['full_name','email','phone','createdDate','action'],
                options         : currentObj2.get_option(),
            }
       },
       methods: {
        getData(data) {
                let currentObj2      = this;
                return axios.get(currentObj2.report_url, { params: data }).catch(function (e) {
                    
                }.bind(this));
        },
        get_option() {  
                let currentObj2             = this;
                var data =  {
                    headings: {
                        full_name       : 'Name',
                        email           : 'Email',
                        phone           : 'Phone',
                        createdDate    : 'Created Date',
                        action          : 'Action',
                    },
                    perPage: 10,
                    perPageValues: [10,20,30,50,100], 
                    sortable: ['full_name', 'email','phone','createdDate'],
                    requestFunction: function (data) {
                        let currentObj          = this;
                        var response_data       = currentObj2.getData(data);
                        return response_data;
                    },
                    responseAdapter: function(resp) {
                        return {
                            data: resp.data.data,
                            count: resp.data.total,
                        }
                    }
                    
                }
                return data;
            }
           
       },
       mounted()
       {
   
       }
   }
</script>