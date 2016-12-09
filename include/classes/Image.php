<?php

class Image
{
    public static function createThumb($srcname, $destname, $maxwidth, $maxheight)
    {
        $oldimg = $srcname;
        $newimg = $destname;

        $imagedata = GetImageSize($oldimg);
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];
        $shrinkage = 1;

        if ($imagewidth > $maxwidth) {
            $shrinkage = $maxwidth / $imagewidth;
        }

        if ($shrinkage != 1) {
            $dest_height = $shrinkage * $imageheight;
            $dest_width = $maxwidth;
        } else {
            $dest_height = $imageheight;
            $dest_width = $imagewidth;
        }

        if ($dest_height > $maxheight) {
            $shrinkage = $maxheight / $dest_height;
            $dest_width = $shrinkage * $dest_width;
            $dest_height = $maxheight;
        }

        if ($imagetype == 2) {
            $src_img = imagecreatefromjpeg($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagejpeg($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        } else if ($imagetype == 3) {
            $src_img = imagecreatefrompng($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagepng($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        } else {
            $src_img = imagecreatefromgif($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagejpeg($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }
}
