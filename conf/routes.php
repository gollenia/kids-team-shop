<?php
global $ID;
global $INPUT;
global $ACT;

return [
    "\\Contexis\\Controllers\\Search" => $ACT == "search",
    "\\Contexis\\Controllers\\MenuEdit" => $ID == "system:menu",
    "\\Contexis\\Controllers\\BibleView" => explode(":", $ID)[0] == "bibel" && $ACT == "show",    
    "\\Contexis\\Controllers\\Tag" => explode(":", $ID)[0] == "tag" && $ACT == "show",
    "\\Contexis\\Controllers\\Show" => $ACT == "show",       
];