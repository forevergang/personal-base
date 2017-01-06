<?php
$pwd = '01234578';
$pwd = '0123457q';
$pwd = 'abcdefgh1111';
$pwd = '!@#$%^&*q1';
$pwd = '00000000.';

//判断是否为数值型
$isnumeric = is_numeric($pwd) ? true : false;
//匹配纯数字
$_isnumeric = preg_match("/^[0-9]*$/", $pwd);
//计算长度
$pwdlength = strlen($pwd);
//匹配纯字母
$letter = preg_match("/^[a-zA-Z\s]+$/", $pwd);
//匹配特殊字符
$special_characters = preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $pwd);

if ($special_characters) {
    // 是否含有数字
    $shu = preg_match('/\d+/', $pwd);
    // 是否含有字母
    $zimu = preg_match('/[A-Za-z]/', $pwd);
    if (!$shu and !$zimu) {
        echo "无数字无字母";
    }
}
if ($isnumeric || $_isnumeric || $pwdlength < 8 || $pwdlength > 16 || $letter) {
    die('密码由8-16位英文字母、数字或符号组成！');
} else {
    die('成立');
}