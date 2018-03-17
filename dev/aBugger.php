<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 20-11-2016
 * Time: 13:15
 */

$fn = 'elapsus.private.log';
$file_paths = debug_backtrace();
foreach ($file_paths as $file_path):
    foreach ($file_path as $key => $var):
        if ($key == 'args') {
            foreach ($var as $key_arg => $var_arg):
                $content = $key_arg . ':' . $var_arg . '<br/>';
                $fp = fopen($fn, "w+") or die ("Error opening file in write mode!");
                fputs($fp, $content);
                fclose($fp) or die ("Error closing file!");
            endforeach;
        } else {
            $content = $key . ':' . $var . '<br/>';
            $fp = fopen($fn, "w+") or die ("Error opening file in write mode!");
            fputs($fp, $content);
            fclose($fp) or die ("Error closing file!");
        }
    endforeach;
endforeach;