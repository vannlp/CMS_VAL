@extends('layouts/layoutMaster')

@section('title', 'Chỉnh sửa chapter')

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
{{-- <script type="module" src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
@endsection

@section('page-script')
@vite([
  'resources/assets/js/forms-selects.js',
  // 'resources/assets/js/forms-tagify.js',
  // 'resources/assets/js/forms-typeahead.js'
])
@endsection

@section('content')
<h4 class="mb-1">Chỉnh sửa chapter</h4>

<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-12 pb-1">
            <p>
                Tên Truyện: <a href="{{route('admin.story.edit', ['id' => $story->id])}}" class="fw-bolder">{{$story->title}}</a>
            </p>
        </div>
        <div class="col-md-12">
          <x-base.message></x-base.message>
          <x-base.error></x-base.error>
        </div>
      </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.story.updateChapter', ['id' => $chapter->id]) }}" method="post" id="update_storyChapter_form" >
            @csrf
            @method('PUT')
            <input type="hidden" value="{{$story->id}}" name="story_id">
            <div class="row">
              <div class="col-12 mb-4">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="title" id="title_create" class="form-control" value="{{$chapter->title}}" />
                  <label for="title_create">{{__('app.base.title')}}</label>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="slug" id="slug_create" value="{{$chapter->slug}}" class="form-control" />
                  <label for="slug_create">{{__('app.base.slug')}}</label>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-group">
                  {{-- <input type="text" name="description" id="description_create" class="form-control" /> --}}
                  <label for="description_create">{{__('app.base.description')}}</label>
                  <textarea name="description" id="editor" rows="30" cols="100">{{$chapter->description}}</textarea>
                </div>
              </div>
              
              <div class="col-6 mb-4" >
                <div class="text-light small fw-medium mb-3">{{__('app.base.status')}}</div>
                <label class="switch">
                  <input type="checkbox"  {{($chapter->status == 1) ? 'checked': ''}} class="switch-input" name="status" id="status_create" />
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label">{{__('app.base.status')}}</span>
                </label>
              </div>
              
              <div class="col-6 mb-4" >
                <div class="form-floating form-floating-outline">
                  <input type="number" name="chapter_num" value="{{$chapter->chapter_num}}" id="chapter_num" class="form-control" />
                  <label for="chapter_num">{{__('app.story.chapter_number')}}</label>
                </div>
              </div>
              
              <div class="col-6 mb-4" >
                <div class="form-floating form-floating-outline">
                  <input type="text" name="meta_description" id="meta_description_create" value="{{$chapter->meta_description}}" class="form-control" />
                  <label for="meta_description_create">{{__('app.base.meta_description')}}</label>
                </div>
              </div>
            </div>
            
        </form>
    </div>
</div>

<div class="card mt-4">
  <div class="card-body">
    <div class="row mt-3">
      <div class="col-12">
        <button class="btn btn-primary waves-effect waves-light" type="submit" form="update_storyChapter_form">{{__("app.base.update")}}</button>
      </div>
    </div>
  </div>
</div>

@endsection


@push('scripts')

<script type="module" defer>
    CKEDITOR.editorConfig = function( config ) {
        config.versionCheck = false;
    };
  // Khởi tạo CKEditor cho textarea với ID là 'editor'
  CKEDITOR.replace('editor', {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
    height: '500',
    versionCheck: false,
  });
</script>
@endpush