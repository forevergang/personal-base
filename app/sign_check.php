<?php
$ucfu_uid     = $_REQUEST['ucfu_uid'];
$user_id      = $_REQUEST['user_id'];
$reg_time     = $_GET['reg_time'];
$order_time   = $_REQUEST['order_time'];
$orders_price = $_GET['orders_price'];
$sign         = $_GET['sign']; //数据签名
$key          = 'hxmxdtz!@#'; //内部定义的签名字符串
//测试地址
//http://127.0.0.1/html/bootstrap/mxd.php?ucfu_uid=1&user_id=2&reg_time=20171201&order_time=20171201&orders_price=100&sign=42db02efc55e26e76d89c1e0243b579f

//加密字符串
$sig = md5($user_id . $key);
if ($sign != $sig) {
    echo "sign_error!";
    exit();
}

//定义收集格式
$content = "{\"注册ID\":" . "\"$ucfu_uid\"" . ",\"用户ID\":" . "\"$user_id\"" . ",\"注册时间\":" . "\"$reg_time\"" . ",\"投资时间\":" . "\"$order_time\"" . ",\"投资金额\":" . "\"$orders_price\"" . "}";
//echo "<br/>";

//文件内容写入
$compile_dir = "./txt.txt";
file_put_contents($compile_dir, $content . PHP_EOL, FILE_APPEND);
echo "msg:success!";

?>

