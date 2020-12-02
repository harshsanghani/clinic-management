@if (!empty($extra_notes))
    @foreach ($extra_notes as $extra_note)
        <div class="messages__item messages__item--right">
            <a href="javascript:void(0)" data-patient="{{$extra_note->patient_id}}" data-id="{{$extra_note->id}}" class="remove-extra-notes extra_notes_{{$extra_note->id}}"><i class="zmdi zmdi-delete zmdi-hc-fw" style="font-size: 18px;"></i></a>
            <div class="messages__details">
                <p><?php echo $extra_note->note; ?></p>
                <small><i class="zmdi zmdi-time"></i> {{$extra_note->created_date}}</small>
            </div>
        </div>
    @endforeach
@else
    <div class="no-found">
        <div class="card">
            <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
            <h2>No extra notes found.</h2>
        </div>
    </div>
@endif