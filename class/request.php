<?php
/*
 * @author lasantha Indrajith<hellolasantha@gmail.com>
 * @purpose testing and education purpose only
 * @Description CURL request class
 *
 */
class Request{

    private $url;
    private $page;
    private $fields;
    private $fields_string;
    private $ch;

    /*
     * @params: array('hpe'=>'OOB')
     */
    public function __construct($url,$params,$page_number='') {

        $this->url = $url;
        $this->fields = null;
        $this->fields = $params;
        foreach($this->fields as $key=>$value) { $this->fields_string .= $key.'='.$value.'&'; }
        $this->fields_string = rtrim($this->fields_string, '&');
        $this->page = $page_number;
    }

    public function call(){

        //init
        $this->ch =null;
        $this->ch = curl_init($this->url);

        //set the url, number of POST vars, POST data
        curl_setopt($this->ch,CURLOPT_URL, $this->url);
        curl_setopt($this->ch,CURLOPT_POST, count($this->fields));
        curl_setopt($this->ch,CURLOPT_POSTFIELDS, $this->fields_string);
        curl_setopt($this->ch,CURLOPT_HEADER, false);
        curl_setopt($this->ch,CURLOPT_RETURNTRANSFER , true);
        if($this->page != NULL) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Cookie: cookie.tableId=DEFAULT;cookie.currentPage=DEFAULT." . $this->page . ";BIGipServerPRS_Inter=4111062794.22528.0000"));
        }

        //result

        $result = curl_exec($this->ch);

        //close the connection
        curl_close($this->ch);

        return $result;

    }

}
