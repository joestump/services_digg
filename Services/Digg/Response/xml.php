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

require_once 'Services/Digg/Response/Common.php';

/**
 * XML response parser
 *
 * XML responses are, technically, supported by this package, but only bug 
 * fixes will be handled. Consider this deprecated and unsupported by the
 * developers.
 *
 * @author      Joe Stump <joe@joestump.net>
 * @category    Services
 * @package     Services_Digg
 * @deprecated
 */
class Services_Digg_Response_xml extends Services_Digg_Response_Common
{
    /**
     * Parse the response
     *
     * @access      public
     * @return      object      Instance of SimpleXMLElement
     * @throws      Services_Digg_Exception
     */
    public function parse()
    {
        if (!function_exists('simplexml_load_string')) {
            throw new Services_Digg_Response_Exception('simplexml_load_string() not found');
        }

        $xml = @simplexml_load_string($this->response);
        if (!$xml instanceof SimpleXmlElement) {
            throw new Services_Digg_Response_Exception('Could not parse XML response');
        }

        if ((isset($xml['code']) && is_numeric($xml['code'])) && 
            (isset($xml['message']) && strlen($xml['message']))) {
            throw new Services_Digg_Response_Exception((string)$xml['message'], (int)$xml['code']);
        }

        return $xml;
    }
}

?>
