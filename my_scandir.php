<?php

function my_scandir ($dir_path)
{
    $my_pngs = array();

    // $dir_name = basename($dir_path);

    if($handle = opendir($dir_path)) {
        // echo "On a trouvé dans $dir_name:\n";
        

        while(false !== $file_name = readdir($handle)) {
            // echo $file_name . "\n";
            $file_path = "$dir_path/$file_name";
            if(preg_match("/.+\.png$/", $file_name)) {
                // echo "pregmatch\n";
                array_push($my_pngs, $file_path);
                // echo "fichier = $file_name" . "\n";
            } elseif (false !== is_dir($file_path)) {
                // echo "dossier = $file_name" . "\n";
                if($file_name !== "." && $file_name !== "..") {
                    // echo $file_name . "\n";
                    $my_pngs = array_merge(my_scandir($file_path), $my_pngs);
                    
                    // print_r($my_pngs);
                }
                
            }
        } 
    }

    return $my_pngs;
}