<?php if (count($tools) > 0) { ?>
    <?php foreach($tools as $row) { ?> 
        <a class="listview__item">
            <div class="listview__content">
                <div class="listview__heading">
                    {{$row->name}}
                    <div class="float-right">
                        <button class="btn btn-primary openUpdateToolModal"  data-rel="" tool_type="{{$tool_type}}" data-id="{{$row->id}}" data-name="{{$row->name}}">Edit</button>
                        <button class="btn btn-danger deleteToolData"  data-rel="" tool_type="{{$tool_type}}" data-id="{{$row->id}}" data-name="{{$row->name}}">Delete</button>
                    </div>
                </div>
            </div>
        </a>
    <?php } ?>
<?php } else { ?>
    <div class="no-found">
        <div class="">
            <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
            <h2>No Record Yet.</h2>
        </div>
    </div>
<?php } ?>

