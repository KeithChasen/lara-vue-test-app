<?php

namespace App\Services;

use Storage;
use App\Models\Picture;

class PictureService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Picture::all();
    }

    /**
     * @param $file
     * @return mixed
     */
    public function store($file)
    {
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize();

        $fileName = time().'.'. $ext;

        $path = $file->storeAs('photos', $fileName, 'public');

        return Picture::create([
            'path' => $path,
            'size' => $size,
            'extension' => $ext,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id) {
        return Picture::findOrFail($id);
    }

    /**
     * @param $photo
     * @return mixed
     */
    public function getUserIds($photo) {
        return $photo->users()->get()->pluck('id')->toArray();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $file = $this->find($id);

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
    }

}
