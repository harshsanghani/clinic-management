<template>
   <div class="search">
         <autocomplete></autocomplete>
    </div>
</template>
<script>
$(document).click(function() {
    $('.patient_search_result').html('');
});
Vue.component('autocomplete', {
    template: '<div class="search__inner"><input type="text" placeholder="Search for patients...." v-model="searchquery" v-on:keyup="autoComplete" class="search__text"><i class="zmdi zmdi-search search__helper" data-ma-action="search-close"></i><div class="patient_search_result" style=""></div></div>',
    data: function () {
      return {
        searchquery: '',
        data_results:''
      }
    },
    methods: {
      autoComplete(){
        if(this.searchquery.length > 2){
         axios.get(portal_url+'/patient/search_patient',{params: {search: this.searchquery}}).then(response => {
              $('.patient_search_result').html(response.data.html);
         });
        } else {
            $('.patient_search_result').html('');
        }
     }
    },
});
</script>
