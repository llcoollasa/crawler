<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'simple_html_dom.php';


//$reg_nos = array("E0801521J","E0801865A","E0801230J","E0800429D","E0800753F");

$reg_nos = array("E0801521J");


foreach($reg_nos as $reg){
    $ch = curl_init("https://prs.moh.gov.sg/prs/internet/profSearch/getSearchDetails.action");


    //set POST variables
    $url = 'https://prs.moh.gov.sg/prs/internet/profSearch/getSearchDetails.action';
    $fields = array(
        'hpe'=>'OOB',
        'regNo'=>$reg,
        'psearchParamVO.language'=>'eng',
        'psearchParamVO.searchBy'=>'N',
        'psearchParamVO.name'=>'',
        '__checkbox_psearchParamVO.startWith'=>'startWith',
        'psearchParamVO.pracPlaceName'=>'',
        'psearchParamVO.regNo'=>'',
        'selectType'=>'all'
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
    //execute post
    $result = curl_exec($ch);

    curl_close($ch);


    $dom = new DOMDocument();
    @$dom->loadHTML($result);
 


//$elements = $xpath->query("/html/body/div[@id='yourTagIdHere']");
    //$elements = $xpath->query("//*[@id]");
    //$elements = $xpath->query("*/div[@id='yourTagIdHere']");



    $csv_str = "";
    $csv_vals = "";



    // $html = new simple_html_dom();
    // $html->load($result);
    // $items = $html->find('#profDetails');


    // foreach($items as $post) {

    //     var_dump($post->children(0)->outertext);
    //     # remember comments count as nodes
    //     //$articles[] = array($post->children(3)->outertext, $post->children(6)->first_child()->outertext);


    // }


    $file = fopen("content.csv","w");
    

    foreach($dom->getElementsByTagName('table') as $table) {
        

        foreach($table->getElementsByTagName('tr') as $tr) {

            $first_row = true;
            $first_col = true;
            foreach($tr->getElementsByTagName('td') as $td) {

                if($first_row){
                    $first_row =false;
                    continue;
                }
                if($first_col){
 
                    $val = trim($td->nodeValue);
                    $csv_str.= "\"$val\",";
                    $first_col = false; 
                    echo "\"$val\",";
                    echo "<br/>";
                    //fwrite($file,"Hello World. Testing!");

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
}


 