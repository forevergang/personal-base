<?php
if (!defined('INDEX')) {
    //exit('Access Denied');
}
define('VIEW_PAGE', 1);

function allow_doamin() {
    $is_allow    = false;
    $SERVER_NAME = trim($_SERVER['SERVER_NAME']);
    $url         = 'http://yun.vipduo.com/vipduo.php?doamin=' . $SERVER_NAME;
    $result      = get_Contact($url, 10, 'get', true);
    $result      = json_decode($result, true);
    if ($result['code'] == 200) {
        $is_allow = true;
    } else {
        $is_allow = false;
    }
    if (!$is_allow) {
        die('域名未授权,请联系客服QQ授权 2524766924 ');
    } else {
        die(' 恭喜你域名已经授权');
    }
}
allow_doamin();
//远程请求
function get_Contact($url, $timeout = 3, $method = "get", $ssl = false) {
    if (!function_exists('file_get_contents')) {
        ini_set('user_agent', 'MISE 6.0');
        $ct            = stream_context_create(array('http' => array('timeout' => $timeout, "method" => $method)));
        $file_contents = file_get_contents($url, 0, $ct);
    } else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "MISE 6.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        if (curl_errno($ch)) {
            $file_contents = 'curl_error';
        }
        curl_close($ch);
    }
    return $file_contents;
}

//网站前台公告
function dd_article($duoduo, $cid, $num = 4, $fileds = 'id,title') {
    $article = $duoduo->select_all('article', $fileds, 'cid="' . $cid . '" and del=0 order by sort asc,id desc limit 0,' . $num);
    return $article;
}
$chongzhi_url = $ddTaoapi->tdj_zujian(1, $dduser['id']);

//友情链接
$yqlj = dd_link($duoduo, 30, 0);

//合作伙伴
$hzhb = dd_link($duoduo, 30, 1);

$ajax_load_num = $dd_tpl_data['ajax_load_num'];

$bankuai = $duoduo->select_all('bankuai', 'id,title,code,bankuai_tpl,web_cid,yugao,yugao_time,huodong_time', "tuijian=1 and status=1 and del=0 ORDER BY sort=0 ASC,sort asc,id desc");
$t       = array();
foreach ($bankuai as $key => $vo) {
    if ($key == 0) {
        if ($vo['huodong_time']) {
            $vo['huodong_etime'] = strtotime(date('Y-m-d ' . $vo['huodong_time'] . ":00:00", TIME)) + 24 * 3600;
        }
        $first_bankuai = $vo;
        $web_cid       = $vo['web_cid'];
    }
    if (!in_array($vo['bankuai_tpl'], $t)) {
        $css[] = TPLURL . "/goods/" . $vo['bankuai_tpl'] . "/css/list.css";
        $t[]   = $vo['bankuai_tpl'];
    }
}
$web_cid = unserialize($web_cid);
if ($web_cid) {
    $where = "id in(" . implode(',', $web_cid) . ")";
} else {
    $where = " tag='goods' ";
}
if (!empty($web_cid)) {
    $goods_type = $duoduo->select_all("type", "id,title", $where . "  order by sort=0 asc,sort asc,id desc");
}
$yugao_time = date('Y-m-d ' . $bankuai['yugao_time'] . ":00");
if (strtotime($yugao_time) > TIME) {
    $yugao_close = true;
}
?>

