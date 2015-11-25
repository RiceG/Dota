<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/23
 * Time: 19:23
 */
$stime=microtime(true); //获取程序开始执行的时间
$hero_name='axe';
//include('Util/simple_html_dom.php');
include('Hero.php');
$hero=new \Dota\Hero($hero_name);

//error handler function
function customError($errno, $errstr)
{
    echo "HTML异常！";
    //die();
}

//set error handler
set_error_handler("customError",E_WARNING);
error_reporting(0);

$url='http://db.dota2.com.cn/hero/'.$hero_name.'/';
$urlTarget="E:/Earthshaker.html";

function get_content($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
    $output=curl_exec($ch);
    curl_close($ch);
    return $output;
    //return mb_convert_encoding($output,"gbk","UTF-8");
}

function match($content){
    $rule="";
}

//$content='<div name="hero_01" >211234</div>';

$content=get_content($url);
$rule=array('/name=\"hero_[0-9]{2}\"/');
$html= preg_replace($rule,array(""),$content);
//$rule=array('/name=\"hero_[0-9]{2}\"/','/[\s]*<!--[\S]*?-->[\s]*/','/[\s]*\r?\n[\s]*/');
//$html= preg_replace($rule,array("","",""),$content);
//$r=preg_match_all("/(?<=>)[\s]+(?=<)/",$content,$rr);
//var_dump($rr);

//echo $html;
//建立Dom对象，分析HTML文件；
$htmDoc = new DOMDocument;
//$htmDoc->loadHTMLFile($urlTarget);
$htmDoc->preserveWhiteSpace=false;
$htmDoc->loadHTML($html);


$divs=$htmDoc->getElementsByTagName("div");

