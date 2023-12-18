<?php

function my_scandir ($dir_path, $is_recursive)
{
    $my_pngs = array();

    if($handle = opendir($dir_path)) {
        
        while(false !== $file_name = readdir($handle)) {
            $file_path = "$dir_path/$file_name";
            if(preg_match("/.+\.png$/", $file_name)) {
                array_push($my_pngs, $file_path);
                // echo "image = $file_name" . "\n";
            } elseif (false !== is_dir($file_path) && false !== $is_recursive) {
                
                if($file_name !== "." && $file_name !== "..") {
                    $my_pngs = array_merge(my_scandir($file_path, $is_recursive), $my_pngs);  
                    // echo "dossier = $file_name" . "\n";                  
                }
            }
        } 
    }
    // print_r($my_pngs);
    return $my_pngs;
}