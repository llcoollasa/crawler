<?php

/*
 * @author lasantha Indrajith<hellolasantha@gmail.com>
 * @purpose testing and education purpose only
 * @Description Crawling class
 *
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'class/htmlDomHandler.php';
require_once 'class/csv_file.php';

$id_url ="https://prs.moh.gov.sg/prs/internet/profSearch/getSearchSummaryByName.action";
$detail_url = 'https://prs.moh.gov.sg/prs/internet/profSearch/getSearchDetails.action';

$dom = new HtmlDomHandler($id_url);
$numbers = $dom->getSelectedIds(2);

//CSV file called content.csv will create
$csv = new CSVFile();

foreach($numbers as $num) {

    $content = $dom->getDetails($detail_url, $num);
    $csv->passData($content);
}

$csv->exportCsv();

echo "<a href='content.csv'>CSV FILE </a>";