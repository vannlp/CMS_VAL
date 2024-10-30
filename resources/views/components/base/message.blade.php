@if (session('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{session('message')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error_message'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{session('error_message')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif