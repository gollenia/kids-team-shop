<?php
global $ID;

return [
    "\\Contexis\\Controllers\\MenuEdit" => $ID == "system:menu",
    "\\Contexis\\Controllers\\BibleView" => explode(":", $ID)[0] == "bibel"
];