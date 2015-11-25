<?php
/**
 * Created by PhpStorm.
 * User: OneRice
 * Date: 2015/11/23
 * Time: 17:04
 * @name 英雄属性类
 */

namespace Dota;

class HeroAttribute
{
    var $str;//力量
    var $str_g;//力量成长
    var $agi;//敏捷
    var $agi_g;//敏捷成长
    var $int;//智力
    var $int_g;//智力成长
    var $pa;//英雄类型 力量-敏捷-智力
    var $camp;//阵营 天辉-夜魇

    var $ac;//攻击类型 近战-远程
    var $a_max;//攻击伤害上限
    var $a_min;//攻击伤害下限
    var $as;//攻击速度
    var $at;//攻击间隔 s
    var $ad;//攻击范围
    var $bv;//弹道速度

    var $armor;//护甲
    var $ms;//移速

    var $ken_day;//白天视野范围
    var $ken_night;//晚上视野范围

    function to_array(){//返回数组
        $attr=array(
            'str'=>$this->str,
            'str_g'=>$this->str_g,
            'agi'=>$this->agi,
            'agi_g'=>$this->agi_g,
            'int'=>$this->int,
            'int_g'=>$this->int_g,
            'pa'=>$this->pa,
            'camp'=>$this->camp,
            'a_max'=>$this->a_max,
            'a_min'=>$this->a_min,
            'ac'=>$this->ac,
            'as'=>$this->as,
            'at'=>$this->at,
            'ad'=>$this->ad,
            'bv'=>$this->bv,
            'armor'=>$this->armor,
            'ms'=>$this->ms,
            'ken_day'=>$this->ken_day,
            'ken_night'=>$this->ken_night
        );
       return $attr;
    }
}