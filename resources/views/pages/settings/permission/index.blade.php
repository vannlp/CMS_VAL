@extends('layouts/layoutMaster')

@section('title', 'Người dùng')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss',
   'resources/assets/vendor/libs/jstree/jstree.scss'
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
  'resources/assets/vendor/libs/jstree/jstree.js'
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
    <h5 class="card-title mb-0">{{__('app.permission.title')}}</h5>
    <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
      <div class="col-md-4 mb-4">
        @if (Permission::checkPermission('permission.role.create'))
        <button class='btn btn-primary waves-effect waves-light' 
        data-bs-toggle="modal" 
        id="createButton">
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
    
    <div class="card-datatable table-responsive">
      @php
        $header = [
          'id',
          __('app.permission.name'),
          __('app.permission.decription'),
          __('app.base.action'),
        ];    
        $settings = [
          "serverSide" => true,
        ];
      @endphp
      <x-dataTable.dataTable1 id="roleData" :header="$header" route="admin.settings.permission.datatable" :setting="$settings">
        <x-slot:addScript>
          <script type="module">
            settings_roleData = {
              columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { title: "action", render(data, type, row) {
                  let deleteButton = `<button 
                    data-id="${row.id}"
                    href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect delete-record" data-bs-toggle="tooltip" title="Delete"><i class="ri-delete-bin-7-line ri-20px"></i></button>`;
                  
                  let editButton = `<button
                          data-id="${row.id}"
                          href="javascript:;" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect edited_role" data-bs-toggle="tooltip" title="Edit"><i class="ri-edit-box-line"></i></button>`;
                  
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
            
            params_roleData = {
              h: 123
            }
          </script>
        </x-slot:addScript>
      </x-dataTable.dataTable1>
  </div>
  
  {{-- Create Modal --}}
  <x-base.modal title="{{__('app.permission.create_permission')}}" id="create_permission" size="modal-lg">
    <x-slot:body>
      <form action="{{route('admin.settings.role.createRole')}}" method="post" id="create_role_form">
        @csrf
        <input type="hidden" name="type" id="typeAction" value="create">
        
        <div class="row">
          <div class="col-12 mb-4">
            <div class="form-floating form-floating-outline">
              <input type="text" name="name" id="role_name" class="form-control" />
              <label for="role_name">Vai trò</label>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12 mb-4">
            <div class="form-floating form-floating-outline">
              <input type="text" name="description" id="role_description" class="form-control" />
              <label for="role_description">Mô tả</label>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12 mb-4">
            <h5 class="mb-6">Role Permissions</h5>
            <input type="hidden" id="list_role_code" name="permissions">
            <div class="col-md-12 col-12">
              <div class="card mb-md-0 mb-6">
                <h5 class="card-header">Checkboxes</h5>
                <div class="card-body">
                  <div id="jstree-checkbox"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </x-slot:body>
    
    <x-slot:footer>
      <button type="submit" class="btn btn-primary" form="create_role_form">Save changes</button>
    </x-slot:footer>
    
    <x-slot:addScript>
      <script type="module" defer>
        var jstreeCheckbox = $("#jstree-checkbox");
        const createUpdatePermissionModal = new bootstrap.Modal('#create_permission', {
          keyboard: false
        })
        var dataJStree = [];
        const edited_role = $(".edited_role");
        const typeAction = $("#typeAction");
        const role_name = $("#role_name");
        const role_description = $("#role_description");
        
        var theme = $('html').hasClass('light-style') ? 'default' : 'default-dark';
        let form = $("#create_role_form");
        let permissionInput = $("#list_role_code");
        const createButton = $("#createButton");
        
        if (jstreeCheckbox.length) {
          window.axios.get(`{{route('admin.settings.permission.getPermissionByUser')}}`)
            .then(function(res) {
              let resCustom = res.data;
              const groupedData = [];

              // Lặp qua từng phần tử trong object data
              for (const code in resCustom) {
                const item = resCustom[code];
                item.text = item.name;
                item.id = item.code;
                // Nếu type là 'group' thì thêm vào groupedData và tạo mảng children rỗng
                if (item.type === 'group') {
                  groupedData[code] = { ...item, children: [] };
                }
              }
              
              // Lặp qua từng phần tử trong object data
              for (const code in resCustom) {
                const item = resCustom[code];
                item.text = item.name;
                item.id = item.code;
                // Nếu type không phải 'group'
                if (item.type !== 'group') {
                  // Lặp qua từng nhóm trong groupedData
                  for (const groupCode in groupedData) {
                    // Nếu code bắt đầu bằng groupCode + '.' thì thêm vào children của nhóm đó
                    if (code.startsWith(groupCode + '.')) {
                      groupedData[groupCode].children.push(item);
                    }
                  }
                }
              }
              
              let i = 0;
              
              for(const item in groupedData) {
                let itemData = groupedData[item];
                itemData.state = {
                  opened: true
                };
                dataJStree[i] = itemData;
                i++;
              }
              
              jstreeCheckbox.jstree({
                core: {
                  themes: {
                    name: theme
                  },
                  data: dataJStree
                },
                plugins: ['types', 'checkbox', 'wholerow'],
                types: {
                  default: {
                    icon: 'ri-folder-3-line'
                  },
                  html: {
                    icon: 'ri-html5-fill text-danger'
                  },
                  css: {
                    icon: 'ri-css3-fill text-info'
                  },
                  img: {
                    icon: 'ri-image-fill text-success'
                  },
                  js: {
                    icon: 'ri-javascript-line text-warning'
                  }
                }
              });
              // Hiển thị kết quả
            }).catch((err) => {
            })
          
          
        }
        
        $(document).on('click', '.edited_role', function() {
          typeAction.val('update');
          var id =  $(this).data('id');
          window.loadingPage.show();
          window.axios.get(`{{ route('admin.settings.role.getRole', ['id' => '__ID__']) }}`.replace('__ID__', id))
            .then(function(response) {
              let data = response.data;
              let permissions = data.permissions;
              jstreeCheckbox.jstree('uncheck_all');
              // convert data jstree
              
              role_name.val(data.name);
              role_description.val(data.description);
              window.loadingPage.hide();
              form.attr('action', `{{ route('admin.settings.role.updateRole', ['id' => '__ID__']) }}`.replace('__ID__', id));
              createUpdatePermissionModal.show();
              $.each(permissions, function(index, id) {
                  jstreeCheckbox.jstree('check_node', id);
              });
            }).catch((err) => {
              window.loadingPage.hide();
            })
        });
        
        createButton.click(function() {
          typeAction.val('create');
          role_name.val("");
          role_description.val("");
          form.attr('action', "{{route('admin.settings.role.createRole')}}");
          let createJSTree = dataJStree;
          
          jstreeCheckbox.jstree('uncheck_all');
          createUpdatePermissionModal.show();
        });
        
        // Xử lý sự kiện submit form
        form.on('submit', function (e) {
          e.preventDefault(); // Ngăn chặn form submit mặc định
          var selectedElmsIds = [];
          var selectedElms = jstreeCheckbox.jstree("get_selected", true);
          $.each(selectedElms, function() {
              selectedElmsIds.push(this.id);
          });
          // Thêm dữ liệu vào ô input
          permissionInput.val(JSON.stringify(selectedElmsIds));
          // Submit form
          this.submit();
        });
      
      </script>
    </x-slot:addScript>
  </x-base.modal>
  </div>
</div>

@endsection