@extends('layouts.app')
@section('content')
    @php
        use App\Models\Maintenance;

        $maintenance = Maintenance::first();

        $department = $maintenance->department ?? 'MPDO';

        // Format for display (HUMAN READABLE)
        $finishAtFormatted = ($maintenance && $maintenance->finish_at)
            ? \Carbon\Carbon::parse($maintenance->finish_at)->format('F d, Y h:i A')
            : 'Not set';

        // Format for JS countdown (ISO FORMAT - IMPORTANT)
        $finishAtISO = ($maintenance && $maintenance->finish_at)
            ? \Carbon\Carbon::parse($maintenance->finish_at)->toIso8601String()
            : '';

        // Format tab name
        $targetTab = $maintenance->target_tab ?? null;
        $formattedTab = $targetTab
            ? ucwords(str_replace('_', ' ', $targetTab))
            : 'Not specified';
    @endphp

    <div class="container-xxl container-p-y d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="misc-wrapper text-center">

            <h2 class="mb-2 mx-2">Under Maintenance!</h2>

            <p class="mb-4 mx-2">
                Sorry for the inconvenience but we're performing major updates at the moment.
            </p>

            <!-- Department -->
            <p class="mb-2">
                <strong>Department Under Development:</strong> {{ $department }}
            </p>

            <!-- Affected Tab (NO BADGE) -->
            <p class="mb-2">
                <strong>Affected Section:</strong> {{ $formattedTab }}
            </p>

            <!-- Expected Finish -->
            <p class="mb-2">
                <strong>Expected Finish:</strong>
                <span id="finishTimeDisplay">
                    {{ $finishAtFormatted }}
                </span>
            </p>

            <!-- Countdown -->
            <p class="mb-2">
                <strong>Time Remaining:</strong>
                <span id="countdown" data-finish="{{ $finishAtISO }}"></span>
            </p>

            <a href="{{ route('mpdo.dashboard') }}" class="btn btn-primary mb-4">
                Back to Home
            </a>

            <div>
                <img src="{{ asset('sneat/img/illustrations/girl-doing-yoga-light.png') }}" alt="girl-doing-yoga-light"
                    width="500" class="img-fluid" data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                    data-app-light-img="illustrations/girl-doing-yoga-light.png" />
            </div>

        </div>
    </div>

@endsection