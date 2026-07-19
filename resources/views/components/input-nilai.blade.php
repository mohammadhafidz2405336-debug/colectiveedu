@props(['label', 'model'])
<div>
    <label class="block text-sm font-bold text-slate-700 mb-1">{{ $label }}</label>
    <input type="number" wire:model="{{ $model }}" 
           class="w-full rounded-xl border-slate-200 focus:border-indigo-500 transition shadow-sm">
</div>