@extends('layouts/layoutMaster')

@section('title', 'Thêm mới truyện')

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
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet">
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
<script type="module" src="https://unpkg.com/cropperjs/dist/cropper.js"></script>
@endsection

@section('page-script')
@vite([
  'resources/assets/js/forms-selects.js',
  // 'resources/assets/js/forms-tagify.js',
  // 'resources/assets/js/forms-typeahead.js'
])
@endsection

@section('content')
<h4 class="mb-1">Thêm mới truyện</h4>

<div class="card">
    <div class="card-header">
      <h5 class="card-tile mb-0">Story information</h5> 
      <div class="row">
        <div class="col-md-12">
          <x-base.message></x-base.message>
          <x-base.error></x-base.error>
        </div>
      </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.story.store')}}" method="post" id="create_story_form" enctype='multipart/form-data'>
            @csrf
            <div class="row">
              <div class="col-12 mb-4">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="title" id="title_create" class="form-control" />
                  <label for="title_create">{{__('app.base.title')}}</label>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="slug" id="slug_create" class="form-control" />
                  <label for="slug_create">{{__('app.base.slug')}}</label>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-group">
                  {{-- <input type="text" name="description" id="description_create" class="form-control" /> --}}
                  <label for="description_create">{{__('app.base.description')}}</label>
                  <textarea name="description" id="editor" rows="30" cols="100"></textarea>
                </div>
              </div>
              
              <div class="col-6 mb-4">
                <div class="form-floating form-floating-outline">
                    <select id="list_category_create" class="form-select select2" multiple name="list_category[]">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                  <label for="list_category_create">{{__('app.base.category')}}</label>
                </div>
              </div>
              
              <div class="col-6 mb-5 border p-3 rounded">
                <div >
                    <label for="author_id_create">{{__('app.base.author')}}</label>
                    <div id="author_option_checked">
                      <div class="form-check mt-4">
                        <input
                          name="author_option"
                          class="form-check-input"
                          type="radio"
                          value="0"
                          id="author_option_tu_nhap" />
                        <label class="form-check-label" for="author_option_tu_nhap"> Tự nhập </label>
                      </div>
                      <div class="form-check">
                        <input
                          name="author_option"
                          class="form-check-input"
                          type="radio"
                          value="1"
                          id="author_option_select"
                          checked />
                        <label class="form-check-label" for="author_option_select"> Chọn Tác giả có sẵn </label>
                      </div>
                    </div>
                    
                    <div id="author_option_content">
                      <input type="text" id="author_name" class="form-control" name="author_name" placeholder="Nhập tên tác giả">
                      
                      <select id="author_id_create" class="form-select select2" name="author_id">
                        <option value="-1">--Chọn tác giả--</option>
                        @foreach ($authors as $author)
                          <option value="{{$author->id}}">{{$author->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    
                </div>
              </div>
              
              <div class="col-6 mb-4" >
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
              
              <div class="col-6 mb-4" >
                <div class="form-floating form-floating-outline">
                  <input type="text" name="meta_description" id="meta_description_create" class="form-control" />
                  <label for="meta_description_create">{{__('app.base.meta_description')}}</label>
                </div>
              </div>
            </div>
            
        </form>
    </div>
</div>
  
<div class="card mt-4">
  <div class="card-header">
    <h5 class="card-tile mb-0">Ảnh dại diện</h5> 
  </div>
  
  <div class="card-body">
    {{-- <div class="row">
      <div class="col-12 mb-4" >
        <form action="/upload" class="dropzone needsclick" id="dropzone-basic-test">
          <div class="dz-message needsclick my-12">
            <div class="d-flex justify-content-center">
              <div class="avatar">
                <span class="avatar-initial rounded-3 bg-label-secondary">
                  <i class="ri-upload-2-line ri-24px"></i>
                </span>
              </div>
            </div>
            <p class="h4 needsclick my-2">Drag and drop your image here</p>
            <small class="note text-muted d-block fs-6 my-2">or</small>
            <span class="needsclick btn btn-sm btn-outline-primary" id="btnBrowse">Browse image</span>
          </div>
          <div class="fallback">
            <input name="avatar" type="file" form="create_story_form" id="avatar_input" />
          </div>
        </form>
      </div>
    </div> --}}
    <div class="row">
      <div class="col-6">
        <div class="form-group">
          <label for="thumbnail">Image</label>
          <div class="input-group">
              <input id="thumbnail" class="form-control" form="create_story_form" readonly type="text" name="avatar">
              <span class="input-group-append">
                  <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Choose
                  </button>
              </span>
          </div>
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>

      </div>
      
      {{-- <div class="col-6">
        <input type="file" id="imageInput" accept="image/*">
        <div id="imageContainer">
            <img id="image" src="" style="max-width: 100%;" />
        </div>
        <button id="cropButton">Cắt và Lưu</button>
      </div> --}}
    </div>
    
  
  </div>
    
</div>

<div class="card mt-4">
  <div class="card-body">
    <div class="row mt-3">
      <div class="col-12">
        <button class="btn btn-primary waves-effect waves-light" type="submit" form="create_story_form">{{__("app.base.create")}}</button>
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
  
  const previewTemplate = `<div class="dz-preview dz-file-preview">
    <div class="dz-details">
      <div class="dz-thumbnail">
        <img data-dz-thumbnail>
        <span class="dz-nopreview">No preview</span>
        <div class="dz-success-mark"></div>
        <div class="dz-error-mark"></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="progress">
          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
        </div>
      </div>
      <div class="dz-filename" data-dz-name></div>
      <div class="dz-size" data-dz-size></div>
    </div>
    </div>`;
  
  $('#lfm').filemanager('image');
  
  // Ghi đè callback mặc định của filemanager
  $(document).ready(function() {
    let author_option = $('input[name="author_option"]:checked').val() ?? 1;
  
    function changeOptionAuthor(author_option = 1) {
      const author_name = $("#author_name");
      const author_id = $("#author_id_create") ;
      
      if(author_option == 1) {
        author_name.css('display', 'none');
        author_id.select2().next().show();
      } else {
        author_name.css('display', 'block');
        author_id.select2().next().hide();
      }
    }
    
    changeOptionAuthor(author_option);
    
    $('input[name="author_option"]').change(function() {
      let author_option = $('input[name="author_option"]:checked').val() ?? 1;
    
      changeOptionAuthor(author_option);
    });
  })
  
  
</script>
@endpush