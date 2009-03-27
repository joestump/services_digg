<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * The Services_Digg Exception
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

require_once 'PEAR/Exception.php';

/**
 * Services_Digg_Exception
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Exception extends PEAR_Exception 
{
    /**
     * The the call that likely caused the exception
     *
     * @access      private
     * @var         string      $call
     */
    private $call = '';

    /**
     * The raw response from the API when the exception was called
     *
     * @access      private
     * @var         string      $response
     */
    private $response = '';

    /**
     * Constructor
     *
     * @access      public
     * @param       string      $message
     * @param       int         $code
     * @param       string      $call
     * @param       string      $response
     * @return      void
     */
    public function __construct($message = null, 
                                $code = 0, 
                                $call = '',
                                $response = '') 
    {
        parent::__construct($message, $code);
        $this->call = $call;
        $this->response = $response;
    }

    /**
     * Get the last call that probably caused this exception
     *
     * @access      public
     * @return      string 
     */
    public function getCall()
    {
        return $this->call;
    }

    /**
     * Get the raw API response from the last call
     *
     * @access      public
     * @return      string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * __toString
     *
     * Override the PEAR_Exception::__toString() method with a text-only pretty
     * formatted string with the message, code and API call that generated the
     * exception.
     *
     * @access      public
     * @return      string
     */
    public function __toString()
    {
        return $this->getMessage() . ' (Code: ' . $this->getCode() . ', Call: ' . $this->getCall() . ')'; 
    }
}

?>
