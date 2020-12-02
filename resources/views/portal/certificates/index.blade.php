@extends('portal.partial.master')
@section('content')
<div class="content__inner">
    <certificate :report_type="{{ $report_type }}" :report_name="{{ $report_name }}" ></certificate>
</div>
@stop
@section('js')
<script>
    $(function() {
        setTimeout(function(){ 
            $('#certificate_report').DataTable();
        }, 500);
    });
</script>
@stop