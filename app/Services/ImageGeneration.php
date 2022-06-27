<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickDraw;
use ImagickPixel;
use StounhandJ\YandexMusicApi\Models\Track\Track;

class ImageGeneration
{

    public static function generate(Track $track): string
    {
        if (!isset($track->id)) {
            $track->update();
        }

        Storage::makeDirectory(static::getDirectory());

        if (Storage::exists(static::getPathFile($track))) {
            return static::getPathFile($track);
        }

        $downloadImg = static::downloadImage($track);
        $img = static::createEmptyImage();

        $img->compositeImage($downloadImg, Imagick::COMPOSITE_OVER, 15, 105);
        $img->annotateImage(static::getImagickDraw(25), 165, 40, 0, $track->title);
        if (count($track->artists) > 0) {
            $img->annotateImage(static::getImagickDraw(15), 165, 70, 0, $track->artists[0]->name);
        }

        $path = static::getFullPathFile($track);
        $img->writeImage($path);

        return static::getPathFile($track);
    }

    private static function getNameFile(Track $track): string
    {
        return $track->id . ".png";
    }

    private static function getPathFile(Track $track): string
    {
        return static::getDirectory() . static::getNameFile($track);
    }

    private static function getFullPathFile(Track $track): string
    {
        return Storage::path(static::getPathFile($track));
    }

    private static function getDirectory(): string
    {
        return "tracks/";
    }

    private static function getImagickDraw(int $fonSize, string $fontColor = "white"): ImagickDraw
    {
        $draw = new ImagickDraw();
        $draw->setTextAlignment(Imagick::ALIGN_CENTER);
        $draw->setFillColor(new ImagickPixel($fontColor));
        $draw->setFontSize($fonSize);
        $draw->setFont(Storage::path("SONGER_G_Regular.otf"));
        return $draw;
    }

    private static function downloadImage(Track $track): Imagick
    {
        Storage::makeDirectory("temp");
        $fileName = Storage::path("temp") . "/$track->id.png";
        $track->downloadImg($fileName, 300);
        $image = new Imagick();
        $image->readImage($fileName);
        $image->roundCornersImage(5, 5);
        return $image;
    }

    private static function createEmptyImage(int $x = 330, int $y = 420, string $color = "black"): Imagick
    {
        $image = new Imagick();
        $image->newImage($x, $y, $color);
        $image->setFormat("png");
        $image->roundCornersImage(5, 5);
        return $image;
    }
}
