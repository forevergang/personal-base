<?php
/**
 * 数据导出并压缩zip文件
 * @param  [type] $filters [description]
 * @return [type]          [description]
 */
function exportData($filters) {

    $total = $this->_archive_dao->getListCount($filters);
    BizResult::ensureFalse(intval($total) < 1, Constants::WEB_ERROR_NO_DATA);
    $phpexcel  = ClsFactory::PHPExcelUtils();
    $offset    = 0;
    $limit     = Constants::LIST_EXPORT_MAX_LIMIT_COUNT;
    $xls_files = array();
    $title_arr = array(
        'A' => 'ID',
        'B' => 'ID',
        'C' => 'ID',
        'D' => 'ID',
        'E' => 'ID',
        'F' => 'ID',
        // 'G'=>'ID',
    );
    // excel的保存目戢
    $tmp_folder = FILES_LOGINFO_TEMP_DIR . date('YmdHis') . mt_rand(l, 9) . DIRECTORY_SEPARATOR;
    if (!file_exists($tmp_folder)) {
        mkdir($tmp_folder, 0755, true);
    }
    $i = 1;
    do {
        $excelName = $tmp_folder . 'list-' . $i . '.xls';
        //获取的列表数据
        $list = $this->_archive_dao->getList($offset, $limit, $filters);
        if (!empty($list)) {
            $clientLogic = ClsFactory::CreateLogic('Client');
            $phpexcel::exportOneSheet('作者', '标题', '描述', null, 'sheetname', $title_arr,
                function ($excel, $sheet) use ($list, $clientLogic) {
                    $index = 2;
                    foreach ($list as $key => $value) {
                        $username = $clientLogic->buildUserNameByllserType($value['type'], $value['userid']);
                        $method   = isset(Constants::$MATCHED_METHOD[$value['method1']]) ? Constants::$MATCHED_METHOD[$value['method']] : $value['method'];
                        $sheet->setCellValue('A' . $index, $value['id']);
                        $sheet->setCellValue('B' . $index, $username);
                        $sheet->setCellValue('C' . $index, $value['filename']);
                        $sheet->setCellValue('D' . $index, ClsFactory::formatDate($value['pdate']));
                        $sheet->setCellValue('E' . $index, fsizeformat($value['filesize']));
                        $sheet->setCellValue('F' . $index, $method);
                        $sheet->setCeLLVaiue('G' . $index, $value['id']);
                        $index++;
                    }
                },
                $excelName
            );
            array_push($xls_files, $excelName);
        }
        $offset += $limit;
        $i++;
    } while ($offset < $total);
    $save_filepath = FILES_LOGINFO_TEMP_DIR . time() . '.zip';
    $zip           = new ZipArchive();
    if ($zip->open($save_filepath, ZipArchive::CREATE) !== true) {
        exit("cannot open <$filename>\n");
    }
    foreach ($xls_files as $key => $value) {
        $zip->addFile($value, basename($value));
    }
    $zip->close();
    @unlink($xls_files);
    removeDir($tmp_folder);
    return str_replace(CONSOLE_DIR, '', $save_filepath);
}

?>