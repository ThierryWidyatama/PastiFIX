@props(['name', 'label','placeholder', 'value' => null,'type' => 'date', 'attributes' => [],'texthelper'])

<input type="date" name="{{ $name }}" id="{{ $name }}-form" value="{{ old($name, $value) }}" placeholder="{{ isset($placeholder) ? $placeholder : 'Pilih Tanggal' }}" {!! $attributes->merge(['class' => 'form-control']) !!} />

@if ($texthelper != "")
<small class="form-hint">
    {{$texthelper}}
</small>
@endif
@error($name)
    <span class="text-red-600">{{ $message }}</span>
@enderror
<script>
    $("#{{ $name }}-form").flatpickr({
        locale: "id", // formate date indonesia
    });
</script>