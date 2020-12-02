@extends('portal.partial.master')
@section('content')

@stop
@section('css')
    <link rel="stylesheet" href="{{asset('assets/portal-side/css/flatpickr.min.css')}}">
@stop
@section('js')
    <script src="{{asset('assets/portal-side/js/flatpickr.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/portal-side/js/jszip.min.js')}}"></script>
    <script src="{{asset('buttons.html5.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            if($(".from-date").length > 0) {
                $(".from-date").flatpickr({
                enableTime  : !1,
                dateFormat  : 'Y-m-d',
                autoclose   : true,
                nextArrow   : '<i class="zmdi zmdi-long-arrow-right" />',
                prevArrow   : '<i class="zmdi zmdi-long-arrow-left" />',
                    onChange: function(selectedDates, dateStr, instance) {
                       get_todate(dateStr); 
                    }
                });
            }
            function get_todate(from_date) {
                if($(".to-date").length > 0) {
                    $(".to-date").flatpickr({
                        enableTime  : !1,
                        dateFormat  : 'Y-m-d',
                        autoclose   : true,
                        minDate     : from_date,
                        nextArrow   : '<i class="zmdi zmdi-long-arrow-right" />',
                        prevArrow   : '<i class="zmdi zmdi-long-arrow-left" />'
                    });
                }
            }
            
        });
    </script>
@stop