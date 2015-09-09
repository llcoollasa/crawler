<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'simple_html_dom.php';

require 'src/phpQuery-onefile.php';

$page = 10;
$url ="https://prs.moh.gov.sg/prs/internet/profSearch/getSearchSummaryByName.action";

$ch = curl_init($url);


//set POST variables

//$fields = array(
//    'hpe'=>'OOB',
//    'regNo'=>'',
//    'psearchParamVO.language'=>'eng',
//    'psearchParamVO.searchBy'=>'N',
//    'psearchParamVO.name'=>'',
//    '__checkbox_psearchParamVO.startWith'=>'startWith',
//    '__checkbox_psearchParamVO.cbRegister'=>'CLP',
//    '__checkbox_psearchParamVO.cbRegister'=>'OPTOMETRIST',
//    'psearchParamVO.pracPlaceName'=>'',
//    'psearchParamVO.regNo'=>'',
//    'selectType'=>'selected',
//    'psearchParamVO.cbRegister'=>'CLP',
//    'psearchParamVO.cbRegister'=>'OPTOMETRIST',
//    'psearchParamVO.startWith'=>'startWith'
//);


$fields = array(
    'hpe'=>'OOB'
);

//url-ify the data for the POST
$fields_string="";
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch,CURLOPT_HEADER, false);
curl_setopt($ch,CURLOPT_RETURNTRANSFER , true);

curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: cookie.tableId=DEFAULT;cookie.currentPage=DEFAULT.$page;BIGipServerPRS_Inter=4111062794.22528.0000"));

//curl_setopt($ch, CURLOPT_COOKIE, "cookie.tableId=DEFAULT; BIGipServerPRS_Inter=4111062794.22528.0000");


//execute post
$result = curl_exec($ch);

curl_close($ch);



$html = new simple_html_dom();
$html->load($result);

$items = $html->find('div[id=searchResultHead]');

foreach ($items as $key => $value) {

    $maps = new simple_html_dom();
    $maps->load($value);
    $map = $maps->find('a[onclick]');


    foreach ($map as $k => $v){
        $val = trim($v->attr['onclick']);
        $val = preg_replace('/viewMoreDetails\\(\'/', ' ',$val);
        $val = preg_replace('/\\); return false[\';]*/', ' ',$val);
        $val = trim($val);
        $val = trim($val,"'");

        if(preg_match('/^[A-Z0-9]+$/',$val)){
            echo $val."<br/>";
        }

    }



}

//var_dump($result);

die();
$dom = new DOMDocument();
@$dom->loadHTML($result);



//$elements = $xpath->query("/html/body/div[@id='yourTagIdHere']");
//$elements = $xpath->query("//*[@id]");
//$elements = $xpath->query("*/div[@id='yourTagIdHere']");

// jQuery('.no-border.table-title').each(function(){

//   console.log(jQuery(this).html());

// });

$csv_str = "";
$csv_vals = "";


$file = fopen("content.csv","w");

$html = new simple_html_dom();
$html->load($result);

$arr = array();

$items = $html->find('td[class=no-border table-title]');

foreach ($items as $key => $value) {
    $val = trim($value->innertext);
    $val = str_replace("&nbsp;", " ", $val);
    $val = preg_replace('/\\s+/', ' ',$val);

    fwrite($file,"$val\t");
}

fwrite($file,"\r");

$items = $html->find('td[class=no-border table-data]');

foreach ($items as $key => $value) {
    $val = trim($value->innertext);
    $val = str_replace("&nbsp;", " ", $val);
    $val = preg_replace('/\\s+/', ' ',$val);


    $maps = new simple_html_dom();
    $maps->load($value);
    $map = $maps->find('a[onclick]');

    if(count($map) > 0){
        foreach ($map as $k => $v){
            $val = trim($v->attr['onclick']);
            $val = preg_replace('/openGoogleMap\\(\'/', ' ',$val);
            $val = preg_replace('/\\); return false[;]*/', ' ',$val);
            $val = trim($val);
            $val = trim($val,"'");
            fwrite($file,"$val\t");
        }
    }else{

        fwrite($file,"$val\t");
    }
    $maps=null;




}

// foreach($items as $post) {

//     var_dump($post->children(0)->outertext);
//     # remember comments count as nodes
//     //$articles[] = array($post->children(3)->outertext, $post->children(6)->first_child()->outertext);


// }





foreach($dom->getElementsByTagName('table') as $table) {


    foreach($table->getElementsByTagName('tr') as $tr) {

        $first_row = true;
        $first_col = true;
        foreach($tr->getElementsByTagName('td') as $td) {


            foreach($td->getElementsByTagName('div') as $div) {
                $val = trim($div->nodeValue);

            }




            if($first_row){
                $first_row =false;
                continue;
            }
            if($first_col){

                $val = trim($td->nodeValue);
                $csv_str.= "\"$val\",";
                $first_col = false;


                //echo "\"$val\",";
                //echo "<br/>";
                //fwrite($file,"\"$val\"\r");

            }else{

                $val2 = trim($td->nodeValue);
                $csv_vals.= "\"$val2\",";
                $first_col = true;
            }

        }

    }

}

fclose($file);
//echo trim($csv_str,",");
//echo "<br/>";
//echo trim($csv_vals,",");

