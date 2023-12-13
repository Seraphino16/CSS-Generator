<?php

function my_scandir ($dir_path)
{
    $my_pngs = array();

    $dir_name = basename($dir_path);

    if($handle = opendir($dir_path)) {
        // echo "On a trouvé dans $dir_name:\n";

        while(false !== $img_name = readdir($handle)) {
            if(preg_match("/.+\.png$/", $img_name)) {
                array_push($my_pngs, "$dir_path/$img_name");
                echo $img_name . "\n";
            }
        }
    }

    return $my_pngs;
}

function my_merge_image ($my_array)
{
    $sprite_width = 0;
    $sprite_height = 0;

    foreach($my_array as $img_path) {
        $img = imagecreatefrompng($img_path);
        $sprite_width += imagesx($img);
        $sprite_height = max($sprite_height, imagesy($img));
    }

    $sprite = imagecreatetruecolor($sprite_width, $sprite_height);

    $file_content = ".sprite {\n";
    $file_content .= "\tbackground-image: url(sprite.png);\n";
    $file_content .= "\tbackground-repeat: no-repeat;\n";
    $file_content .= "\tdisplay: block;\n";
    $file_content .= "\twidth: $sprite_width" . "px;\n";
    $file_content .= "\theight: $sprite_height" . "px;\n}\n\n";
        
    file_put_contents("style.css", $file_content);

    $x_pos = 0;
    $y_pos = 0;

    foreach($my_array as $img_path) {
        $img = imagecreatefrompng($img_path);

        $img_width = imagesx($img);
        $img_height = imagesy($img);

        imagecopy($sprite, $img, $x_pos, $y_pos, 0, 0, $img_width, $img_height);

        $img_name = basename($img_path);

        $class_css = ".$img_name {
            width: $img_width" ."px;
            height: $img_height" . "px;
            background-position: -$x_pos" . "px 0px;
        }\n\n";

        file_put_contents("style.css", $class_css, FILE_APPEND);

        $x_pos += $img_width;
    }

    return imagepng($sprite, "sprite.png");
}


$folder_path = end($argv);

if($folder_path === "man") {
    echo file_get_contents("manual_css_generator.txt");
} else {
    $arr = my_scandir($folder_path);
    my_merge_image($arr);
}



// echo file_get_contents("css_generator_manual.txt");