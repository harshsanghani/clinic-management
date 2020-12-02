@extends('portal.partial.master')
@section('content')
<div class="content__inner"> 
        <patient_bill :report_type="{{ $report_type }}" :report_name="{{ $report_name }}" :patient_options="{{ $patient_options }}" :id="{{ $id }}" :report_detail="{{ $report_detail }}" :certificate_detail="{{ $certificate_detail }}" ></patient_bill>
</div>
@stop

@section('js')
    <script src="{{asset('assets/portal-side/js/inputmask.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/inputmask.extensions.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.inputmask.js')}}"></script>
    <script src="{{asset('public/portal-side/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/portal-side/js/modules/patient_bill.js') }}"></script>
@stop