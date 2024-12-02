<!DOCTYPE html>
<!-- saved from url=(0021)https://suustore.com/ -->
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap CSS v5.2.1 -->

    <link href="{{asset('/FE/assets/bootstrap.min.css')}}" rel="stylesheet">

    <link rel="shortcut icon" href="https://suustore.com/assets/frontend/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('/FE/assets/app.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.8/axios.min.js" integrity="sha512-v8+bPcpk4Sj7CKB11+gK/FnsbgQ15jTwZamnBf/xDmiQDcgOIYufBo6Acu1y30vrk8gg5su4x0CG3zfPaq5Fcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        window.SuuTruyen = {
            baseUrl: "{{url('/')}}",
            urlCurrent: "{{url('/')}}",
            csrfToken: "{{ csrf_token() }}"
        }
    </script>

    <title>@yield('title', 'Truyện chữ online')</title>
    <meta name="description"
        content="@yield('meta_description', 'Mô tả truyện chữ online')">
        
    @stack('styles')
</head>

<body>
    @include('FE.layouts.header')
    
    @yield('content')

    @include('FE.layouts.footer')  

    <script src="{{asset('/FE/assets/jquery.min.js')}}">
    </script>

    <script src="{{asset('/FE/assets/popper.min.js')}}">
    </script>

    <script src="{{asset('/FE/assets/bootstrap.min.js')}}">
    </script>



    <script src="{{asset('/FE/assets/app.js')}}">
    </script>
    <script src="{{asset('/FE/assets/common.js')}}"></script>


    <div id="loadingPage" class="loading-full">
        <div class="loading-full_icon">
            <div class="spinner-grow"><span class="visually-hidden">Loading...</span></div>
        </div>
    </div>

    @stack('scripts')

</body>

</html>