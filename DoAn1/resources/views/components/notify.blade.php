@props(['type' => 'success', 'message' => '', 'show' => false])
@php
    $classes = [
        'success' => 'bg-success',
        'error' => 'bg-danger',
        'warning' => 'bg-warning',
        'info' => 'bg-info',
    ];
    
    $alertClass = $classes[$type] ?? 'bg-success';
@endphp

<div class="toast-container position-fixed top-1 end-0 p-3" style="z-index: 9999;">
    <div class="toast {{ $show ? 'show' : '' }}" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header {{ $alertClass }} text-white">
            <strong class="me-auto">Thông báo</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $message ?: $slot }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 3000
            });
        });
        @if($show)
            toastList.forEach(toast => toast.show());
        @endif
    });
</script>