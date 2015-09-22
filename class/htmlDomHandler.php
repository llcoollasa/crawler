<?php
/*
 * @author lasantha Indrajith<hellolasantha@gmail.com>
 * @purpose testing and education purpose only
 * @Description html DOM manipulation class
 *
 */
require_once 'simple_html_dom.php';
require_once 'request.php';

class HtmlDomHandler{

    private $url;
    private $ids;

    public function __construct($url){
        $this->url= $url;
    }

    public function getSelectedIds($pages,$from=0){

        $this->ids = array();

        for($i=$from; $i <= $pages; $i++){
            $ids =  $this->getIds($i);
            $this->ids = array_merge($this->ids,$ids);
        }
        return $this->ids;
    }

    public function getIds($page){

        $id_params=null;
        $id_params = array('hpe'=>'OOB');
        $req = new Request($this->url,$id_params,$page);
        $result = $req->call();

        $ids = array();

        $html = new simple_html_dom();
        $html->load($result);

        $result = null;

        $items = $html->find('div[id=searchResultHead]');

        foreach ($items as $key => $value) {

            $maps = new simple_html_dom();
            $maps->load($value);
            $map = $maps->find('a[onclick]');

            $name = $maps->find('td[class=no-border font15px]');

            $i=0;
            foreach ($name as $k => $v) {

                $v = $v->innertext;
                $variable = trim(substr($v, 0, strpos($v, "(")));
                $ids[$i] = array("name"=>$variable);
                $i++;
            }

            $i=0;
            foreach ($map as $k => $v){

                $val = trim($v->attr['onclick']);
                $val = preg_replace('/viewMoreDetails\\(\'/', ' ',$val);
                $val = preg_replace('/\\); return false[\';]*/', ' ',$val);
                $val = trim($val);
                $val = trim($val,"'");

                if(preg_match('/^[A-Z0-9]+$/',$val)){
                    //array_push($ids,$val);
                    //array_push($ids,array("reg"=>$val));
                    //$ids[$val] = $variable;
                    $ids[$i] = array("reg"=>$variable);
                    $i++;
                }
            }
            $maps=null;
        }

        $html = null;
        $items = null;

        return $ids;
    }

    public function getDetails($url,$reg){

        $content = array();
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

        $req = new Request($url,$fields,NULL);
        $result = $req->call();

        $html = new simple_html_dom();
        $html->load($result);

        $name = $html->find('div[class=table-head]');

        var_dump($name);
        die();

        //headers
        $items = $html->find('td[class=no-border table-title]');

        $count =0;

        foreach ($items as $key => $value) {
            $val = trim($value->innertext);

            $val = str_replace("&nbsp;", " ", $val);
            $val = preg_replace('/\\s+/', ' ',$val);
            $content["header"][$count]=$val;
            $count++;
        }

        //data
        $items = $html->find('td[class=no-border table-data]');

        $count =0;
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
                    $val = preg_replace('/openOneMap\\(\'/', ' ',$val);
                    $val = preg_replace('/\\); return false[;]*/', ' ',$val);
                    $val = trim($val);
                    $val = trim($val,"'");
                    $content["data"][$count][]=$val;
                }
            }else{
                $content["data"][$count]=$val;
            }
            $maps=null;
            $count++;
        }
        return $content;
    }
}
