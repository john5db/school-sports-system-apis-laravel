<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="" name="description">
    <meta content="" name="author">
    <title>Sideline Studios-SFC Talon CMS</title><!-- Bootstrap Core CSS -->
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.partials.header-styles')
</head>
<body class="hold-transition fixed sidebar-mini skin-green">
<div id="wrapper" class="wrapper">
    @include('layouts.partials.header')
    @include('layouts.partials.left-sidebar')
    <div class="content-wrapper">

        @yield('content')

    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.6
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="#">Sports</a>.</strong> All rights
        reserved.
    </footer>

    @include('layouts.partials.master-footer-scripts')
    @yield('footer')
</div>
</body>
</html>
