<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{
    public function create($uploadedFileRequest)
    {
        $file = new File;
        $filePath = $uploadedFileRequest->store('uploads', 'public');
        $file->file_path = pathinfo($filePath)['basename'];
        $file->save();

        return $file;
    }

    public function find($id)
    {
        $file = File::query()->find($id);
        $url = asset('storage/uploads/'.$file->file_path);

        return $url;
    }
}
