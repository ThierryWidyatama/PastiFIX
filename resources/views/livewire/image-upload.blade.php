<div>
    <!-- Image Input -->
    <input type="file" wire:model="image" class="form-control" accept="image/*">

    <!-- Show a loading spinner while the image is being uploaded -->
    <div wire:loading wire:target="image" class="mt-2">
        Uploading...
    </div>

    <!-- Image Preview -->
    @if ($imagePreview)
        <div class="mt-3">
            <img src="{{ $imagePreview }}" alt="Image Preview" class="img-thumbnail rounded-circle" style="max-width: 200px;">
        </div>
    @endif

    <!-- Show validation error -->
    @error('image')
        <div class="text-danger mt-2">{{ $message }}</div>
    @enderror

    <!-- Submit Button -->
    <button wire:click="save" class="btn btn-primary mt-3">Upload Image</button>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">{{ session('message') }}</div>
    @endif
</div>
