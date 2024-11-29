<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PhotoService
{
    // Malas
    public static function saveBase64Image($base64Image, $prefix = 'photo')
    {
        $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
        $base64Image = str_replace(' ', '+', $base64Image);

        try {
            $decodedImage = base64_decode($base64Image, true);
            if (!$decodedImage) {
                throw new \Exception('Invalid Base64 data');
            }

            $imageName = $prefix . '_' . time() . '.jpg';

            Storage::disk('public')->put('photos/' . $imageName, $decodedImage);

            return $imageName;
        } catch (\Exception $e) {
            throw new \Exception('Error saving image: ' . $e->getMessage());
        }
    }
}
