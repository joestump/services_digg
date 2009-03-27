<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * A class for running parallel requests to the API
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
 * A class for running parallel requests to the API
 *  
 * This class allows you to send parallel asynchronous requests to the Digg API
 * without locking your script waiting for those requests to return.
 *
 * <code>
 * <?php
 * 
 * // Make sure your keys are valid PHP variable names so it doesn't throw
 * // an error when trying to access the results later on.
 * $endPoints = array(
 *     'popular' => Services_Digg_Request::buildCall('/stories/popular'),
 *     'errors'  => Services_Digg_Request::buildCall('/errors'),
 *     'topics'  => Services_Digg_Request::buildCall('/topics')
 * );
 *
 * // Start the requests. You'll want to run this at the very top of your 
 * // script so that the parallel requests start working immediately.
 * $req = new Services_Digg_Request($endPoints);
 * 
 * // The calls are asynchronous and ran in parallel so keep on working on 
 * // other stuff while that runs in the background.
 *
 * // Now I need the popular stories
 * foreach ($req->popular->stories as $story) {
 *     echo '<h2>' . $story->title . '</h2>' . "\n";
 * }
 *
 * ?>
 * </code>  
 *
 * Keep in mind that the requests to the API run both in parallel and 
 * asynchronously in the background. This means that calls to the API are no
 * longer blocking and only take as long as the slowest API request. 
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 * @abstract
 */
class Services_Digg_Request 
{
    /**
     * A socket for each API endpoint
     *
     * @access      private
     * @var         array       $sockets
     */
    private $sockets = array();

    /**
     * Results from each API endpoint
     *
     * @access      private
     * @var         array       $results
     * @see         Services_Digg_Request::__get()
     */
    private $results = array();

    /**
     * The actual calls that are made
     *
     * @access      private
     * @var         array       $urls
     */
    private $urls = array();

    /**
     * Constructor
     *
     * Create an instance of parallel asynchronous requests to the Digg API by
     * passing an array of endpoints keyed by a valid PHP variable name. 
     *
     * @access      public
     * @param       array       $urls       Array of endpoints keyed by name
     * @return      void
     */
    public function __construct($urls)
    {
        foreach ($urls as $name => $endpoint) {
            $parts = parse_url($endpoint);
            if (!isset($parts['port'])) {
                $parts['port'] = 80;
            }

            $this->initialize($name, $parts);
        }
    }

    /**
     * Initialize a request to the API
     *
     * Sets up the basic HTTP request so that the API can start churning along
     * until we need the actual data. Data is read down and returned via the 
     * getter.
     *
     * @access      private
     * @param       string      $name       Name of request
     * @param       array       $h          Host/port, etc. from parse_url()
     * @return      void
     * @throws      Services_Digg_Exception
     * @see         Services_Digg_Request::__construct()
     * @see         Services_Digg_Request::__get()
     */
    private function initialize($name, $h)
    {
        $this->sockets[$name] = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $res = socket_connect($this->sockets[$name], $h['host'], $h['port']);
        if ($res === false) {
            throw new Services_Digg_Exception(socket_strerror(), socket_last_error());
        } 


        $request = $h['path'];
        if (isset($h['query'])) {
            $request .= '?' . $h['query'];
        }
        
        $init = array('GET ' . $request . ' HTTP/1.1',
                      'Host: ' . $h['host'],
                      'User-Agent: Services_Digg_Request (' . Services_Digg::$appKey . ')',
                      'Connection: Close');

        foreach ($init as $header) {
            socket_write($this->sockets[$name], $header . "\r\n");
        }

        socket_write($this->sockets[$name], "\r\n");
        $this->results[$name] = null;
        $this->urls[$name] = 'http://' . $h['host'] . ':' . $h['port'] . $request;
    }

    /**
     * Read results back in via getter
     *
     * When you create your parallel request you need to add keys to the array
     * of endpoints, which you'll reference with the getter. If the result has
     * not been parsed yet it will be read from the stream and then parsed.
     *
     * @access      public
     * @param       string      $name       Name of request 
     * @return      mixed       The result object or an exception on error
     */
    public function __get($name)
    {
        if (!is_null($this->results[$name])) {
            return $this->results[$name];
        }

        $res = $b = '';
        while ($b = socket_read($this->sockets[$name], 8096)) {
            $res .= $b;
        }
        socket_close($this->sockets[$name]);

        // Responses can contain \r\n\r\n elsewhere after the headers so we
        // shift off the headers and then implode again on \r\n\r\n to get the
        // full response body.
        $parts = explode("\r\n\r\n", $res);
        array_shift($parts);
        $php = implode("\r\n\r\n", $parts);

        try {
            $response = Services_Digg_Response::factory(
                'php', $php
            );

            $this->results[$name] = $response->parse();
        } catch (Services_Digg_Response_Exception $e) {
            $this->results[$name] = new Services_Digg_Exception($e->getMessage(), $e->getCode(), $this->urls[$name], $php);
        }

        return $this->results[$name];
    }

    /**
     * Destructor
     *
     * Closes any sockets that might still be open at the end of the script or
     * when the variable is overwritten.
     *
     * @access      public
     * @return      void
     */
    public function __destruct()
    {
        foreach ($this->sockets as $socket) {
            if (is_resource($socket)) {
                socket_close($socket);
            }
        }
    }

    /**
     * Builds a raw call to the API
     *
     * @access      public
     * @param       string      $endPoint       API endpoint (e.g. /topics)
     * @param       array       $params         GET parameters key/value pair
     * @return      string      The RAW response with your API key, etc.
     * @static
     */
    static public function buildCall($endPoint, array $params = array())
    {
        $params['type'] = 'php';
        $params['appkey'] = Services_Digg::$appKey;
        $sets = array();
        foreach ($params as $key => $val) {
            $sets[] = $key . '=' . $val;
        }

        return Services_Digg::$uri . $endPoint . '?' . implode('&', $sets);
    }
}

?>
