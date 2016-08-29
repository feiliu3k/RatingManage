<?php

/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * 判断文件的MIME类型是否为Excel
 */
function is_excelfile($mimeType)
{
    if (starts_with($mimeType, 'application/vnd.ms-excel')){
        return true;
    }
    if (starts_with($mimeType, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')){
        return true;
    }

    return false;
}


/**
 * 判断文件的MIME类型是否为Excel
 */
function detectUploadFileMIME($file) {
    // 1.through the file extension judgement 03 or 07
    $flag = 0;
    $file_array = explode ( ".", $file ["name"] );
    $file_extension = strtolower ( array_pop ( $file_array ) );

    // 2.through the binary content to detect the file
    switch ($file_extension) {
        case "xls" :
            // 2003 excel
            $fh = fopen ( $file ["tmp_name"], "rb" );
            $bin = fread ( $fh, 8 );
            fclose ( $fh );
            $strinfo = @unpack ( "C8chars", $bin );
            $typecode = "";
            foreach ( $strinfo as $num ) {
                $typecode .= dechex ( $num );
            }
            if ($typecode == "d0cf11e0a1b11ae1") {
                $flag = 1;
            }
            break;
        case "xlsx" :
            // 2007 excel
            $fh = fopen ( $file ["tmp_name"], "rb" );
            $bin = fread ( $fh, 4 );
            fclose ( $fh );
            $strinfo = @unpack ( "C4chars", $bin );
            $typecode = "";
            foreach ( $strinfo as $num ) {
                $typecode .= dechex ( $num );
            }
            echo $typecode;
            if ($typecode == "504b34") {
                $flag = 1;
            }
            break;
    }

    // 3.return the flag
    return $flag;
}