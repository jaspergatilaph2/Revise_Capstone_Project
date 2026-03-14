@extends('layouts.app-dashboard')
@section('content')
    <div class="container-xxl container-p-y d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="misc-wrapper text-center">
            <h2 class="mb-2 mx-2">Under Maintenance!</h2>
            <p class="mb-4 mx-2">
                Sorry for the inconvenience but we're performing major update at the moment,
                we'll be back! Thank you for your patience.
            </p>
            <a href="{{ route('applicants.dashboard') }}" class="btn btn-primary">Back to home</a>

            <div class="mt-4">
                <img src="{{ asset('sneat/img/illustrations/girl-doing-yoga-light.png') }}" alt="girl-doing-yoga-light"
                    width="500" class="img-fluid" data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                    data-app-light-img="illustrations/girl-doing-yoga-light.png" />
            </div>
        </div>
    </div>
@endsection