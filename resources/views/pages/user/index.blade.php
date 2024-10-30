@extends('layouts/layoutMaster')

@section('title', 'Người dùng')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss',
 
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
  
  ])
@endsection

@section('page-script')
{{-- @vite('resources/assets/js/dashboards-crm.js') --}}
{{-- @vite(['resources/assets/js/form-validation.js']) --}}
@endsection

@section('content')
<div class="row g-6 mb-6">
    
</div>

<!-- Users List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">{{__("app.user.title")}}</h5>
    <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
      <div class="col-md-4 mb-4">
        @if (Permission::checkPermission('user.create'))
        <button class='btn btn-primary waves-effect waves-light' 
        data-bs-toggle="modal" 
        data-bs-target='#create_user'>
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
          __('app.base.username'),
          __('app.base.name'),
          __('app.base.status'),
          __('app.base.email'),
          __('app.base.role'),
          __('app.base.action'),
        ];    
        $settings = [
          "serverSide" => true,
        ];
      @endphp
      <x-dataTable.dataTable1 id="userData" :header="$header" route="admin.user.datatable" :setting="$settings">
        <x-slot:addScript>
          <script type="module">
            settings_userData = {
              columns: [
                { data: 'id', name: 'id' },
                { data: 'username', name: 'username' },
                { data: 'name', name: 'name' },
                { data: 'status', name: 'status', render: function(data, type, row) {
                    let html = '';
                    if(data == 1) {
                        html = `<span class="badge rounded-pill bg-label-success" text-capitalized="">{{__('app.base.active')}}</span>`;
                    }else{
                        html = `<span class="badge rounded-pill bg-label-danger" text-capitalized="">{{__('app.base.inactive')}}</span>`;
                    }
                    return html;
                }, },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { title: "action", render(data, type, row) {
                  let deleteButton = `<button 
                    data-id="${row.id}"
                    href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect delete-record" data-bs-toggle="tooltip" title="Delete"><i class="ri-delete-bin-7-line ri-20px"></i></button>`;
                  
                  let editButton = `<button
                          data-id="${row.id}"
                          href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect edited_user" data-bs-toggle="tooltip" title="Edit"><i class="ri-edit-box-line"></i></button>`;
                  
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
            
            params_userData = {
              h: 123
            }
          </script>
        </x-slot:addScript>
      </x-dataTable.dataTable1>
  </div>
</div>


{{-- Modal --}}
{{-- Edit Modal --}}
<x-base.modal title="{{__('app.user.edit_user')}}" id="edit_user" size="modal-lg">
  <x-slot:body>
    <form action="{{url('admin/user/update')}}" method="post" id="edit_user_form">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" id="username" class="form-control" readonly />
            <label for="username">UserName</label>
          </div>
        </div>
        <div class="col-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" name="name" id="name" class="form-control" />
            <label for="name">Name</label>
          </div>
        </div>
      </div>
      <div class="row g-4">
        <div class="col mb-2">
          <div class="form-floating form-floating-outline">
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="xxxx@xxx.xx" />
            <label for="email">Email</label>
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-floating form-floating-outline">
            <select class="form-select" id="role_id" name="role_id" aria-label="">
              @foreach ($roles as $role)
                  <option value="{{$role->id}}">{{$role->name}}</option>
              @endforeach
            </select>
            <label for="role_id">Role</label>
          </div>
        </div>
      </div>
      
      <div class="row g-4">
        <div class="col mb-2">
          <div class="form-floating form-floating-outline">
            <input
              type="password"
              class="form-control"
              id="new_password"
              name="new_password"
              placeholder="{{__('app.base.new_password')}}" />
            <label for="new_password">{{__('app.base.new_password')}}</label>
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-floating form-floating-outline">
            <input
              type="password"
              class="form-control"
              id="re_new_password"
              name="re_new_password"
              placeholder="{{__('app.base.re_new_password')}}" />
            <label for="re_new_password">{{__('app.base.re_new_password')}}</label>
          </div>
        </div>
      </div>
      
      <div class="row g-4">
        <div class="col-sm-6 p-6 pt-0">
          <div class="text-light small fw-medium mb-4">{{__('app.base.status')}}</div>
          <label class="switch">
            <input type="checkbox" class="switch-input" name="status" id="status" />
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('app.base.status')}}</span>
          </label>
        </div>
      </div>
    </form>
  </x-slot:body>
  
  <x-slot:footer>
    <button type="submit" class="btn btn-primary" form="edit_user_form">Save changes</button>
  </x-slot:footer>
  
  <x-slot:addScript>
    <script type="module" defer>
      const myModal = new bootstrap.Modal('#edit_user', {
        keyboard: false
      })
      let edited_user = $(".edited_user");
      $(document).ready(function() {
        $(document).on('click', '.edited_user', function() {
          // myModal.show();
          let id =  $(this).data('id');
          window.loadingPage.show();
          window.axios.get(`{{url('admin/user/get-one')}}/${id}`)
            .then(function(response) {
              let data = response.data;
              
              // Đặt giá trị cho các input
              $('#username').val(data.username); // Đặt giá trị cho input username
              $('#name').val(data.name);
              $('#email').val(data.email); // Đặt giá trị cho input email
              $('#status').prop( "checked", data.status ? true : false ); // Đặt giá trị cho input email
              $("#edit_user_form").attr('action', `{{ route('admin.user.update', ['id' => '__ID__']) }}`.replace('__ID__', data.id));
              let role_id_selected = $('#role_id');
              role_id_selected.val(data.role_id);
              window.loadingPage.hide();
              myModal.show();
            }).catch((err) => {
              window.loadingPage.hide();
            })
          
        });
        
        $(document).on('click', '.delete-record', function() {
          let id =  $(this).data('id');
          if(confirm("Bạn có đồng ý xóa?")) {
            window.axios.delete(`{{url('admin/user/delete')}}/${id}`)
              .then(function(response) {
                alert(`${response.message}`);
                window.userData_datatable.ajax.reload();
              }).catch((err) => {
                alert(`${err}`);
              })
          }
        })
      })

      
    </script>  
  
  </x-slot:addScript>
</x-base.modal>

{{-- Create Modal --}}
<x-base.modal title="{{__('app.user.create_user')}}" id="create_user" size="modal-lg">
  <x-slot:body>
    <form action="{{route('admin.user.create')}}" method="post" id="create_user_form">
      @csrf
      <div class="row">
        <div class="col-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" name="username" id="username_create" class="form-control" />
            <label for="username_create">UserName</label>
          </div>
        </div>
        <div class="col-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" name="name" id="name_create" class="form-control" />
            <label for="name_create">Name</label>
          </div>
        </div>
      </div>
      <div class="row g-4">
        <div class="col mb-2">
          <div class="form-floating form-floating-outline">
            <input
              type="email"
              class="form-control"
              id="email_create"
              name="email"
              placeholder="xxxx@xxx.xx" />
            <label for="email_create">Email</label>
          </div>
        </div>
        <div class="col mb-2">
          <div class="form-floating form-floating-outline">
            <select class="form-select" id="role_id_create" name="role_id" aria-label="">
              @foreach ($roles as $role)
                  <option value="{{$role->id}}">{{$role->name}}</option>
              @endforeach
            </select>
            <label for="role_id_create">Role</label>
          </div>
        </div>
      </div>
      
      <div class="row g-4 mb-2">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="{{__('app.base.password')}}" />
            <label for="password">{{__('app.base.password')}}</label>
          </div>
        </div>
      </div>
      
      <div class="row g-4">
        <div class="col-sm-6 p-6 pt-0">
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
      </div>
    </form>
  </x-slot:body>
  
  <x-slot:footer>
    <button type="submit" class="btn btn-primary" form="create_user_form">Save changes</button>
  </x-slot:footer>
  
</x-base.modal>

@endsection