@extends('portal.partial.master')
@section('content')
<div class="content__inner">
    <tools :tool_type = "{{ $tool_type }}" ></tools>    
</div>
@stop