@php
        $status = $status ?? 'Draft';
        $classes = 'p-1 rounded text-xs font-semibold shadow-sm ';
        if ($status == 'Valid' || $status == 'Lolos') {
            $classes .= 'bg-green-100 text-green-800 border border-green-400';
        } elseif ($status == 'Rejected' || Str::contains($status, 'Ditolak')) {
            $classes .= 'bg-red-100 text-red-800 border border-red-400';
        } elseif ($status == 'Pending') {
            $classes .= 'bg-yellow-100 text-yellow-800 border border-yellow-400';
        } else {
            $classes .= 'bg-gray-100 text-gray-800 border border-gray-400';
        }
    @endphp
    <span class="{{ $classes }}">
        {{ $status }}
    </span>
