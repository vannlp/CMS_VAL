@props([
    'id' => '',
    'header' => "",
    'title' => "",
    'body' => '',
    'footer' => '',
    'size' => '',
    'addScript' => null
])


<!-- Modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{$size}}" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="{{$id}}ModalLabel">{{$title}}</h4>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {!! $body !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            {{__('app.base.close')}}
          </button>
          {!! $footer !!}
        </div>
      </div>
    </div>
</div>

@push('scripts')
{{ $addScript }}
@endpush