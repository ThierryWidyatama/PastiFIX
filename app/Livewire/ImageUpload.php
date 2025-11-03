<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUpload extends Component
{
    use WithFileUploads;

    public $image;
    public $imagePreview;

    public function updatedImage()
    {
        // Validate the image immediately when it is selected
        $this->validate([
            'image' => 'image|max:1024', // Maximum file size of 1MB
        ]);

        // Generate a temporary URL for the image preview
        $this->imagePreview = $this->image->temporaryUrl();
    }

    public function save()
    {
        $this->validate([
            'image' => 'required|image|max:1024', // Maximum file size of 1MB
        ]);

        // Store the uploaded image
        $imageName = $this->image->store('images', 'public');

        // Perform additional actions like saving the path to the database if needed

        session()->flash('message', 'Image uploaded successfully.');
    }

    public function render()
    {
        return view('livewire.image-upload');
    }
}
