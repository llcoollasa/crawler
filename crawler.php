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
$numbers = $dom->getSelectedIds(300);

//CSV file called content.csv will create
$csv = new CSVFile();
$tot = count($numbers);
$curr = 1;
foreach($numbers as $id=>$key) {

    $content = $dom->getDetails($detail_url, $key['reg'],$key['name']);
    $csv->passData($content);
    fwrite(STDOUT, $key['reg']."\t\t$curr of $tot\n");
    $curr ++;
}

$csv->exportCsv();

echo "<a href='content.csv'>CSV FILE </a>";