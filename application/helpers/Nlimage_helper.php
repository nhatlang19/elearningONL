<?php

function imageThumb($src, $desc, $height = 200, $width = 200)
{
    // Get the CodeIgniter super object
    $CI = & get_instance();
    
    $image_path = $src;
    // Path to image thumbnail
    $image = $desc;
    
    $image_size = getimagesize($image_path);
    if (! file_exists($image) && $image_size) {
        $current_image_width = $image_size[0];
        $current_image_height = $image_size[1];
        
        // LOAD LIBRARY
        $CI->load->library('image_lib');
        
        // CONFIGURE IMAGE LIBRARY
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_path;
        $config['new_image'] = $image;
        $config['maintain_ratio'] = TRUE;
        if($current_image_width > $height) {
            $config['height'] = $height;
        }
        if($current_image_width > $width) {
            $config['width'] = $width;
        }
        $CI->image_lib->initialize($config);
        
        if (! $CI->image_lib->resize()) {
            echo $CI->image_lib->display_errors();
        }
        $CI->image_lib->clear();
    }
    
    return $image;
}

