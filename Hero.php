<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/23
 * Time: 16:47
 */

namespace Dota;
include("HeroAttribute.php");

class Hero
{
    public $name_cn,$name_en,$name_short;//英雄名
    public $nick_name;//英雄别称
    public $bio,$bio_img;//英雄简介
    public $img_sb,$img_lg,$img_vert,$icon;//英雄图标
    public $ac;//攻击类型 近战-远程
    public $roles;//英雄定位
    public $attr;//英雄属性

    public $abilities;//技能

    function __construct($name)
    {
        $this->name_en=$name;
        $this->nick_name=array();
        $this->attr=new HeroAttribute();
        $this->abilities=array();
    }

    function __tostring(){//在类中定义一个__toString方法
        $str="";
        $str.="name_en:".$this->name_en.";";
        $str.="name_cn:".$this->name_cn.";";
        $str.="img_sb:".$this->img_sb.";";
        $str.="img_lg:".$this->img_lg.";";
        $str.="img_vert:".$this->img_vert.";";
        $str.="icon:".$this->icon.";";
        $str.="bio:".$this->bio.";";
        $str.="ac:".$this->ac.";";
        if(count($this->roles)>0)
        {
            $s="icon:";
            foreach($this->roles as $role)
            {
               $s.=$role." ";
            }
            $str.=$s.";";
        }
        return $str;
    }

}