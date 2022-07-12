<?php

namespace App\Domains\Styles\Actions;

use App\Http\Requests\Styles\FileStoreRequest;

class SaveImageAndGetPath
{
    public function execute(FileStoreRequest $request)
    {
        $imagePath = '';

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('style_images', 'public');
        }

        return $imagePath;
    }
}
