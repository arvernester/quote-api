<?php

namespace App\Quote;

use GDText\Box;
use GDText\Color;
use App\Quote;

class Poster
{
    public function generate(Quote $quote)
    {
        $image = imagecreatetruecolor(600, 400);

        $bgColor = imagecolorallocate($image, 29, 39, 44);
        imagefill($image, 0, 0, $bgColor);

        $box = new Box($image);
        $box->setFontFace(
            $fontPath = resource_path('assets/fonts/MoonTypeface/Moon Light.otf')
        );
        $box->setFontColor(new Color(255, 255, 255));
        $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
        $box->setFontSize(25);
        $box->setBox(20, 10, 560, 90);
        $box->setTextAlign('center', 'top');
        $box->draw($quote->author->name);

        $fontSize = 30;
        if (strlen($quote->text) > 500) {
            $fontSize = 16;
        } elseif (strlen($quote->text) > 250) {
            $fontSize = 18;
        } elseif (strlen($quote->text) > 150) {
            $fontSize = 19;
        }

        $box = new Box($image);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(255, 255, 255));
        // $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
        $box->setFontSize($fontSize);
        $box->setBox(20, 100, 560, 300);
        $box->setTextAlign('center', 'top');
        $box->draw($quote->text);

        $box = new Box($image);
        $box->setFontFace($fontPath);
        $box->setFontColor(new Color(255, 255, 255));
        $box->setBox(20, 10, 560, 380);
        $box->setTextAlign('center', 'bottom');
        $box->draw('www.kutip.org');

        imagepng($image);
    }
}
