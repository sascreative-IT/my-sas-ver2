<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepositoryInterface;
use App\Http\Requests\StoreFileRequest;
use Inertia\Inertia;

class FileUploadController extends Controller
{
    protected $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function store(StoreFileRequest $request)
    {
        $validated = $request->validated();

        if (!$validated['logo']) {
            return response()->json([
                'success' => false,
                'message' => 'Not a valid file type'
            ], 500);
        }

        $file = $this->fileRepository->create($validated['logo']);

        if ($file) {
            return response()->json([
                'success' => true,
                'logo_id' => $file->id
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed'
            ], 500);
        }


    }

    public function show($id)
    {
        $fileUrl = $this->fileRepository->find($id);

        return $fileUrl;
    }
}
