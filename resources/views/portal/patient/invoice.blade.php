@extends('portal.partial.master')
@section('content')
<div class="content__inner">   
    <div id="patient_content">
        <patient_view :patient="{{ $patient }}"></patient_view>
    </div>
    <div class="card">
        <div class="card-block">
            <patient_invoice :patient="{{ $patient }}"></patient_invoice>
        </div>
    </div> 
</div>
@stop