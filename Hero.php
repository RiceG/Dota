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
    public $roles;//英雄定位 array
    public $attr;//英雄属性

    public $abilities;//技能

    function __construct($name)
    {
        $this->name_en=$name;
        $this->nick_name=array();
        $this->attr=new HeroAttribute();
        $this->abilities=array();
    }

    function to_array(){
        $attr=array(
            "name_en"=>$this->name_en,
            "name_cn"=>$this->name_cn,
            "name_short"=>$this->name_short,
            "nick_name"=>$this->nick_name,
            "bio"=>$this->bio,
            "bio_img"=>$this->bio_img,
            "img_sb"=>$this->img_sb,
            "img_lg"=>$this->img_lg,
            "img_vert"=>$this->img_vert,
            "icon"=>$this->icon,
            "img_sb"=>$this->img_sb,
            "attr"=>$this->attr->to_array()
        );
        return $attr;
    }

    function to_json(){
        return json_encode($this->to_array());
    }

    function __tostring(){//在类中定义一个__toString方法
        $str=serialize($this->to_array());
        return $str;
    }

}