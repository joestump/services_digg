<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * API for Digg's web services
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

/**
 * Services_Digg
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 * @abstract
 */
abstract class Services_Digg_Response_Common
{
    /**
     * Raw API response
     *
     * @access      protected
     * @var         string      $response       Raw API response
     */
    protected $response = '';

    /**
     * __construct
     * 
     * @access      public
     * @param       string      $response       Raw API response
     * @return      void
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Parse API respone
     *
     * @access      public
     * @return      mixed       PEAR_Error on failure
     * @abstract
     */
    abstract public function parse();
}

?>
