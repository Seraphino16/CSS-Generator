<?php

function my_scandir ($dir_path)
{
    $my_pngs = array();

    $dir_name = basename($dir_path);

    if($handle = opendir($dir_path)) {
        echo "On a trouvé dans $dir_name:\n";

        while(false !== $img_name = readdir($handle)) {
            if(preg_match("/.+\.png$/", $img_name)) {
                array_push($my_pngs, $img_name);
            }
        }
    }

    return $my_pngs;
}

// $arr = my_scandir("img_css_generator");

// print_r($arr);