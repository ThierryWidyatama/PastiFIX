@props(['name', 'label', 'placeholder', 'value' => null, 'type' => 'text', 'texthelper', 'attributes' => [], 'options' => []])

@if (isset($placeholder))
    <select name="{{ $name }}" id="{{ $name }}-form" class="form-select" data-control="select2" data-placeholder="Pilih {{ $placeholder }}">
        @if ($value == null)
            <option value="">Pilih {{ $placeholder }}</option>
        @endif
        @foreach ($options as $option_value => $option)
            <option value="{{ $option_value }}" {{ $value == $option_value ? 'selected' : '' }}>{{ $option }}
            </option>
            @endforeach
        </select>
    @if ($texthelper != '')
        <small class="form-hint">
            {{ $texthelper }}
        </small>
    @endif
@else
    <select name="{{ $name }}" id="{{ $name }}-form" class="form-select" data-control="select2">
        @if ($value == null)
            <option value="">Pilih {{ $label }}</option>
        @endif
        @foreach ($options as $option_value => $option)
            <option value="{{ $option_value }}" {{ $value == $option_value ? 'selected' : '' }}>{{ $option }}
            </option>
        @endforeach
    </select>
    @if ($texthelper != '')
        <small class="form-hint">
            {{ $texthelper }}
        </small>
    @endif
@endif
{{-- <script src="{{asset('assets/libs/tom-select/dist/js/tom-select.base.min.js?1674944402')}}" defer></script> --}}
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('{{ $name }}-form'), {
            copyClassesToDropdown: false,
            dropdownClass: 'dropdown-menu ts-dropdown',
            optionClass: 'dropdown-item',
            controlInput: '<input>',
            render: {
                item: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data
                            .customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data
                            .customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    // @formatter:on
</script>
