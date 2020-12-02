<script>
new Vue({
    el: '.app3'

 });
</script>
<style>
    .green {
     background-color: #30c183;   
    }
    
</style>
<div  class="app3">
    <patient_notes  :notes="{{ $notes }}"  :patient="{{ $patient }}"></patient_notes>
</div>