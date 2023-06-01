<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class AddWire extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $uploadProgress = 0; 
    public $file; 
    public $files = []; 
    

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file',
        ]);
    
        $uploadedFile = $this->file->store('public/uploads');
        $this->alert('success', 'File Successfully Uploaded!');
        $this->reset('file');
        $this->emit('fileUploaded', $uploadedFile);
        $this->files = Storage::disk('public')->files('uploads'); 
    }
    
    public function updatedFile()
    {
        $this->validateOnly('file', [
            'file' => 'required|file|max:2048',
        ]);
    }

    public function removeFile($filePath)
    {
        Storage::delete($filePath);
        $this->files = array_diff($this->files, [$filePath]);
        $this->alert('success', 'File removed successfully.');
    }
    
    public function render()
    {
        $files = Storage::disk('public')->files('uploads');
    
        return view('livewire.add-wire', [
            'files' => $files,
        ]);
    }
    

}