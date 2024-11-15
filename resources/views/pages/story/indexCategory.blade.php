@extends('layouts/layoutMaster')

@section('title', 'Danh mục truyện')

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

<!-- Story Category List Table -->
<div class="card">
    <div class="card-header border-bottom">
      <h5 class="card-title mb-0">{{__("app.story.category_title")}}</h5>
      <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
        <div class="col-md-12 mb-4 border-bottom pb-3">
          <div class="row">
            <div class="col-3">
              <div class="form-floating form-floating-outline">
                <select id="type_filter" class="form-select">
                  <option value="0">--Tất cả--</option>
                  @foreach (App\Models\StoryCategory::TYPE as $type)
                      <option value="{{$type}}">{{$type}}</option>
                  @endforeach
                </select>
                <label for="type_filter">{{__('app.story.category_feild.type')}}</label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4">
          @if (Permission::checkPermission('story.create'))
          <button class='btn btn-primary waves-effect waves-light' 
          data-bs-toggle="modal" 
          data-bs-target='#create_category'>
              <i class='ri-add-line me-0 me-sm-1 d-inline-block d-sm-none'></i>
              <span class= 'd-none d-sm-inline-block'> {{__("app.base.create")}} </span >
          </button>
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
            __('app.story.category_feild.name'),
            __('app.story.category_feild.short_description'),
            __('app.story.category_feild.slug'),
            __('app.story.category_feild.type'),
            __('app.story.category_feild.status'),
            __('app.base.action'),
          ];    
          $settings = [
            "serverSide" => true,
          ];
        @endphp
        <x-dataTable.dataTable1 id="storyCategoryData" :header="$header" route="admin.story.category.datatable" :setting="$settings">
          <x-slot:addScript>
            <script type="module">
              let type_filter = $("#type_filter").val();
              settings_storyCategoryData = {
                columns: [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'short_description', name: 'short_description' },
                  { data: 'slug', name: 'slug' },
                  { data: 'type', name: 'type' },
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
              
              params_storyCategoryData = {
                type_filter: type_filter
              }
              
              $("#type_filter").on('change', function() {
                type_filter = $(this).val();
                window.storyCategoryData_datatable.ajax.reload();
              })
            </script>
          </x-slot:addScript>
        </x-dataTable.dataTable1>
    </div>
</div>

{{-- Create Modal --}}
<x-base.modal title="{{__('app.story.create_category')}}" id="create_category" size="modal-lg">
  <x-slot:body>
    <form action="{{route('admin.story.category.create')}}" method="post" id="create_category_form">
      @csrf
      <div class="row">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" name="name" id="name_create" class="form-control" />
            <label for="name_create">{{__('app.story.category_feild.name')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
            <input type="text" name="slug" id="slug_create" class="form-control" />
            <label for="slug_create">{{__('app.story.category_feild.slug')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
            <textarea name="short_description" id="short_description_create" class="form-control h-px-100"></textarea>
            <label for="short_description_create">{{__('app.story.category_feild.short_description')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
            <textarea name="description" id="description_create" class="form-control h-px-100"></textarea>
            <label for="description_create">{{__('app.story.category_feild.description')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
              <select id="parent_id_create" class="form-select select2" name="parent_id">
                  <option value="-1">Danh mục cha (hoặc tác giả)</option>
                  @foreach ($parentCategorys as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
              </select>
            <label for="parent_id_create">{{__('app.story.category_feild.parent')}}</label>
          </div>
        </div>
        
        <div class="col-6 mt-4">
          <div class="text-light small fw-medium mb-3">{{__('app.base.status')}}</div>
          <label class="switch">
            <input type="checkbox" class="switch-input" name="status" id="status_create" />
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('app.base.status')}}</span>
          </label>
        </div>
        
        <div class="col-6 mt-4 ">
          <div class="form-floating form-floating-outline">
              <select id="type_create" class="form-select" name="type">
                  @foreach (App\Models\StoryCategory::TYPE as $type)
                      <option value="{{$type}}">{{$type}}</option>
                  @endforeach
              </select>
              <label for="type_create">{{__('app.base.type')}}</label>
          </div>
        </div>
        
      </div>
    </form>
  </x-slot:body>
    
  <x-slot:footer>
    <button type="submit" class="btn btn-primary" form="create_category_form">Save changes</button>
  </x-slot:footer>
    
</x-base.modal>

{{-- Edit Modal --}}
<x-base.modal title="{{__('app.story.edit_category')}}" id="edit_category" size="modal-lg">
  <x-slot:body>
    <form action="{{route('admin.story.category.create')}}" method="post" id="edit_category_form">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" name="name" id="name_update" class="form-control" />
            <label for="name_update">{{__('app.story.category_feild.name')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
            <input type="text" name="slug" id="slug_update" class="form-control" />
            <label for="slug_update">{{__('app.story.category_feild.slug')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
            <textarea name="short_description" id="short_description_update" class="form-control h-px-100"></textarea>
            <label for="short_description_update">{{__('app.story.category_feild.short_description')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
            <textarea name="description" id="description_update" class="form-control h-px-100"></textarea>
            <label for="description_update">{{__('app.story.category_feild.description')}}</label>
          </div>
        </div>
        
        <div class="col-12 mt-4">
          <div class="form-floating form-floating-outline">
              <select id="parent_id_update" class="form-select select2" name="parent_id">
                  <option value="-1">Danh mục cha (hoặc tác giả)</option>
                  @foreach ($parentCategorys as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
              </select>
            <label for="parent_id_update">{{__('app.story.category_feild.parent')}}</label>
          </div>
        </div>
        
        <div class="col-6 mt-4">
          <div class="text-light small fw-medium mb-3">{{__('app.base.status')}}</div>
          <label class="switch">
            <input type="checkbox" class="switch-input" name="status" id="status_update" />
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('app.base.status')}}</span>
          </label>
        </div>
        
        <div class="col-6 mt-4 ">
          <div class="form-floating form-floating-outline">
              <select id="type_update" class="form-select" name="type">
                  @foreach (App\Models\StoryCategory::TYPE as $type)
                      <option value="{{$type}}">{{$type}}</option>
                  @endforeach
              </select>
              <label for="type_update">{{__('app.base.type')}}</label>
          </div>
        </div>
        
      </div>
    </form>
  </x-slot:body>
  
  <x-slot:footer>
    <button type="submit" class="btn btn-primary" form="edit_category_form">Save changes</button>
  </x-slot:footer>
  
  <x-slot:addScript>
    <script type="module" defer>
      const myModal = new bootstrap.Modal('#edit_category', {
        keyboard: false
      })
      let edited_category = $(".edited_category");
      $(document).ready(function() {
        $(document).on('click', '.edited_category', function() {
          // myModal.show();
          let id =  $(this).data('id');
          window.loadingPage.show();
          window.axios.get(`{{ route('admin.story.category.getOne', ['id' => '__ID__']) }}`.replace('__ID__', id))
            .then(function(response) {
              let data = response.data;
              
              // Đặt giá trị cho các input
              $('#name_update').val(data.name); // Đặt giá trị cho input username
              $('#slug_update').val(data.slug);
              $('#short_description_update').val(data.short_description); // Đặt giá trị cho input email
              $('#description_update').val(data.description); // Đặt giá trị cho input email
              $('#parent_id_update').val(data.parent_id ?? -1).trigger('change');; // Đặt giá trị cho input email
              $('#status_update').prop( "checked", data.status ? true : false ); // Đặt giá trị cho input email
              $('#type_update').val(data.type); // Đặt giá trị cho input email
              $("#edit_category_form").attr('action', `{{ route('admin.story.category.update', ['id' => '__ID__']) }}`.replace('__ID__', data.id));
              window.loadingPage.hide();
              myModal.show();
            }).catch((err) => {
              window.loadingPage.hide();
            })
          
        });
      })

      
    </script>  
  
  </x-slot:addScript>
</x-base.modal>
@endsection

@push('scripts')
<script type="module" defer>
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
</script>
@endpush