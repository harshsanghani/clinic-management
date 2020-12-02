<template>
    <div data-columns="2" class="tool_container">
        <div class="column size-1of2 tool_box"  v-for="tools in tool_type" :data-type='tools.name' :data-id='tools.id'>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ tools["name"] }}</h2>
                    <div class="actions">
                        <button class="btn btn-success openToolModal" @click="initAddTool(tools.name, tools.id)"  :data-type='tools.name' >Add</button>
                    </div>
                    <hr>
                </div>
                <div class="listview listview--hover" :id='tools.class'>
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_tools"  tabindex="-1">
            <div class="modal-dialog modal-sm" >
                <div class="modal-content">
                    <form class="tools_form" v-on:submit.prevent="toolCommit()" id="tools_detail" >
                        <input type="hidden" class="form-control tool_type" name="tool_type" value="">
                        <input type="hidden" class="form-control type_id" name="type_id" value="">
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
                 var type_id    = $(this).attr('data-id');
                 var type       = $(this).attr('data-type');
                 refresh_all(type_id,type);
            })

            $(document).on('click','.openUpdateToolModal',function(){
                $('.modal_title').html('Enter '+$(this).attr('tool_type'));
                $('.modal_title').css('textTransform', 'capitalize');
                $('.tool_type').val($(this).attr('tool_type'));
                $('.type_id').val($(this).attr('tool_id'));
                $('.tool_id').val($(this).attr('data-id'));
                $('.tool_name').val($(this).attr('data-name'));
                $('#modal_tools').modal('show');
            })

            $(document).on('click','.deleteToolData',function(){
                var id      = $(this).attr('data-id');
                var type    = $(this).attr('tool_type');
                var type_id = $(this).attr('tool_id');
                
                axios.post(portal_url + '/investigation/delete',{type : type ,id : id, type_id : type_id}).then(function (response) {
                    if(response.data.type) {
                        showMessage('success', response.data.message);
                        refresh_all(response.data.type_id,response.data.type);
                    }
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
            })
           
       },
       methods: {
           initAddTool:function(type, id) {    
                $('.modal_title').html('Enter '+type);
                $('.modal_title').css('textTransform', 'capitalize');
                $('.tool_type').val(type);
                $('.type_id').val(id);
                $('.tool_name').val('');
                $('#modal_tools').modal('show');
           },
           initUpdateTool:function(type, id, update_id, value) {
                
           },
           toolCommit() {

                let currentObj      = this;
                var form_data       = document.getElementById('tools_detail');
                var p_data          = new FormData(form_data);
                axios.post(portal_url + '/investigation/commit',p_data,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }})
                .then(function (response) {
                    if(response.data.status) {
                        showMessage('success', response.data.message);
                        refresh_all(response.data.type_id,response.data.type);
                    }
                    
                })
                .catch(function (error) {
                    currentObj.allErrors    = error.response.data;
                });
                $('#modal_tools').modal('hide');
            },
            initDeleteTool:function(type,id) {
               
            }
       }
   }
function refresh_all(type_id,type) {
    axios.post(portal_url + '/investigation/tool_data',{type_id : type_id,type : type}).then(function (response) {
         if(response.data.type) {
             $('#inv'+response.data.type_id).html(response.data.html);
         }
     });
}
</script>