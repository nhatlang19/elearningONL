<?php

function getThumb($imgSrc)
{
    $tempImg = str_replace('images', '_thumbs/images', $imgSrc);
    echo $tempImg;
}