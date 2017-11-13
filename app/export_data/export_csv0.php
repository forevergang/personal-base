<?php
/**
 * 导出(csv)
 * @data 导出数据
 * @headlist 第一行,列名
 * @fileName 输出Excel文件名
 */
function csv_export($data = array(), $headlist = array(), $fileName) {

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
    header('Cache-Control: max-age=0');

    //打开PHP文件句柄,php://output 表示直接输出到浏览器
    $fp = fopen('php://output', 'a');
    //输出Excel列名信息
    foreach ($headlist as $key => $value) {
        //CSV的Excel支持GBK编码，一定要转换，否则乱码
        $headlist[$key] = iconv('utf-8', 'gbk', $value);
    }

    //将数据通过fputcsv写到文件句柄
    fputcsv($fp, $headlist);
    //计数器
    $num = 0;
    //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
    $limit = 100000;
    //逐行取出数据，不浪费内存
    $count = count($data);
    for ($i = 0; $i < $count; $i++) {

        $num++;
        //刷新一下输出buffer，防止由于数据过多造成问题
        if ($limit == $num) {
            flush();
            if (ob_get_level() > 0) {
                ob_flush();
            }
            $num = 0;
        }
        $row = $data[$i];
        foreach ($row as $key => $value) {
            $row[$key] = iconv('utf-8', 'gbk', $value);
        }
        fputcsv($fp, $row);
    }
}

$pdo = NULL;
try {

    $dsn = "mysql:host=127.0.0.1;dbname=test";
    $pdo = new PDO($dsn, 'root', '123456', array(PDO::ATTR_PERSISTENT => TRUE)); //TRUE 是长链接
    $pdo->query("SET NAMES UTF8");
} catch (Exception $e) {
    die("Connect Error" . mysql_error());
}
$sql      = "SELECT * FROM `user` limit 10";
$result   = $pdo->query($sql);
$rows     = $result->fetchAll(PDO::FETCH_ASSOC);
$headlist = array(
    'id'      => '标号',
    'title'   => '标题',
    'name'    => '姓名',
    'addtime' => '添加时间',
);
$fileName = '数据列表';
// 导出数据
csv_export($rows, $headlist, $fileName);