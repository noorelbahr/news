<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News App</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        @include('partials.navbar')

        @include('partials.sidebar')

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="m-0">News Apps</h3>
                        </div>
                        <div class="col-sm-6">
                            <news-create-button></news-create-button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content">
                <router-view></router-view>
            </div>

        </div>

        @include('partials.footer')

    </div>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
