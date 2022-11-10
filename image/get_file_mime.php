<?php
/**
 * Created by IntelliJ IDEA
 * User: jichen.zhou@eeoa.com
 * Date: 2021/8/4
 * Time: 10:57 上午
 */
//$mime = mime_content_type('a.jpeg');
//var_dump($mime);
//$mime = mime_content_type('b.jpeg');
//var_dump($mime);
//$mime = mime_content_type('b.txt');
//var_dump($mime);
//
//$fi = new finfo(FILEINFO_MIME_TYPE);
//$mime = $fi->file('a.jpeg');
//var_dump($mime);

$image = exif_imagetype('c.png');
var_dump($image);
$mime_type = image_type_to_mime_type($image);
var_dump($mime_type);
var_dump(getimagesize('c.png'));
//exit;

$image = exif_imagetype('b.txt');
var_dump($image);
$mime_type = image_type_to_mime_type($image);
var_dump($mime_type);

var_dump(getimagesize('b.txt'));
