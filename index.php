<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/23
 * Time: 14:49
 */

include('GetHeroInfo.php');
include('GetHeros.php');

$heros_url=get_heros();

for($i=0;$i<count($heros_url);$i++) {
    $hero_name=explode('/',$heros_url[$i])[4];
    $hero = get_hero($hero_name);

    $file_path = 'data/hero/';
    $bio = $file_path . 'bio/';
    $json = $file_path . 'json/';
    $sb = $file_path . 'sb/';
    $lg = $file_path . 'lg/';
    $vert = $file_path . 'vert/';
    $icon = $file_path . 'icon/';

    //bio-img
    if ($img = file_get_contents($hero->bio_img)) {
        file_put_contents($bio . $hero_name . '_bio.jpg', $img);
    }
    //img-vert
    if ($img = file_get_contents($hero->img_vert)) {
        file_put_contents($vert . $hero_name . '_vert.jpg', $img);
    }
    //img-sb
    if ($img = file_get_contents($hero->img_sb)) {
        file_put_contents($sb . $hero_name . '_sb.png', $img);
    }
    //img-lg
    if ($img = file_get_contents($hero->img_lg)) {
        file_put_contents($lg . $hero_name . '_lg.png', $img);
    }
    //icon
    if ($img = file_get_contents($hero->icon)) {
        file_put_contents($icon . $hero_name . '.png', $img);
    }
    //json
    file_put_contents($json . $hero_name . '.json', $hero->to_json());

    echo 'get ' . $hero_name . '    state:OK!   runtime:' . get_runtime($stime) . '
';
}


