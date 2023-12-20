<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1" style="margin-left: 300px;">
            <span class="text-muted fw-semibold me-1">2023&copy;</span>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                @if (auth()->check() && auth()->user()->footer)
                    {!! auth()->user()->footer !!}
                @else
                    <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                @endif
            </li>
        </ul>
    </div>
    <!--end::Footer container-->
</div>
<!--end::Footer-->
