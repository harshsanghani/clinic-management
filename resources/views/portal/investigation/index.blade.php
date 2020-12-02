@extends('portal.partial.master')
@section('content')
<div class="content__inner">
    <investigation :tool_type = "{{ $tool_type }}" ></investigation>
</div>
@stop