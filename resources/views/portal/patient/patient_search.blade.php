@if(!empty($patient) && count($patient) > 0)
    <ul class="blog-list-sidebar popular-post-list location_search"> 
        <?php foreach ($patient as $row) { ?>
            <li  class="listing-li">
                <a href="{{asset('/portal/patient/view/'.$row->id)}}">
                    <div class="post-thumb">
                        @if(isset($row->imageInfo))
                            <img src="{{asset($row->imageInfo->path)}}" alt="Blog"  width="85" heigth="85" id="show_image">
                        @else
                             <img src="{{asset('assets/portal-side/img/avatar.png')}}"   width="85" heigth="85" id="show_image">
                        @endif
                    </div>
                    <div class="post-info">
                        <h5 class="entry_title">
                            <?php echo $row->firstname." ".$row->middlename." ".$row->lastname; ?>
                        </h5>
                        <div class="post-meta"><span class=""><?php echo isset($row->email) && $row->email != '' ? $row->email : ''; ?></span> </div>
                    </div>
                </a> 
            </li>
        <?php } ?>
    </ul>
@endif
