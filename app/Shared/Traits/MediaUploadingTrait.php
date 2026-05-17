<?php

namespace App\Shared\Traits;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait MediaUploadingTrait
{
    /**
     * storeMedia
     *
     * @return Media
     */
    public function storeMedia(
        $file,
        $collection,
        $public = true,
        $disk = '',
        $c_disk = '',
        $randomizeFileName = true
    ) {
        $filename = $randomizeFileName ? $this->randomizeFileName($file) : $file->getClientOriginalName();

        // adding to S3
        $added_media = $this->addMedia($file)->usingFileName($filename);

        if ($public) {
            $added_media = $added_media->addCustomHeaders([
                'ACL' => 'public-read',
            ]);
        }

        if ($c_disk) {
            $added_media = $added_media->storingConversionsOnDisk($c_disk);
        }

        $added_media = $added_media->toMediaCollection(
            $collection,
            $disk !== '' ? $disk : config('media-library.disk_name', 'public'),
        );

        return $added_media;
    }

    /**
     * Randomize a file name.
     *
     * @param  string|UploadedFile  $file  The file to randomize
     * @return string The random file name
     */
    protected function randomizeFileName($file)
    {
        $file = $file instanceof UploadedFile ? $file : new UploadedFile($file, basename($file));

        return time().Str::random(10).'.'.$file->getClientOriginalExtension();
    }
}
