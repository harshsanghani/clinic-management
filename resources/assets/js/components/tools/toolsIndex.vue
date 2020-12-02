<template>
    <div data-columns="2" class="tool_container">
        <div class="column size-1of2 tool_box"  v-for="tools in tool_type" :data-type='tools.name'>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ tools["title"] }}</h2>
                    <div class="actions">
                        <button class="btn btn-success openToolModal" @click="initAddTool(tools.name)"  :data-type='tools.name' >Add</button>
                    </div>
                    <hr>
                </div>
                <div class="listview listview--hover" :id="tools.name">
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_tools"  tabindex="-1">
            <div class="modal-dialog modal-sm" >
                <div class="modal-content">
                    <form class="tools_form" v-on:submit.prevent="toolCommit()" id="tools_detail" >
                        <input type="hidden" class="form-control tool_type" name="tool_type" value="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="modal_title"></label>
                                        <input type="text" autocomplete="afgf" class="form-control tool_name" name="name" value="">
                                    </div>
                                    <input type="hidden" class="form-control tool_id" name="tool_id" value="">
                                </div>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-success btn-lg waves-effect">Save</button>
                                <button type="button" class="btn btn-primary btn-lg waves-effect pull-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
   export default {
        props: {
            tool_type : {
               type     : Array,
               required : true,
            },
        },
       data(){
           return {
            tool : this.tool_type,    
           }
       },
       mounted()
       {
           var $this = this;
           $('.tool_container .tool_box').each(function(){
                var type = $(this).attr('data-type');
                refresh_all(type);
            })
            $(document).on('click','.openUpdateToolModal',function(){
                $('.modal_title').html('Enter '+$(this).attr('tool_type'));
                $('.modal_title').css('textTransform', 'capitalize');
                $('.tool_type').val($(this).attr('tool_type'));
                $('.tool_id').val($(this).attr('data-id'));
                $('.tool_name').val($(this).attr('data-name'));
                $('#modal_tools').modal('show');
            })
            $(document).on('click','.deleteToolData',function(){
                var id      = $(this).attr('data-id');
                var type    = $(this).attr('tool_type');
                
                axios.post(portal_url + '/tool/delete',{type : type ,id : id}).then(function (response) {
                    if(response.data.type) {
                        showMessage('success', response.data.message);
                        refresh_all(response.data.type);
                    }
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
            })
            
           
       },
       methods: {
           initAddTool:function(type) {    
                $('.modal_title').html('Enter '+type);
                $('.modal_title').css('textTransform', 'capitalize');
                $('.tool_type').val(type);
                $('.tool_name').val('');
                $('#modal_tools').modal('show');
           },
           initUpdateTool:function(type,id,value) {
                   
           },
           initRefreshAll(type) {
               
            },
           toolCommit() {

                let currentObj      = this;
                var form_data       = document.getElementById('tools_detail');
                var p_data          = new FormData(form_data);
                axios.post(portal_url + '/tool/commit',p_data,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }})
                .then(function (response) {
                    if(response.data.status) {
                        showMessage('success', response.data.message);
                    }
                    refresh_all(response.data.type);
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
                $('#modal_tools').modal('hide');
            },
            initDeleteTool:function(type,id) {
                var element = event.target;
                element.getAttribute('data-id');

            }
            
       }
   }

function refresh_all(type) {
    axios.post(portal_url + '/tool/tool_data',{type : type}).then(function (response) {
         if(response.data.type) {
             $('#'+response.data.type).html(response.data.html);
         }
     });
}
</script>