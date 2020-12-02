@extends('portal.partial.master')
@section('content')
<div class="content__inner">
    <?php $error = array(); ?>
    @if ($errors->any())
        @foreach($errors->getMessages() as $key => $message)
            @php $error[$key] = $message[0]; @endphp
        @endforeach
    @endif
    <?php $error = collect($error);?>
    <doctor_form :user_detail="{{ $user_detail }}" :error="{{ $error }}"></doctor_form>
</div>
@stop
@section('js')
    
@stop