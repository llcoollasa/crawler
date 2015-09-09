<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'class/htmlDomHandler.php';

$id_url ="https://prs.moh.gov.sg/prs/internet/profSearch/getSearchSummaryByName.action";
$detail_url = 'https://prs.moh.gov.sg/prs/internet/profSearch/getSearchDetails.action';

$dom = new HtmlDomHandler();
$numbers = $dom->getIds($id_url);



foreach($numbers as $num){

    $content = $dom->getDetails($detail_url,$num);

    print_r($content);


}