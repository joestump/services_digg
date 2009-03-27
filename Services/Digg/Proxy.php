<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * A proxy for Digg's API
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

require_once 'Services/Digg.php';
require_once 'Services/Digg/Exception.php';

/**
 * Services_Digg_Proxy
 *
 * This allows you to make JSON requests to the Digg API from your own website.
 * Create a PHP script like the one below and then request it in the following
 * manner:
 *
 * http://www.example.com/myproxy.php?endPoint=/errors
 *
 * Replace the endPoint argument with any of the valid endpoints outlined in
 * the Digg API documentation. All other arguments are passed onto the API 
 * without modification.
 *
 * <code>
 * <?php
 *
 * require_once 'Services/Digg/Proxy.php';
 * Services_Digg::$appKey = 'http://www.example.com/myproxy.php';
 * $proxy = new Services_Digg_Proxy();
 * $proxy->proxy();
 *
 * ?>
 * </code>
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net>
 */
class Services_Digg_Proxy 
{
    /**
     * Possible response codes
     *
     * @access      private
     * @var         array       $responseCodes
     */
    private $responseCodes = array('200' => 'OK',
                                   '403' => 'Forbidden',
                                   '404' => 'Not found',
                                   '500' => 'Internal error');

    /**
     * Pass through these headers
     *
     * @access      private
     * @var         array       $passThrough
     */
    private $passThrough = array();

    /**
     * Add additional request headers
     *
     * @access      private
     * @var         array       $requestHeaders
     * @see         Services_Digg_Proxy::addRequestHeader();
     */
    private $requestHeaders = array();

    /**
     * Proxy the request
     *
     * Takes either a GET or POST request and proxies a request to the Digg
     * API via an HTTP_Request.
     *
     * @access      public
     * @return      void
     * @see         HTTP_Request
     */
    public function proxy()
    {
        $req = array_merge($_GET, $_POST); // Support both GET and POST
        if (!isset($req['type'])) {
            $req['type'] = 'json'; // Default to JSON
        }

        if (!isset($req['appkey'])) {
            $req['appkey'] = Services_Digg::$appKey;
        }

        $endPoint = '';
        if (isset($req['endPoint'])) {
            $endPoint = $req['endPoint'];
            unset($req['endPoint']);
        }

        $sets = array();
        foreach ($req as $key => $val) {
            $sets[] = $key . '=' . urlencode($val);
        }

        $uri = Services_Digg::$uri . $endPoint . '?' . implode('&', $sets);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 
                    'Services_Digg_Proxy (' . Services_Digg::$appKey . ')');

        if (isset($_SERVER['HTTP_REFERER'])) {
            curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
        }

        $h = $this->requestHeaders;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $h[] = 'X-Forwarded-For: ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $h[] = 'X-Forwarded-For: ' . $_SERVER['REMOTE_ADDR'];
        }

        if (count($h)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
        }

        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, 'passHeaders'));

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Services_Digg_Exception(curl_error($ch), curl_errno($ch));
        }

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        
        if (isset($this->responseCodes[$code])) {
            header('HTTP/1.1 ' . $code . ' ' . $this->responseCodes[$code]);
        }

        foreach ($this->passThrough as $header) {
            if (strlen($header)) {
                header($header);
            }
        }

        echo $response;
        curl_close($ch);
    }

    /**
     * Pass through all headers
     *
     * @access      private
     * @param       resource        $ch
     * @param       string          $header
     * @return      int
     */
    private function passHeaders($ch, $header) 
    {
        static $allow = array(
            'Content-Type',
            'Content-Length'            
        );

        list($h,) = explode(':', $header);
        if (in_array($h, $allow)) {
            $this->passThrough[] = trim($header);
        }

        return strlen($header);
    }

    /**
     * Add an additional request header
     *
     * A way to set specific headers to be sent to the API if you wish to 
     * overload the request behavior.
     *
     * @access      public
     * @param       string      $header    
     */
    public function addRequestHeader($header)
    {
        $this->requestHeaders[] = $header;
    }
}

?>
