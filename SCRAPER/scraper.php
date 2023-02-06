<?php
global $response;
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


getMeteo();
getData();
getNews();
echo json_encode($response);
function crawl_page($icone)
{
    $breaker = false;
    foreach ($icone as $element) {
        if ($breaker) {
            break;
        }
        // Extracting value of src attribute of
        // the current image object
        $src = $element->getAttribute('src');
        // Given Output as image with extracted attribute,
        // you can print value of those attributes also
        //echo $src;
        return $src;
        //$breaker = true;

    }
}
function getBackgroundImage($meteo)
{
    if (str_contains($meteo, 'ole')) {
        return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/Sunny.webp';
    }
    if (str_contains($meteo, 'prevalenza') || str_contains($meteo, 'arzialmente sereno')) {
        return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/partlysunny_day.webp';
    }
    if (str_contains($meteo, 'uvoloso')) {
        return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/Cloudy 2.webp';
    }

    if (str_contains($meteo, 'ioggia leggera')) {
        return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/Rain 1.webp';
    }
    if (str_contains($meteo, 'ovesci') || str_contains($meteo, 'ioggia')) {
        return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/Rain 2.webp';
    }
    if (str_contains($meteo, 'eve')) {
        return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/Snow 2.webp';
    }
    return 'https://assets.msn.com/weathermapdata/1/static/images/webps/v1.0/Sunny.webp';
}

function getMeteo()
{
    /* Use internal libxml errors -- turn on in production, off for debugging */
    libxml_use_internal_errors(true);
    /* Createa a new DomDocument object */
    $dom = new DomDocument;
    /* Load the HTML */
    $dom->loadHTMLFile("https://www.msn.com/it-it/meteo/previsioni/in-Camponogara,Veneto?loc=eyJsIjoiQ2FtcG9ub2dhcmEiLCJyIjoiVmVuZXRvIiwicjIiOiJWZW5lemlhIiwiYyI6Ikl0YWxpYSIsImkiOiJJVCIsInQiOjEwMiwiZyI6Iml0LWl0IiwieCI6IjEyLjA3MjQwMDA5MzA3ODYxMyIsInkiOiI0NS4zODMzOTk5NjMzNzg5MDYifQ%3D%3D&weadegreetype=C");

    /* Create a new XPath object */
    $xpath = new DomXPath($dom);

    $metei = $xpath->query("//*[contains(@class, 'summaryCaptionCompact-E1_1')]");
    $temperature = $xpath->query("//*[contains(@class, 'summaryTemperatureCompact-E1_1 summaryTemperatureHover-E1_1')]");

    //echo 'METEO CAMPONOGARA', "<br><br>";
    global $response;
    foreach ($metei as $i => $node) {
        foreach ($temperature as $z => $nod) {
            $meteo = $node->nodeValue;
            $gradi = $nod->nodeValue;
            $icone = $xpath->query("//*[contains(@title, '$meteo')]");
            $response['weather']['condizione'] = $meteo;
            $response['weather']['gradi'] = $gradi;
            $response['weather']['icona'] = crawl_page($icone);
            $response['weather']['background'] = getBackgroundImage($meteo);
            //echo '- ', $meteo, '  gradi => ', $gradi, "\n";
            //echo '<img src="' . getBackgroundImage($meteo) . '" alt="alt" height="100px" width="100px"/>';
        }
    }

}
function getData()
{
    global $response;
    $response['date']['data'] = date("d-m-Y");
    $response['date']['ora'] = date("h:i");

    //echo date("d-m-Y");
    //echo '<br>';
    //echo date("h:i:sa");
}
function getNews(){
    global $response;
    libxml_use_internal_errors(true);
    $dom = new DomDocument;
    $dom->loadHTMLFile("https://www.ansa.it/");
    $xpath = new DomXPath($dom);
    $news = $xpath->query("//h3[contains(@class, 'news-title area-primopiano')]");
    foreach ($news as $i => $node) {
        $response['news'][]=$node->nodeValue;
    }
}
?>