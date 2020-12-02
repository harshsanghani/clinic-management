@extends('portal.partial.master')
@section('content')
<div class="content__inner">    
    <div id="patient_content">
        <patient_setup :patient="{{ $patient }}"  :address_info="{{ $address_info }}" :blood_options="{{ $blood_options }}" :religion_options="{{ $religion_options }}" :prognosis_options="{{ $prognosis_options }}" :occupation_options="{{ $occupation_options }}" :organisation_options="{{ $organisation_options }}" :marital_status_options="{{ $marital_status_options }}" :diet_options="{{ $diet_options }}"> </patient_setup>
    </div>
</div>
@stop

@section('js')
    <script src="{{asset('assets/portal-side/js/inputmask.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/inputmask.extensions.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.inputmask.js')}}"></script>
@stop