<style>
    button {
        margin-left: 700px;
        margin-top: 15px;
        background: #ed5579;
        font-family: 'Noto Sans', sans-serif;
        border: 0px;
        border-radius: 3px;
        text-align: center;
        color: #ffffff;
    }
</style>

<div id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">

        <div class="text-end">

            @auth('admin')
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
            @endauth

            @auth('superadmin')
            <form id="logout-form" action="{{ route('superadmin.logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
            @endauth

        </div>

        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
