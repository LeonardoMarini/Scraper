<?php
global $response;
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


getPath();
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

function getPath(){
    libxml_use_internal_errors(true);
    $dom = new DomDocument;
    $xpath = new DomXPath($dom);
    global $response;
}

function getData(){
    global $response;
    $response['date'] = date("d-m-Y-h:i");

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

