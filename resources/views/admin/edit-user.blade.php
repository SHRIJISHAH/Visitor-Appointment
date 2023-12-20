@extends('layouts.app')

@section('page_title', 'Edit User')

@section('content')

@include('layouts.sidebar')

<style>
.save{
    font-family: 'Noto Sans', sans-serif;
    font-size: 16px;
    font-weight: 500;
    line-height: 10px;
    letter-spacing: 0px;
    text-align: center;
    color: #ffffff;
    width: 150px;
    height: 40px;
    margin-top: 17px;
    background: #ed5579;
    border: 0px;
    border-radius: 7px;
}
</style>

        <form method="POST" action="{{ route('admin.update-user', ['id' => $user->id]) }}">
            @csrf

            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">


                    <!--begin::Card header-->
                    <!-- <div class="card-header">
                        <div class="card-title">
                            <h2>Edit User</h2>
                        </div>
                    </div> -->
                    <!--end::Card header-->


                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control mb-2" placeholder="Name"
                                value="{{ $user->name }}" required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email"
                                value="{{ $user->email }}" required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Mobile Number</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="tel" name="mobile_no" class="form-control mb-2" placeholder="Mobile no"
                                value="{{ $user->mobile_no }}" required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Designation</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="designation" class="form-control mb-2" placeholder="Designation"
                                value="{{ $user->designation }}" required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Department</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="department" class="form-control mb-2" placeholder="Department"
                                value="{{ $user->department }}" required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_category_submit" class="btn save">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                </div>
            </div>
        </form>

@endsection
