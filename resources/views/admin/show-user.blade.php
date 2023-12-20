@extends('layouts.app')

@section('page_title', 'View User Data')

@section('content')

@include('layouts.sidebar')
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
                                value="{{ $user->name }}" readonly>
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
                                value="{{ $user->email }}" readonly>
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
                                value="{{ $user->mobile_no }}" readonly>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="readonly form-label">Designation</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="designation" class="form-control mb-2" placeholder="Designation"
                                value="{{ $user->designation }}" readonly>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="readonly form-label">Department</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="department" class="form-control mb-2" placeholder="Department"
                                value="{{ $user->department }}" readonly>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group--
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Mobile Number: {{ $user->mobile_no }}</p>
    <p>Designation: {{ $user->designation }}</p>
    <p>Department: {{ $user->department }}</p>

@endsection
