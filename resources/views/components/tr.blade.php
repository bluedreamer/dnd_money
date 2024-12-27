@props([
    'color_row'=>false,
])

<tr {{ $attributes->class(['even:bg-emerald-400/20 odd:bg-emerald-700/20 dark:even:bg-emerald-700 dark:odd:bg-emerald-900' => $color_row]) }}>
{{ $slot }}
</tr>