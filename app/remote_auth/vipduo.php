<?php
if ($_GET['doamin']) {
    $domain  = $_GET['doamin'];
    $doamins = array(
        '0' => '127.0.0.1',
        '1' => 'vipduo.com', //终身版
        '2' => 'html.com', //2015-1-22
        '3' => 'imiaozhe.com', //终身版
        '4' => 'shangzj.cn', //2016.1.18
        '5' => 'haergou.com', //终身版
        '6' => 'duoduodazhe.com', //2016.1.8
        '7' => 'weilifan.com', //终身版
    );
    $do  = explode(".", $domain);
    $num = count($do);
    if ($num == 3) {
        $domain = $do['1'] . '.' . $do['2'];
    }
    if (in_array($domain, $doamins)) {
        $msg = array(
            'code' => 200,
        );
    } else {
        $msg = array(
            'code' => 0,
        );
    }
}
echo json_encode($msg);
?>