<?php

namespace OnionSkin;
/**
 * Utilities for handling ini files.
 */
class UtilsINI
{
	public static function write_ini_file($assoc_arr, $path, $has_sections)
        {
            $content = '';

            if (!$handle = fopen($path, 'w'))
                return FALSE;

            self::_write_ini_file_r($content, $assoc_arr, $has_sections);

            if (!fwrite($handle, $content))
                return FALSE;

            fclose($handle);
            return TRUE;
        }

        private static function _write_ini_file_r(&$content, $assoc_arr, $has_sections)
        {
            foreach ($assoc_arr as $key => $val) {
                if (is_array($val)) {
                    if($has_sections) {
                        $content .= "[$key]\n";
                        self::_write_ini_file_r($content, $val, false);
                    } else {
                        foreach($val as $iKey => $iVal) {
                            if (is_int($iKey))
                                $content .= $key ."[] = $iVal\n";
                            else
                                $content .= $key ."[$iKey] = $iVal\n";
                        }
                    }
                } else {
                    $content .= "$key = $val\n";
                }
            }
        }
}