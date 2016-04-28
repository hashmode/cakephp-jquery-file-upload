<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakephpJqueryFileUpload\Console;

use Composer\Script\Event;
use Exception;

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer
{

    public static function postUpdate(Event $event)
    {
        if (!defined('DS')) {
        	define('DS', DIRECTORY_SEPARATOR);
        }
        
        $thisVendorDir = dirname(dirname(__DIR__));
        $vendorDir = dirname(dirname($thisVendorDir));
        $rootDir = dirname($vendorDir);
        
        $io = $event->getIO();
        if (self::copyElfidnerFiles($thisVendorDir, $vendorDir)) {
        	$io->write('Bluemp Jquery File Upload files have been succesfully copied');
            return true;
        }
        
        throw new Exception('Could not copy files');
        return false;
    }

    
    public static function copyElfidnerFiles($thisVendorDir, $vendorDir)
    {
        
        $jqueryFileUploadDir = $vendorDir . DS . 'blueimp' . DS . 'jquery-file-upload';
        $webrootDir = $thisVendorDir . DS . 'webroot';
        
        // copy files
        if (self::copyall($jqueryFileUploadDir . DS . 'css', $webrootDir . DS . 'css')
            && self::copyall($jqueryFileUploadDir . DS . 'js', $webrootDir . DS . 'js')
            && self::copyall($jqueryFileUploadDir . DS . 'img', $webrootDir . DS . 'img') ) {
            return true;
        }        
        
        throw new Exception('Can not copy jquery file upload files');
    }
	
    
    public static function copyall($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        
        $status = true;
        while (($file = readdir($dir)) !== false) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . DS . $file)) {
                    if (self::copyall($src . DS . $file, $dst . DS . $file)) {
                        ;
                    } else {
                        $status = false;
                        break;
                    }
                } else {
                    if (copy($src . DS . $file, $dst . DS . $file)) {
                        ;
                    } else {
                        $status = false;
                        break;
                    }
                }
            }
        }
        closedir($dir);

        return $status;
    }
    
}
