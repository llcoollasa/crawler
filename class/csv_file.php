<?php
/*
 * @author lasantha Indrajith<hellolasantha@gmail.com>
 * @purpose testing and education purpose only
 * @Description CSV file manipulation class
 *
 */
class CSVFile{

    private $header;
    private $data;
    private $csvFileName;
    private $finalData;

    public function __construct($file='content.csv'){
        $this->header = array();
        $this->data = array();
        $this->csvFileName = $file;
    }

    public function passData($content){
        $this->appendHeader($content["header"]);
        $this->appendData($content["data"]);
    }

    private function appendHeader($header){

        foreach($header as $key=>$val){

            if(!array_key_exists($key,$this->header)){
                $this->header[$key] = $val;
            }

        }
    }

    private function appendData($data){

        $record = array();
        foreach($data as $key=>$val){

            if(is_array($val)){
                $val= implode(",",$val);
            }
            array_push($record,$val);

        }
        $this->data[]=$record;
        $record=null;
    }

    public function getHeader(){
        return $this->header;
    }

    public function getData(){

        $final_header = array();
        $final_header[] = $this->header;
        $this->finalData = array_merge($final_header, $this->data);

        return $this->finalData;
    }

    public function exportCsv(){

        $fp = fopen($this->csvFileName, 'w');
        $this->getData();
        foreach ($this->finalData as $key=>$val) {
            fputcsv($fp, $val);
        }
        fclose($fp);
    }
}