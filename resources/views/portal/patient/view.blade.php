@extends('portal.partial.master')

@section('content')
<div class="content__inner">
    <div id="patient_content">
        <patient_view :patient="{{ $patient }}" ></patient_view>
    </div>
     <note_view  :patient="{{ $patient }}" ></note_view>
</div>


@stop