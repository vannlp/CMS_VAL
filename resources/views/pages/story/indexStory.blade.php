@extends('layouts/layoutMaster')

@section('title', 'Truyện')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/tagify/tagify.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
])
@endsection

@section('page-style')
<!-- Page -->
@vite([
  'resources/assets/vendor/scss/pages/cards-statistics.scss',
  'resources/assets/vendor/scss/pages/cards-analytics.scss'
])
@endsection


@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  // 'resources/assets/vendor/libs/apex-charts/apexcharts.js',
//   'resources/assets/vendor/libs/swiper/swiper.js',
    'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/tagify/tagify.js',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  
  ])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/forms-selects.js',
  // 'resources/assets/js/forms-tagify.js',
  // 'resources/assets/js/forms-typeahead.js'
])
@endsection

@section('content')
<div class="row g-6 mb-6">
    
</div>

<!-- Story List Table -->
<div class="card">
    <div class="card-header border-bottom">
      <h5 class="card-title mb-0">{{__("app.story.title")}}</h5>
      <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
        
        <div class="col-md-4 mb-4">
          @if (Permission::checkPermission('story.create'))
          <a class='btn btn-primary waves-effect waves-light' href="{{route('admin.story.create')}}" >
              <i class='ri-add-line me-0 me-sm-1 d-inline-block d-sm-none'></i>
              <span class= 'd-none d-sm-inline-block'> {{__("app.base.create")}} </span >
          </a>
          @endif
          
        </div>
        
        <div class="col-md-12">
          <x-base.message></x-base.message>
          <x-base.error></x-base.error>
        </div>
      </div>
    </div>
    <div class="card-datatable table-responsive">
        @php
          $header = [
            'id',
            __('app.base.title'),
            __('app.base.slug'),
            __('app.base.author'),
            __('app.base.status'),
            __('app.base.action'),
          ];    
          $settings = [
            "serverSide" => true,
          ];
        @endphp
        <x-dataTable.dataTable1 id="storyData" :header="$header" route="admin.story.datatable" :setting="$settings">
          <x-slot:addScript>
            <script type="module">
              settings_storyData = {
                columns: [
                  { data: 'id', name: 'id' },
                  { data: 'story_info', name: 'story_info' },
                  { data: 'slug', name: 'slug' },
                  { data: 'author', name: 'author' },
                  { data: 'status', name: 'status', render: function(data, type, row) {
                      let html = '';
                      if(data == 1) {
                          html = `<span class="badge rounded-pill bg-label-success" text-capitalized="">{{__('app.base.active')}}</span>`;
                      }else{
                          html = `<span class="badge rounded-pill bg-label-danger" text-capitalized="">{{__('app.base.inactive')}}</span>`;
                      }
                      return html;
                  }, },
                  { title: "action", render(data, type, row) {
                    let deleteButton = `<button 
                      data-id="${row.id}"
                      href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect delete-record" data-bs-toggle="tooltip" title="Delete"><i class="ri-delete-bin-7-line ri-20px"></i></button>`;
                    
                    let editButton = `<button
                            data-id="${row.id}"
                            href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect edited_category" data-bs-toggle="tooltip" title="Edit"><i class="ri-edit-box-line"></i></button>`;
                    
                    let groupAction = `
                      <div class="d-flex align-items-center gap-50">
                        ${editButton} ${deleteButton}
                      </div>
                    `;
                    
                    return groupAction;
                  } }
                  // Thêm các cột khác tùy ý
                ]
              };
              
              params_storyData = {
                // type_filter: type_filter
              }
              
            </script>
          </x-slot:addScript>
        </x-dataTable.dataTable1>
    </div>
</div>

@endsection


@push('scripts')
{{-- <script type="module" defer>
  $(document).on('click', '.delete-record', function() {
      let id =  $(this).data('id');
      if(confirm("Bạn có đồng ý xóa?")) {
        window.axios.delete(`{{ route('admin.story.category.delete', ['id' => '__ID__']) }}`.replace('__ID__', id))
          .then(function(response) {
            alert(`${response.message}`);
            window.storyCategoryData_datatable.ajax.reload();
          }).catch((err) => {
            alert(`${err}`);
          })
      }
    })
</script> --}}
@endpush