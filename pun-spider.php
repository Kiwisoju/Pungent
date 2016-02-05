<?php
function crawl_page($url)
{
    
    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);

    $anchors = $dom->getElementsByTagName('p');
    
    $punsRaw = [];
    
    foreach ($anchors as $element) {
        array_push($punsRaw, $element->nodeValue);
    }
    
    $punOfTheDay = substr(substr($punsRaw[0], 3), 0, -3);
    
    return $punOfTheDay;
}

