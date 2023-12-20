@extends('layouts.app')

@section('page_title', 'Add New')

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
    margin-left: 750px;
    margin-top: 17px;
    background: #ed5579;
    border: 0px;
    border-radius: 7px;
}
</style>


<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">

        @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.register') }}" method="post">
            @csrf

            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
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
                                required>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="required form-label">Role</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="role" class="form-control" id="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->



                        <div id="userFields" style="display: none;">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required form-label">Designation</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="designation" class="form-control mb-2"
                                    placeholder="Designation">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required form-label">Department</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="department" class="form-control mb-2" placeholder="Department">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>

                        <button class="save" type="submit">Register</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
