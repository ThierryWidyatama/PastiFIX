<div>
    <button type="button"
        class="btn btn-icon btn-sm btn-info" wire:click="show('{{ $id }}')">
        <i class="ki-duotone ki-magnifier fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </button>

    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="display: block;" aria-modal="true">
            <div class="modal-dialog mw-650px">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" wire:click="closeModal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <div class="text-start mb-13">
                            <h1 class="mb-3">Payload User</h1>
                        </div>
                        <div class="text-start">
                            @foreach ($data_payload as $key => $item)
                                <p class="fs-5 fw-semibold mb-1">
                                    <strong>{{ $key }}:</strong>
                                    @if (is_array($item))
                                        <pre class="text-start">{{ json_encode($item, JSON_PRETTY_PRINT) }}</pre>
                                    @else
                                        {{ $item }}
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
