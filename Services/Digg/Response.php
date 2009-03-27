<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Response framework for Digg API
 *
 * PHP version 5.1.0+
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 * @copyright   1997-2007 The PHP Group
 * @license     http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version     CVS: $Id:$
 * @link        http://pear.php.net/package/Services_Digg
 */

require_once 'Services/Digg/Response/Exception.php';

/**
 * Services_Digg
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 * @abstract
 */
abstract class Services_Digg_Response
{
    /**
     * Create a response instance
     *
     * @access      public
     * @param       string      $type       Type of response to create
     * @param       string      $response   Raw response from API
     * @throws      Services_Digg_Exception
     */
    static public function factory($type, $response) {
        $file = 'Services/Digg/Response/' . $type . '.php';
        if (!include_once($file)) {
            throw new Services_Digg_Response_Exception('Unable to load response file: ' . $type);
        }

        $class = 'Services_Digg_Response_' . $type;
        if (!class_exists($class)) {
            throw new Services_Digg_Response_Exception('Unable to find response class: ' . $class);
        }

        $instance = new $class($response);
        return $instance;
    }
}

?>