foreach($divs as $div) {
    /***********************hero_info***********************/
    if($div->getAttribute("class")&&$div->getAttribute('class')=="hero_info") {

        echo $div->getAttribute("class") . ':';
        //$es = $div;
        $name = $div->childNodes;
        echo $name->length;
        //英雄图标
        $hero->img_vert = $name->item(1)->getAttribute("src");
        echo '
        [img_vert]:' . $hero->img_vert;
        //英雄中文名
        $d1 = $name->item(2);
        $hero->name_cn = $d1->textContent;
        $hero->icon = $d1->childNodes->item(0)->getAttribute("src");
        echo '
        [img_icon]:' .$hero->icon;
        echo '
        [hero_name]:' . $hero->name_cn;
        //英雄信息
        $d2lis = $name->item(4)->childNodes;
        $acs = $d2lis->item(0)->getElementsByTagName('span');//攻击类型
        $hero->ac = $acs->item(1)->textContent;
        echo '
        [ac]:' . $hero->ac ;
        $roles = $d2lis->item(2)->getElementsByTagName('span');//定位
        $roles_n = $roles->length;
        echo '
        [roles]:' . $roles->item(0)->textContent;
        for ($i = 1; $i < $roles_n; $i++) {
            $hero->roles[]=$roles->item($i)->textContent;
            echo $roles->item($i)->textContent . ' ';
        }
        $camp = $d2lis->item(4)->getElementsByTagName('p');//阵营
        $hero->attr->camp=$camp->item(0)->textContent;
        echo '
        [camp]:' . $hero->attr->camp;
        $nick_name = $d2lis->item(6)->getElementsByTagName('p');//小名
        $hero->nick_name=$nick_name->item(0)->textContent;
        echo '
        [nick_name]:' . $hero->nick_name;
    }
    else if($div->getAttribute("class")&&$div->getAttribute('class')=="property_box")
    {
        echo '
'.$div->getAttribute("class") . ':';
        //$es = $div;
        $name = $div->childNodes;
        /*echo $name->length;
        foreach($name as $child){
            echo '['.$child->nodeName.']';
        }*/
        //英雄属性
        $lis=$name->item(3)->getElementsByTagName("li");
        //echo '【'.$lis->length.'】';
        //------------力量-----------------
        $str=$lis->item(0)->childNodes;
        echo $str->length;
        foreach($str as $child){
            echo '['.$child->nodeName.']';
        }
        $arr=explode(" + ",trim($str->item(2)->textContent));
        $hero->attr->str=$arr[0];
        $hero->attr->str_g=$arr[1];
        if(strstr($str->item(3)->textContent,"主要")){
            $hero->attr->pa="str";
        }
        echo '
        力量：'.$hero->attr->str.' + '.$hero->attr->str_g;
        //------------敏捷-----------------
        $str=$lis->item(1)->childNodes;
        $arr=explode(" + ",trim($str->item(2)->textContent));
        $hero->attr->agi=$arr[0];
        $hero->attr->agi_g=$arr[1];
        if(strstr($str->item(3)->textContent,"主要")){
            $hero->attr->pa="agi";
        }
        echo '
        敏捷：'.$hero->attr->agi.' + '.$hero->attr->agi_g;
        //------------智力-----------------
        $str=$lis->item(2)->childNodes;
        $arr=explode(" + ",trim($str->item(2)->textContent));
        $hero->attr->int=$arr[0];
        $hero->attr->int_g=$arr[1];
        if(strstr($str->item(3)->textContent,"主要")){
            $hero->attr->pa="int";
        }
        echo '
        智力：'.$hero->attr->int.' + '.$hero->attr->int_g."   ".$hero->attr->pa."英雄";
        //攻击
        $str=$lis->item(3)->getElementsByTagName("p")->item(0);
        $arr=explode("：",trim($str->textContent));
        //var_dump($arr);
        //攻击---速度
        $as=explode("（",$arr[1]);
        $hero->attr->as=$as[0];
        $hero->attr->at=explode("秒",$as[1])[0];
        //攻击---伤害
        $dmg=explode("-",$arr[2]);
        $hero->attr->a_min=$dmg[0];
        $hero->attr->a_max=explode("\r\n",$dmg[1])[0];
        //echo $hero->attr->a_min.'-'.$hero->attr->a_max;
        //攻击---距离
        echo $dmg[3];
        //护甲
        $str=$lis->item(4)->textContent;
        $hero->attr->armor=explode("\r\n",trim($str))[0];
        //移速
        $str=$lis->item(5)->textContent;
        $hero->attr->armor=trim($str);
}
    else if($div->getAttribute("class")&&$div->getAttribute('class')=="area_box"){
        $str=$div->getElementsByTagName("span");
        /*echo $str->length;
        foreach($str as $child){
            echo '['.$child->nodeName.']:'.$child->textContent;
        }*/
        $ken=explode("/",$str->item(0)->textContent);
        $hero->attr->ken_day=$ken[0];
        $hero->attr->ken_night=$ken[1];
        $hero->attr->ad=$str->item(1)->textContent;
        $hero->attr->bv=$str->item(2)->textContent;
    }
    else if($div->getAttribute("class")&&$div->getAttribute('class')=="story_box h120"){
        $hero->bio=trim($str=$div->textContent);
        $hero->bio_img=$div->childNodes->item(1)->childNodes->item(0)->getAttribute('href');
    }
}
//echo $hero;
get_runtime($stime);


//$html=file_get_html($urlTarget);
//$es = $html->find('div[class=w1002]',0);
//$left=$es->children(1);
//$right=$es->children(3);
//$l1= $left->children(1)->children(1);
//echo $l1->plaintext;

function get_runtime($stime)
{
    $etime=microtime(true);//获取程序执行结束的时间
    $total=$etime-$stime;   //计算差值

    $str_total = var_export($total, TRUE);
    if(substr_count($str_total,"E")){
        $float_total = floatval(substr($str_total,5));
        $total = $float_total/100000;
        echo '
        运行时间：'.$total.'秒';
    }
    else{
        echo '
        运行时间：'.$total.'秒';
    }
}