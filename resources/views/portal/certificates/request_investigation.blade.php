@extends('portal.partial.master')
@section('content')
<div class="content__inner"> 
    <request_investigation :report_type="{{ $report_type }}" :report_name="{{ $report_name }}" :patient_options="{{ $patient_options }}" :investigations="{{ $investigations }}" :id="{{ $id }}" :report_detail="{{ $report_detail }}" :certificate_detail="{{ $certificate_detail }}"></request_investigation>
</div>
@stop
@section('js')
    <script src="{{asset('assets/portal-side/js/inputmask.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/inputmask.extensions.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.inputmask.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/portal-side/js/modules/request_investigation.js') }}"></script>
@stop