{{-- cek filter, untuk placeholder --}}
@if (isset($field['placeholder']))
    <div class="form-label"></div>
    @if ($field['type'] == 'text' || $field['type'] == 'number' || $field['type'] == 'email' || $field['type'] == 'color')
        <x-input-text :type="$field['type']" :name="$name" :placeholder="$field['placeholder']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'textarea')
        <x-input-textarea :name="$name" :placeholder="$field['placeholder']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'select')
        <x-input-select :name="$name" :placeholder="$field['placeholder']" :value="$value" :options="$field['option']" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'file')
        <x-input-file :name="$name" :placeholder="$field['placeholder']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'date')
        <x-input-date :name="$name" :placeholder="$field['placeholder']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @endif
@else
    <div class="form-label {{ strpos($field['validation'], 'required') !== false ? 'required' : '' }}">
        {{ $field['label'] }}</div>
    @if ($field['type'] == 'text' || $field['type'] == 'number' || $field['type'] == 'email' || $field['type'] == 'color')
        <x-input-text :type="$field['type']" :name="$name" :label="$field['label']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'textarea')
        <x-input-textarea :name="$name" :label="$field['label']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'select')
        <x-input-select :name="$name" :label="$field['label']" :value="$value" :options="$field['option']"
            :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'file')
        <x-input-file :name="$name" :label="$field['label']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @elseif ($field['type'] == 'date')
        <x-input-date :name="$name" :label="$field['label']" :value="$value" :texthelper="$field['texthelper'] ?? ''" />
    @endif
@endif
