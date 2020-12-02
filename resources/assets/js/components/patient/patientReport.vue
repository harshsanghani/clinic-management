<template>
<div class="">
    <div class="row">
        <div class="col-sm-12">
            <vue-dropzone ref="myVueDropzone" id="dropzone"  :options="UploadReport"  @vdropzone-success="UploadSuccess" ></vue-dropzone>
        </div>
    </div>
    <br/>
    <div class="row  reports_block">
    </div>
</div>
</template>
<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
  
    export default {
        props: {
            patient: {
               type: Object,
               required: true,
            },
        },
        components: {
           vueDropzone: vue2Dropzone
         },
        data: function () {
          return {
            UploadReport: {
                url: portal_url+'/patient/report_upload/'+this.patient['id'],
                headers: {
                  "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                 },
                 acceptedFiles: '.gif,.jpg,.jpeg,.png,.pdf,.mp4,.JPEG,.PDF,.PNG,.JPG,.GIF,.MP4',
            },
          }
        },
        methods: {
            UploadSuccess(file,response) {
                let data      = JSON.parse(response);
                 this.removeFiles();
                if(data.status) {
                    this.readReport();
                } else {
                    showMessage('danger', data.message);
                }
                
            },
            readReport() {
               axios.post(portal_url + '/patient/report/'+this.patient['id'])
                .then(function (response) {
                    if(response.data.status) {
                       $('.reports_block').html(response.data.html);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             deleteReport(id) {
                if(confirm('Are you sure you want to delete ?')) {
                    let currentObj      = this;
                   axios.get(portal_url + '/patient/detete_report/'+id)
                   .then(function (response) {
                       if(response.data.status) {
                          currentObj.readReport();
                          showMessage('success', response.data.message);
                       } else {
                            showMessage('danger', response.data.message);
                       }
                   })
                   .catch(function (error) {
                   });
                }
             },
             removeFiles() {
                $('.dz-preview').remove();
                $('.vue-dropzone').removeClass('dz-started');
             },
        },
        mounted() {
            let currentObj      = this;
            $(document).on('click','.delete_report',function(e)  {
               e.preventDefault();
               var id = $(this).attr('data-id');
               currentObj.deleteReport(id);
            })
            currentObj.readReport();
        }
    }
</script>