<?php

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