@extends('base')

@section('title', 'Music Box Player')

@push('scripts')
    <script>
        window.MAILER_CONFIGURED = @json(mailer_configured());
    </script>
    @vite(['resources/assets/js/app.ts'])
@endpush
