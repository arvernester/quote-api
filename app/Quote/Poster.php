<?php

namespace App\Quote;

use GDText\Box;
use GDText\Color;
use App\Quote;

class Poster
{
    public function generate(Quote $quote)
    {
        $image = imagecreatefromjpeg(public_path('img/quote-bg.jpg'));

        $box = new Box($image);
        $box->setFontFace(
            $fontPath = resource_path('assets/fonts/Geomanist/Geomanist-Regular.otf')
        );
        $box->setFontColor(new Color(255, 255, 255));
        $box->setFontSize(20);
        $box->setBox(20, 10, 580, 426);
        $box->setTextAlign('center', 'top');
        $box->draw($quote->author->name);

        $fontSize = 30;
        if (strlen($quote->text) > 300) {
            $fontSize = 14;
        } elseif (strlen($quote->text) > 200) {
            $fontSize = 18;
        } elseif (strlen($quote->text) > 150) {
            $fontSize = 19;
        }

        $box = new Box($image);
        $box->setFontFace(
            resource_path('assets/fonts/Savoye/Savoye LET Plain1.0.ttf')
        );
        $box->setFontColor(new Color(255, 255, 255));
        // $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
        $box->setFontSize($fontSize + 15);
        $box->setBox(10, 100, 590, 426);
        $box->setTextAlign('center', 'top');
        $box->draw($quote->text);

        $box = new Box($image);
        $box->setFontFace(
            resource_path('assets/fonts/Geomanist/Geomanist-Regular.otf')
        );
        $box->setFontColor(new Color(29, 39, 44));
        $box->setBox(20, 10, 560, 380);
        $box->setFontSize(15);
        $box->setTextAlign('center', 'bottom');
        $box->setBackgroundColor(new Color(255, 255, 255));
        $box->draw('  www.kutip.org ');

        imagepng($image);
    }
}
