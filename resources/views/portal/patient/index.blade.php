@extends('portal.partial.master')
@section('content')
<div class="content__inner">    
    <div class="toolbar">
        <nav class="toolbar__nav">
            <h4>Total <strong><?php echo isset($count_patient) ? $count_patient : "0"; ?></strong> Patients</h4>
        </nav>

        <div class="actions">
            <a href="{{asset('portal/patient/setup')}}" class="btn btn-success waves-effect btn-lg">New Patient</a>
        </div>

        <div class="toolbar__search">
            <input type="text" placeholder="Search...">

            <i class="toolbar__search__close zmdi zmdi-long-arrow-left" data-ma-action="toolbar-search-close"></i>
        </div>
    </div>
    <div id="patient_content">
        <patient></patient>
    </div>

</div>
@stop
