@props(['name', 'label', 'value' => null,'type' => 'text', 'attributes' => [],'texthelper'])

<input type="file" name="{{ $name }}" id="{{ $name }}-form" value="{{ old($name, $value) }}" {!! $attributes->merge(['class' => 'form-control']) !!}>
@if ($texthelper != "")
<small class="form-hint">
    {{$texthelper}}
</small>
@endif
@error($name)
    <span class="text-red-600">{{ $message }}</span>
@enderror