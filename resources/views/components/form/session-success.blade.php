<p 
    x-data="{ status: true}"
    x-init="setTimeout(() => status = false, 5000)"
    x-show="status"
    class="mt-1 text-green-600"
>
    {{ $slot }}
</p>