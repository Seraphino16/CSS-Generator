#!/usr/bin/php
<?php

// array_shift($argv);
// print_r($argv);

$sprite_name = "sprite.png";
$css_name = "sprite.css";

for($i = 1; $i < $argc; $i++) {
    if(strpos($argv[$i], "-") === 0) {
        switch($argv[$i]) {
            case "-r":
                echo "Récusivité activée\n";
                break;
            case "-i":
                echo "Choose your sprite name\n";
                break;
            case "-s":
                echo "Choose your css name\n";
                break;
            default:
                echo "Error\n";
        }
    }
}


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

function my_merge_image ($my_array)
{
    $sprite_width = 0;
    $sprite_height = 0;

    //la première boucle sert à créer le sprite aux bonnes dimensions
    foreach($my_array as $img_path) {
        $img = imagecreatefrompng($img_path);
        $sprite_width += imagesx($img);
        $sprite_height = max($sprite_height, imagesy($img));
    }

    $sprite = imagecreatetruecolor($sprite_width, $sprite_height);

    //on crée le fichier css et on met la classe "sprite" à l'intérieur
    $file_content = ".sprite {\n";
    $file_content .= "\tbackground-image: url(sprite.png);\n";
    $file_content .= "\tbackground-repeat: no-repeat;\n";
    $file_content .= "\tdisplay: block;\n";
    $file_content .= "\twidth: $sprite_width" . "px;\n";
    $file_content .= "\theight: $sprite_height" . "px;\n}\n\n";
        
    file_put_contents("style.css", $file_content);

    //on initie les variables de position
    $x_pos = 0;
    $y_pos = 0;

    //dans chaque boucle on crée un image qu'on copie dans le sprite après avoir récupéré la tailles et la position
    foreach($my_array as $img_path) {
        $img = imagecreatefrompng($img_path);

        $img_width = imagesx($img);
        $img_height = imagesy($img);

        imagecopy($sprite, $img, $x_pos, $y_pos, 0, 0, $img_width, $img_height);


        //ici on crée la classe de chaque image et on l'ajoute au css
        $img_name = basename($img_path);

        $class_css = ".$img_name {
            width: $img_width" ."px;
            height: $img_height" . "px;
            background-position: -$x_pos" . "px 0px;
        }\n\n";

        file_put_contents("style.css", $class_css, FILE_APPEND);

        //on incrémente la positon x pour que les images ne se superposent pas
        $x_pos += $img_width;
    }

    return imagepng($sprite, "sprite.png");
}


$folder_path = end($argv);

if($folder_path === "man") {
    echo file_get_contents("manual_css_generator.txt");
} else {
    $arr = my_scandir($folder_path);
    echo "Les fichiers .png ont été récupérés\n";
    my_merge_image($arr);
}



// echo file_get_contents("css_generator_manual.txt");