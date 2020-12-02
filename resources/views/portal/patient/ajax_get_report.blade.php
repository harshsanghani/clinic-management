@if ( isset($reports) && !empty($reports))
    @foreach ($reports as $report)
        <div class="col-sm-2 col-6 report_thumbs">
            <a href="{{$report['preview_path']}}" target="_blank">
                <div class="">
                    <img src="{{$report['file_path']}}">
                </div>
            </a>
            <div class="text-center">
                <a href="" class="btn btn-danger delete_report" data-id="{{$report['report_id']}}">Delete</a>
            </div>
        </div>
    @endforeach
@endif