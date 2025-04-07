<div class="mb-4">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input
        id="{{ $id }}"
      type="{{ $type }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, isset($value) ? $value : '') }}" 
        class="mt-1 block w-full border border-gray-500 rounded-md p-2"
        style="background-color: #f0f0f0; color: #333;"
    >
    @if ($errors->has($name))
        <p class="mt-1 text-sm text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>
 