<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-upload me-1"></i>
            File Upload
        </div>
        <div class="card-body">
            <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Choose File</label>
                    <input type="file" class="form-control" wire:model="file">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                <div wire:loading wire:target="file" class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $uploadProgress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $uploadProgress }}%"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-alt me-1"></i>
            Uploaded Files
        </div>
        <div class="card-body">
            @if (empty($files))
                <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                    <p class="text-center">No Files Uploaded</p>
                </div>
            @else
                <ul>
                    @foreach ($files as $file)
                        <li>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a>
                        </li>
                        <td class="text-right">
                            <button class="btn btn-danger btn-sm" wire:click="removeFile('{{ $file }}')">Remove</button>
                        </td>
                    @endforeach
                </ul>
            @endif
        </div>
     
    </div>