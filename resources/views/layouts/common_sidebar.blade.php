<div id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
     data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
     data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
     data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!-- Common Logo Content -->
        <img src="{{ asset('img/logo.png') }}" class="h-50px " alt="Custom Logo">
    </div>
    <!--end::Logo-->

    <!--begin::Sidebar toggle-->
    <div id="kt_app_sidebar_toggle"
         class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
         data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
         data-kt-toggle-name="app-sidebar-minimize">
        <!-- Common Sidebar Toggle Content -->
        <i class="ki-duotone ki-double-left fs-2 rotate-180">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Sidebar toggle-->

    <!-- Dynamic Sidebar Content Based on User Type -->
    @if(auth()->guard('admin')->check())
        @include('layouts.admin_sidebar')
    @elseif(auth()->guard('superadmin')->check())
        @include('layouts.superadmin_sidebar')
    @endif

</div>
