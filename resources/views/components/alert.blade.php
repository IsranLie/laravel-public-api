@props(['type' => 'success', 'message' => '']) @php switch ($type) { case
'error': $icon = 'ri-error-warning-line text-red-500'; $bg = 'bg-red-50
border-red-400 text-red-700'; break; case 'info': $icon = 'ri-information-line
text-blue-500'; $bg = 'bg-blue-50 border-blue-400 text-blue-700'; break;
default: $icon = 'ri-check-line text-green-500'; $bg = 'bg-green-50
border-green-400 text-green-700'; break; } @endphp

<div
    id="alert-box"
    class="fixed top-20 right-5 z-50 flex items-center justify-between max-w-sm p-3 text-sm border rounded-lg shadow-lg {{
        $bg
    }}"
>
    <div class="flex items-center gap-2">
        <i class="{{ $icon }} text-xl"></i>
        <span class="leading-tight">{{ $message }}</span>
    </div>
    <button
        type="button"
        onclick="document.getElementById('alert-box').remove()"
        class="text-lg ml-2"
    >
        <i class="ri-close-line"></i>
    </button>
</div>

<script>
    setTimeout(() => {
        document.getElementById("alert-box")?.remove();
    }, 5000);
</script>
