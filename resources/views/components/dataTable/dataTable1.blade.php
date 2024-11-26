@props([
    'header' => [],
    'route' => false,
    'id' => '',
    'setting' => [],
    'addScript' => '',
    'addScriptAfter' => ''
])
{{-- Styles --}}
@push('styles')

@endpush

{{-- HTML --}}
<table class="datatables-users table" id="{{$id}}">
    <thead>
      <tr>
        @foreach ($header as $item)
            @if (is_array($item))
            <th style="{!!$item->style ?? ''!!}">{!!$item->name ?? ''!!}</th>
            @else
            <th>{!!$item!!}</th>
            @endif
        @endforeach
      </tr>
    </thead>
    
    <tbody>
        
    </tbody>
</table>
{{-- js --}}
@push('scripts')
<script>
    let settings_{{$id}} = {};
    let params_{{$id}} = null;
</script>

{{ $addScript }}
<script type="module">
    let setting_{{$id}} = @json($setting);
    settings_{{$id}} = {...settings_{{$id}}, ...setting_{{$id}}};
    $(document).ready(function() {
        window.{{$id}}_datatable = $("#{{$id}}").DataTable({
            processing: true,
            ajax: {
                url: '{{ route($route) }}',
                type: "GET",
                data: function(data) {
                    return params_{{$id}}(data);
                }
            },
            ...settings_{{$id}},
        })
        
        
        {{ $addScriptAfter }}
    })
    
</script>
@endpush

