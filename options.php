<?php

$short_options = "r"; //option pour la récusivité
$short_options .= "i:"; // option pour le nom du sprite / les deux points sont pour la valeur requise
$short_options .= "s:"; //option pour le nom du css
$short_options .= "h"; // option pour afficher l'aide

$long_options = array(
    "recursive",
    "output-image:",
    "output-style:",
);

$options = getopt($short_options, $long_options);

$help = (isset($options["h"])) ? true : false;

$is_recursive = (isset($options["r"])) ? true : false;

$sprite_name = (isset($options["i"])) ? $options["i"] : "sprite.png";
$css_name = (isset($options["s"])) ? $options["s"] : "sprite.css";

$sprite_name .= (preg_match("/.+\.png$/", $sprite_name)) ? "" : ".png";
$css_name .= (preg_match("/.+\.css$/", $css_name)) ? "" : ".css";
