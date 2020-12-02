<script>
new Vue({
    el: '.app2'

 });
</script>
<div  class="app2">
    <invoice_model :patient="{{ $patient }}"   :payment_modes="{{ $payment_modes }}"  :notes="{{$notes}}" :time_slots="{{$time_slots}}"  :appointment="{{$appointment}}"></invoice_model>
</div>
