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

namespace support\exception;

use Exception;
use Webman\Http\Response;
use Webman\Http\Request;

/**
 * Class BusinessException
 * @package support\exception
 */
class BusinessException extends Exception
{
    public function render(Request $request): ?Response
    {
        if ($request->expectsJson()) {
            $code = $this->getCode();
            $json = ['code' => $code ? $code : 500, 'msg' => $this->getMessage()];
            return new Response(200, ['Content-Type' => 'application/json'],
                \json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        return new Response(200, [], $this->getMessage());
    }
}
