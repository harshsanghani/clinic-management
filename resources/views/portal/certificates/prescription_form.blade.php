@extends('portal.partial.master')
@section('content')
<div class="content__inner"> 
        <prescription_form :report_type="{{ $report_type }}" :report_name="{{ $report_name }}" :patient_options="{{ $patient_options }}" :id="{{ $id }}" :medicine_options="{{ $medicine_options }}" :potency_options="{{ $potency_options }}" :dosage_options="{{ $dosage_options }}" :repetition_options="{{ $repetition_options }}" :report_detail="{{ $report_detail }}" :certificate_detail="{{ $certificate_detail }}"></prescription_form>
</div>
@stop

@section('js')
    <script src="{{asset('assets/portal-side/js/inputmask.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/inputmask.extensions.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.inputmask.js')}}"></script>
    <script src="{{ asset('public/portal-side/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/portal-side/js/modules/prescription.js') }}"></script>
@stop