<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Errors endpoint driver
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
 * Services_Digg_Errors
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Errors extends Services_Digg_Common
{
    /**
     * Get a list of all error codes
     *
     * @access      public
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getAll($params = array())  
    {
        return $this->sendRequest('/errors', $params);                
    }

    /**
     * Get an error by its code
     *
     * @access      public
     * @param       int         $code       Error code to fetch
     * @return      mixed
     * @throws      Services_Digg_Exception
     */
    public function getErrorByCode($code) 
    {
        try {
            return $this->sendRequest('/errors/' . $code);
        } catch (PEAR_Exception $error) {
            return $error; 
        }
    }
}

?>
