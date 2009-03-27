<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Common class for Digg API endpoints
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

require_once 'Services/Digg/Response.php';

/**
 * Services_Digg_Common
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
abstract class Services_Digg_Common
{

    /**
     * Last API URI called
     *
     * @access      public
     * @var         string      $lastCall
     */
    public $lastCall = '';

    /**
     * Raw response of last API call
     *
     * @access      public
     * @var         string      $lastResponse
     * @see         Services_Digg_Common::$lastCall
     */
    public $lastResponse = '';

    /**
     * Send a request to the API
     *
     * @access      public  
     * @param       string      $endPoint       Endpoint of API call
     * @param       array       $params         GET arguments of API call
     * @return      mixed
     */
    protected function sendRequest($endPoint, $params = array())
    {
        $uri = Services_Digg::$uri . $endPoint;
        if (!isset($params['type'])) {
            $params['type'] = 'php';
        }

        $params['appkey'] = Services_Digg::$appKey;
        $sets = array();
        foreach ($params as $key => $val) {
            $sets[] = $key . '=' . urlencode($val);
        }

        $uri .= '?' . implode('&', $sets);
        $this->lastCall = $uri;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Services_Digg (' . Services_Digg::$appKey . ')');
        $this->lastResponse = curl_exec($ch);
        curl_close($ch);

        $response = Services_Digg_Response::factory(
            $params['type'], 
            $this->lastResponse
        );

        try {
            return $response->parse();
        } catch (Services_Digg_Response_Exception $e) {
            throw new Services_Digg_Exception($e->getMessage(), $e->getCode(), $this->lastCall, $this->lastResponse); 
        }
    }
}


?>
