@if(Session::has('m'))
    <?php $a = []; $a = session()->pull('m'); ?>
    <div class="alert alert-{{$a[0]}}" style="margin-top: 15px;">
        {{$a[1]}}
    </div>
@endif

@if(count($errors) > 0)
    <div class="alert alert-danger" style="margin-top: 15px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
