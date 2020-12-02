@extends('portal.partial.master')
@section('content')
    <invoice :user="{{ $user }}" :patients ="{{$patient}}" :doctors="{{$doctors}}" ref="cc1"></invoice>
@stop