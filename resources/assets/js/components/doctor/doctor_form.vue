<template>
    <div class="card">
        <div class="card-block">
            <div class="col-sm-12">
                <form method="post" :action="base_url+ 'portal/doctor/commit'" id="setup_form">
                    <input type="hidden" :value="csrftoken" name="_token"/>
                    <input type="hidden" id="doctor_id" name="doctor_id" value="" v-model="u_detail.id"/>
                    <div class="row">                                
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="full_name" class="form-control" name="full_name" value="" v-model="u_detail.full_name">
                                <span class="errors">{{error.full_name}}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" class="form-control" name="email" value="" v-model="u_detail.email">
                                <span class="errors">{{error.email}}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" id="phone" class="form-control" name="phone" value="" v-model="u_detail.phone">
                                <span class="errors">{{error.phone}}</span>   
                            </div>
                        </div>
                    </div>
                    <div class="row">                                
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="username" class="form-control" name="username" value="" v-model="u_detail.username">
                                <span class="errors">{{error.username}}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control" name="password" >
                                <span class="errors">{{error.password}}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="text" class="form-control" name="confirm_password">
                                <span class="errors">{{error.confirm_password}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="has-success">
                    </div>
                    <div class="form-group" v-if='u_detail.isActive === "1"'>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="isActive" checked>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Allow Login?</span>
                        </label>
                    </div>
                    <div class="form-group" v-else>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="isActive">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Allow Login?</span>
                        </label>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" id="submit" class="btn btn-success btn-lg waves-effect">Save Details</button>
                        </div>
                    </div>                                                        
                </form>    
            </div>
        </div>
    </div>    
</template>
<script>
   axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
   export default {
        props: {
            user_detail: {
               type     : Object,
               required : true,
            },
            error: {
               type     : Array,
               required : true,
            },
            
        },
       data(){
           return {
                base_url        : base_url,
                csrftoken       : "",
                u_detail        : this.user_detail,
                error           : this.error,
           }
       },
       mounted()
       {   
         this.csrftoken = document.querySelector('meta[name="csrf-token"]').content
       },
       methods: {
            userCommit() {

               
            }
       }
   }
</script>