@props(['name', 'label', 'value' => null, 'type' => 'text', 'attributes' => [], 'texthelper'])

<textarea type="{{ $type }}" name="{{ $name }}" id="{{ $name }}-form" {!! $attributes->merge(['class' => 'form-control']) !!}>{{ $value }}</textarea>
@if ($texthelper != '')
    <small class="form-hint">
        {{ $texthelper }}
    </small>
@endif
@error($name)
    <span class="text-red-600">{{ $message }}</span>
@enderror
