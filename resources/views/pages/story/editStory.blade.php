@extends('layouts/layoutMaster')

@section('title', 'Chỉnh sửa truyện')

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
  'resources/assets/vendor/libs/dropzone/dropzone.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite([
])
@endsection


@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  'resources/assets/vendor/libs/dropzone/dropzone.js'
  ])
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script type="module" src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
@endsection

@section('page-script')
@vite([
  'resources/assets/js/forms-selects.js',
  // 'resources/assets/js/forms-tagify.js',
  // 'resources/assets/js/forms-typeahead.js'
])
@endsection

@section('content')
<h4 class="mb-1">Cập nhập truyện</h4>

<div class="nav-align-top mb-6">
  <ul class="nav nav-pills mb-4" role="tablist">
    <li class="nav-item">
      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tab-info" aria-controls="tab-info" aria-selected="true">Thông tin Truyện</button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-list-chapter" aria-controls="tab-list-chapter" aria-selected="false">Danh sách chapter</button>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
      <div class="row">
        <div class="col-md-12">
          <x-base.message></x-base.message>
          <x-base.error></x-base.error>
        </div>
        
        <div class="col-12 mt-4">
          <form action="{{route('admin.story.update', ['id' => $story->id])}}" method="post" id="update_story_form" enctype='multipart/form-data'>
            <input type="hidden" name="story_id" value="{{$story->id}}" id="story_id">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-12 mb-4">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="title" id="title_create" class="form-control" value="{{$story->title}}" />
                  <label for="title_create">{{__('app.base.title')}}</label>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-floating form-floating-outline">
                  <input type="text" value="{{$story->slug}}" name="slug" id="slug_create" class="form-control" />
                  <label for="slug_create">{{__('app.base.slug')}}</label>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-group">
                  {{-- <input type="text" name="description" id="description_create" class="form-control" /> --}}
                  <label for="description_create">{{__('app.base.description')}}</label>
                  <textarea name="description" id="editor" rows="30" cols="100">{{$story->description}}</textarea>
                </div>
              </div>
              
              <div class="col-12 mb-4" >
                <div class="form-floating form-floating-outline">
                  <input type="text" value="{{$story->meta_description}}" name="meta_description" id="meta_description_create" class="form-control" />
                  <label for="meta_description_create">{{__('app.base.meta_description')}}</label>
                </div>
              </div>
              
              <div class="col-6 mb-4">
                <div class="form-floating form-floating-outline">
                    <select id="list_category_create" class="form-select select2" multiple name="list_category[]">
                        @foreach ($categories as $category)
                            <option {{in_array($category->id, $story->list_category) ? "selected": ''}}  value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                  <label for="list_category_create">{{__('app.base.category')}}</label>
                </div>
              </div>
              
              <div class="col-6 mb-4">
                <div class="form-floating form-floating-outline">
                    <select id="author_id_create" class="form-select select2" name="author_id">
                        <option value="-1">--Chọn tác giả--</option>
                        @foreach ($authors as $author)
                            <option {{($author->id == $story->author_id) ? "selected": ''}} value="{{$author->id}}">{{$author->name}}</option>
                        @endforeach
                    </select>
                  <label for="author_id_create">{{__('app.base.author')}}</label>
                </div>
              </div>
              
              <div class="col-6 mb-4" >
                <div class="text-light small fw-medium mb-3">{{__('app.base.status')}}</div>
                <label class="switch">
                  <input type="checkbox"  {{($story->status == 1) ? 'checked': ''}} class="switch-input" name="status" id="status_create" />
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label">{{__('app.base.status')}}</span>
                </label>
              </div>
              
              <div class="col-6 mt-4">
                <div class="form-group">
                  <label for="thumbnail">Image</label>
                  <div class="input-group">
                      <input id="thumbnail" value="{{$story->avatar}}" class="form-control" form="update_story_form" readonly type="text" name="avatar">
                      <span class="input-group-append">
                          <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                              <i class="fa fa-picture-o"></i> Choose
                          </button>
                      </span>
                  </div>
                </div>
                <div id="holder" style="margin-top:15px;max-height:100px;">
                  @if($story->avatar)
                      <img src="{{$story->avatar}}" 
                          alt="Current Image" 
                          style="max-height: 100px;">
                  @endif
                </div>
              </div>
              
            </div>
            
          </form>
        </div>
        
        <div class="col-12 mt-3">
          <button class="btn btn-primary waves-effect waves-light" type="submit" form="update_story_form">{{__("app.base.update")}}</button>
        </div>
      </div>
      
      {{-- end --}}
    </div>
    <div class="tab-pane fade" id="tab-list-chapter" role="tabpanel">
      <div class="row mb-3">
        <div class="col-12">
          @if (Permission::checkPermission('story.create'))
            <a class='btn btn-primary waves-effect waves-light' href="{{route('admin.story.createChapter', ['story_id' => $story->id])}}">
              <i class='ri-add-line me-0 me-sm-1 d-inline-block d-sm-none'></i>
              <span class= 'd-none d-sm-inline-block'> {{__("app.base.create")}} </span >
            </a>
          @endif
        </div>
      </div>
      
      <div class="card-datatable table-responsive">
        @php
          $header = [
            'id',
            __('app.story.title_chapter'),
            __('app.story.slug_chapter'),
            __('app.base.created_at'),
            __('app.story.status_chapter'),
            __('app.base.action'),
          ];    
          $settings = [
            "serverSide" => true,
          ];
        @endphp
        <x-dataTable.dataTable1 id="storyChapterData" :header="$header" route="admin.story.chapter.datatable" :setting="$settings">
          <x-slot:addScript>
            <script type="module">
              let story_id = $("#story_id").val();
              settings_storyChapterData = {
                columns: [
                  { data: 'id', name: 'id' },
                  { data: 'title', name: 'title' },
                  { data: 'slug', name: 'slug' },
                  { data: 'created_at', name: 'created_at' },
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
                    let hrefEditButton = `{{route('admin.story.editChapter', ['chapter_id' => '__ID__', 'story_id' => $story->id])}}`.replace('__ID__', row.id);
                    
                    let editButton = `<a
                            href="${hrefEditButton}" 
                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect edited_category"  title="Edit"><i class="ri-edit-box-line"></i></a>`;
                    
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
              
              params_storyChapterData = (data) => {
                data.story_id = story_id;
                
                return data;
              }
            </script>
          </x-slot:addScript>
        </x-dataTable.dataTable1>
      </div>
    </div>
  </div>
</div>



@endsection


@push('scripts')

<script type="module" defer>
  // Khởi tạo CKEditor cho textarea với ID là 'editor'
  CKEDITOR.replace('editor', {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
    height: '500',
    versionCheck: false,
  });
  
  $('#lfm').filemanager('image');

  $(document).on('click', '.delete-record', function() {
    let id =  $(this).data('id');
    if(confirm("Bạn có đồng ý xóa?")) {
      window.axios.delete(`{{ route('admin.story.deleteChapter', ['id' => '__ID__']) }}`.replace('__ID__', id))
        .then(function(response) {
          alert(`${response.message}`);
          window.storyChapterData_datatable.ajax.reload();
        }).catch((err) => {
          alert(`${err}`);
        })
    }
  })
</script>
@endpush