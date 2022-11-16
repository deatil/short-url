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

namespace Webman\Session;

use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use Workerman\Protocols\Http\Session\FileSessionHandler as FileHandler;

/**
 * Class FileSessionHandler
 * @package Webman
 */
class FileSessionHandler extends FileHandler
{

}
