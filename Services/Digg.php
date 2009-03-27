<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * API for Digg's web services
 *
 * PHP version 5.1.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is 
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive  
 * a copy of the New BSD License and are unable to obtain it through the web, 
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 * @copyright   2007 Digg.com, Inc.
 * @license     http://www.opensource.org/licenses/bsd-license.php 
 * @version     CVS: $Id:$
 * @link        http://pear.php.net/package/Services_Digg
 */ 

require_once 'Services/Digg/Common.php';
require_once 'Services/Digg/Exception.php';

/**
 * Services_Digg
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 * @link        http://apidoc.digg.com/ToolkitsServicesDigg
 * @link        http://groups.google.com/group/diggapi
 */
abstract class Services_Digg 
{
    /**
     * Digg API URI
     *
     * @access      protected
     * @var         string      $uri
     * @static
     */
    static public $uri = 'http://services.digg.com';    

    /**
     * Your API Key
     *
     * The value of the appKey argument must be a URI that idenfitifes the 
     * application making the request. The URI might point to:
     *
     * - The application itself, if it's a web application.
     * - A web page describing the application.
     * - A web page offering the application for download.
     * - The author's web site.
     *
     * @access      public
     * @var         string      $appKey
     * @static
     */
    static public $appKey = null;

    /**
     * Create digg services
     *
     * @access      public
     * @param       string      $endPoint
     * @return      mixed       PEAR_Error on failure, service on success
     */
    static public function factory($endPoint) 
    {
        $file = 'Services/Digg/' . $endPoint . '.php';
        if (!include_once($file)) {
            throw new Services_Digg_Exception('Endpoint file not found: ' . $file);
        }

        $class = 'Services_Digg_' . $endPoint;
        if (!class_exists($class)) {
            throw new Services_Digg_Exception('Endpoint class not found: ' . $class);
        }

        $instance = new $class();
        return $instance;
    }
}

?>
