@props(['type' => 'info', 'message'])

@php
    $classes = [
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'error' => 'bg-red-100 border-red-500 text-red-700'
    ];
    
    $icons = [
        'info' => 'info-circle',
        'success' => 'check-circle',
        'warning' => 'exclamation-triangle',
        'error' => 'exclamation-circle'
    ];
@endphp

<div class="border-l-4 p-4 mb-4 {{ $classes[$type] }}" role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-{{ $icons[$type] }}"></i>
        </div>
        <div class="ml-3">
            <p class="font-medium">{{ $message }}</p>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 hover:bg-{{ substr($classes[$type], 3, 10) }} inline-flex h-8 w-8" data-dismiss-target="#alert" aria-label="Fermer">
            <span class="sr-only">Fermer</span>
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<script>
    // Auto-close alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500);
        });
    }, 5000);
    
    // Close on click
    document.addEventListener('DOMContentLoaded', function() {
        const closeButtons = document.querySelectorAll('[data-dismiss-target="#alert"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alert = this.closest('[role="alert"]');
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            });
        });
    });
</script>