<?php
/**
 * Created by PhpStorm.
 * User: shara
 * Date: 01.02.2016
 * Time: 18:55
 * @param $arg
 */


function test_dump($arg){
    global $USER;

    if($USER->IsAuthorized()){
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }
}