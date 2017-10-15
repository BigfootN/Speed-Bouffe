<?php
/**
 * Created by PhpStorm.
 * User: Layer
 * Date: 15/10/2017
 * Time: 19:15
 */

if(isset($HTTP_RAW_POST_DATA)){
    echo 'OK';
    $data = json_decode($HTTP_RAW_POST_DATA);
    print_r($data);
}

