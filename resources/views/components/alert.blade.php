@push('scripts')
    @if (session('success'))
        <script type="module">
            swalSuccess('{{ session('success') }}')
        </script>
    @endif
    @if (session('danger'))
        <script type="module">
            swalError('{{ session('danger') }}')
        </script>
    @endif
@endpush

@php

@endphp
