<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/23
 * Time: 14:49
 */

function get_heros()
{
    $urlTarget='http://www.dota2.com.cn/heroes/index.htm';
    //$urlTarget = 'E:/heros.html';

    //建立Dom对象，分析HTML文件；
    $htmDoc = new DOMDocument;
    $htmDoc->loadHTMLFile($urlTarget);

    //获取英雄列表
    $hero_uls = $htmDoc->getElementsByTagName("ul");
    //echo $ul_count=$hero_uls->length;

    //遍历各阵营
    $heros_url = array();
    foreach ($hero_uls as $hero_ul) {
        //先去除不是英雄列表的ul节点
        if ($hero_ul->getAttribute('class') == 'hero_list') {
            //获取单个英雄的li节点
            $hero_lis = $hero_ul->getElementsByTagName("li");
            //echo $hero_lis->length;

            //遍历各阵营下英雄，并去除阵营标识 力量-敏捷-智力
            foreach ($hero_lis as $hero_li) {
                //带class的为阵营标识
                if (!$hero_li->getAttribute('class')) {
                    //获取各个英雄资料的页面url
                    $heros_url[] = $hero_li->getElementsByTagName('a')->item(0)->getAttribute('href');
                }
            }
        }
    }

    return $heros_url;
}

var_dump(get_heros());