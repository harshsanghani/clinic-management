@extends('portal.partial.master')
@section('content')
<div class="content__inner">
    <calendar ref="calendar"  :patients="{{ $patient_list }}" :time_slots="{{ $time_slots }}" :appointments="{{ $appointments}}" :doctors="{{$doctors}}" ></calendar>

</div>
@stop
