@extends('portal.partial.master')
@section('css')
<!--<link rel="stylesheet" href="{{asset('assets/portal-side/css/dropzone.css')}}">-->
@stop
@section('content')
<div class="content__inner">   
      <div id="patient_content">
        <patient_view :patient="{{ $patient }}"></patient_view>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-9">
                    <h2 class="card-title">Photos of reports</h2>
                    <small class="card-subtitle">Here you can find & upload reports of patient.</small>
                </div>
                <div class="col-sm-3 text-right">
                    <a href="" class="btn btn-success waves-effect btn-lg">Back to Profile</a>
                </div>
            </div>
        </div>

        <div class="card-block">
            <patient_report :patient="{{ $patient }}">
            </patient_report>
        </div>
    </div> 
</div>
@stop
@section('js')
<script>
$(document).ready(function(){
    //initDropZone();
});
</script>
@stop