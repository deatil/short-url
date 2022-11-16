<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Webman\Http;

use Webman\App;
use Throwable;

/**
 * Class Response
 * @package Webman\Http
 */
class Response extends \Workerman\Protocols\Http\Response
{
    /**
     * @var Throwable
     */
    protected $_exception = null;

    /**
     * @param string $file
     * @return $this
     */
    public function file(string $file)
    {
        if ($this->notModifiedSince($file)) {
            return $this->withStatus(304);
        }
        return $this->withFile($file);
    }

    /**
     * @param string $file
     * @param string $download_name
     * @return $this
     */
    public function download(string $file, string $download_name = '')
    {
        $this->withFile($file);
        if ($download_name) {
            $this->header('Content-Disposition', "attachment; filename=\"$download_name\"");
        }
        return $this;
    }

    /**
     * @param string $file
     * @return bool
     */
    protected function notModifiedSince(string $file)
    {
        $if_modified_since = App::request()->header('if-modified-since');
        if ($if_modified_since === null || !($mtime = \filemtime($file))) {
            return false;
        }
        return $if_modified_since === \gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
    }

    /**
     * @param Throwable $exception
     * @return Throwable
     */
    public function exception($exception = null)
    {
        if ($exception) {
            $this->_exception = $exception;
        }
        return $this->_exception;
    }
}
