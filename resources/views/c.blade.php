<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>

    <link href="{{ asset('/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

</head>
<!--end::Head-->
<!--begin::Body-->


<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->

                @include('layouts.sidebar')

                <a href="{{ route('admin.register.form') }}" class="btn btn-primary">Add New Admin</a>

                <a href="{{ route('admin.add-user.form') }}" class="btn btn-success">Add New User</a>

                <!-- <a href="{{ route('admin.show-all-users') }}" class="btn btn-info">Show All Users</a> -->

                <a href="{{ route('admin.all-appointments') }}" class="btn btn-info">Show All Appointments</a>

                <a href="{{ route('admin.manage-users') }}" class="btn btn-warning">Manage Users</a>

                @if(isset($registeringAdmin) && $registeringAdmin)
                @include('admin.register')
                @endif

                @if(isset($addingUser) && $addingUser)
                @include('admin.add-user')
                @endif

                @if(isset($showAllUsers) && $showAllUsers)
                @include('admin.show-all-users')
                @endif

                @if(isset($manageUsers) && $manageUsers)
                @include('admin.manage-users')
                @endif

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>

</body>
<!--end::Body-->

</html>
