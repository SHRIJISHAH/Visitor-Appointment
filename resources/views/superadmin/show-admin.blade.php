@extends('layouts.app')

@section('page_title', 'View Admin Data')

@section('content')

@include('layouts.admin_sidebar')
<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="readonly form-label">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control mb-2" placeholder="Name"
                                value="{{ $admin->name }}" readonly>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="readonly form-label">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email"
                                value="{{ $admin->email }}" readonly>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="readonly form-label">Mobile Number</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="tel" name="mobile_no" class="form-control mb-2" placeholder="Mobile no"
                                value="{{ $admin->mobile_no }}" readonly>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

        <a href="{{ route('superadmin.manage-admins') }}">Back to Admins</a>
    </div>
@endsection
