@if ($errors->any())
    <div class="alert alert-danger p-0">
        <ul class="list-group p-0">
            @foreach ($errors->all() as $error)
                <li class="list-group-item text-danger">خطا: {{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
