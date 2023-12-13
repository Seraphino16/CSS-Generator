<?php

function my_merge_image ($first_img_path, $second_img_path)
{
    // crée des instances d'images à partir des chemins
    $img_1 = imagecreatefrompng($first_img_path);
    $img_2 = imagecreatefrompng($second_img_path);

    // récupère les dimensions des deux images
    $img_1_width = imagesx($img_1);
    $img_1_height = imagesy($img_1);
    $img_2_width = imagesx($img_2);
    $img_2_height = imagesy($img_2);

    // crée une nouvelle image vierge avec les dimensions selon les deux images combinées
    $new_img_width = $img_1_width + $img_2_width;
    $new_img_height = max($img_1_height, $img_2_height);
    $new_img = imagecreatetruecolor($new_img_width, $new_img_height);

    // copie les images mises en paramètres dans la nouvelle image avec les bonnes coordonées
    imagecopy($new_img, $img_1, 0, 0, 0, 0, $img_1_width, $img_1_height);
    imagecopy($new_img, $img_2, $img_1_width, 0, 0, 0, $img_2_width, $img_2_height);

    //retourne le sprite créé
    return imagepng($new_img, "sprite.png");
}


function my_generate_css ($first_img_path, $second_img_path)
{
    $img_1 = imagecreatefrompng($first_img_path);
    $img_2 = imagecreatefrompng($second_img_path);

    $img_1_width = imagesx($img_1);
    $img_1_height = imagesy($img_1);
    $img_2_width = imagesx($img_2);
    $img_2_height = imagesy($img_2);

    $sprite_width = $img_1_width + $img_2_width;
    $sprite_height = max($img_1_height, $img_2_height);

    //set à nommer les classes avec le nom de chaque image
    $img_1_name = basename($first_img_path);
    $img_2_name = basename($second_img_path);

    //crée du contenu à mettre dans un fichier css pour utiliser le sprite
    $file_content = ".sprite {\n";
    $file_content .= "\tbackground-image: url(sprite.png);\n";
    $file_content .= "\tbackground-repeat: no-repeat;\n";
    $file_content .= "\tdisplay: block;\n";
    $file_content .= "\twidth: $sprite_width" . "px;\n";
    $file_content .= "\theight: $sprite_height" . "px;\n}\n\n";
    
    //crée le fichier css (car il n'est pas encore créé) et écrit le contenu à l'interieur
    file_put_contents("style.css", $file_content);

    //crée une classe pour la première image avec ses dimensions puis l'écrit dans le fichier css
    $class_css = ".$img_1_name {
        width: $img_1_width" ."px;
        height: $img_1_height" . "px;
        background-position: 0px 0px;
    }\n\n";

    file_put_contents("style.css", $class_css, FILE_APPEND);

    //crée une autre classe pour la deuxième image avec la bonne postition
    $class_css = ".$img_2_name {
        width: $img_2_width" . "px;
        height: $img_2_height" . "px;
        background-position: -$img_1_width" . "px 0px;
    }\n\n";

    file_put_contents("style.css", $class_css, FILE_APPEND);
}



// my_merge_image("img_css_generator/fishes.png", "img_css_generator/paint.png");

// my_generate_css("img_css_generator/fishes.png", "img_css_generator/paint.png");
