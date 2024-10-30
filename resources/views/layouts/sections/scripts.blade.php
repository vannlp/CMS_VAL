<!-- BEGIN: Vendor JS-->

@vite([
  'resources/assets/vendor/libs/jquery/jquery.js',
  'resources/assets/vendor/libs/popper/popper.js',
  'resources/assets/vendor/js/bootstrap.js',
  'resources/assets/vendor/libs/node-waves/node-waves.js',
  'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
  'resources/assets/vendor/libs/hammer/hammer.js',
  'resources/assets/vendor/libs/typeahead-js/typeahead.js',
  'resources/assets/vendor/js/menu.js'
])

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/main.js'])
@vite(['resources/js/app.js'])
<script type="module">
  window.baseUrl = "{{url('/')}}";
  window.axios.get("{{asset('/lang/vi.json')}}", )
    .then(function(response) {
        window.lang = response;
      
    }).catch((err) => {
    })
</script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->

{{-- var global --}}
<script type="module">
  var loadingPage = {
    loadingPageElement: $(".loading-page"),
    show: function() {
      this.loadingPageElement.addClass('active')
    },
    hide: function() {
      this.loadingPageElement.removeClass('active')
    }
  };

  // Gán biến vào global scope (window)
  window.loadingPage = loadingPage;
  
</script>
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

@stack('scripts')
