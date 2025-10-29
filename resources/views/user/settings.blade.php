@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <h4 class="fw-bold">Account Setting</h4>
        <hr class="my-3">

        <form action="#">
            
            <div class="mt-4">
                <h6 class="fw-bold">Contact Email</h6>
                <p class="text-muted small">Email ini untuk pemberitahuan invoice pemesanan.</p>

                <div class="row align-items-end mt-3">
                    <div class="col-lg-9 col-12">
                        <p class="form-minimal-static mb-0">thierrywidyatama12@gmail.com</p>
                    </div>
                    <div class="col-lg-3 col-12 text-lg-end mt-3 mt-lg-0">
                        <button type="button" class="btn btn-brand btn-sm w-100 w-lg-auto">Change email</button>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h6 class="fw-bold">Password</h6>
                <p class="text-muted small">Change your current password.</p>

                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <label for="current_password" class="form-minimal-label">Current Password</label>
                        <input type="password" class="form-control form-minimal-input" id="current_password" value="thierrywidyatama12@gmail.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="new_password" class="form-minimal-label">New Password</label>
                        <input type="password" class="form-control form-minimal-input" id="new_password" placeholder="Enter new password">
                    </div>
                </div>
            </div>

            <div class="text-start mt-4">
                <button type="submit" class="btn btn-brand">Change Password</button>
            </div>

        </form>

    </div>
</div>

@endsection