<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Story class for Digg API
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
 * Services_Digg_Story
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Story extends Services_Digg_Common 
{
    /**
     * __call
     *
     * Any function you call via this (ie. comments()) requires you to pass
     * a numeric story ID. The optional second argument is the normal $params
     * argument passed to most API calls.
     *
     * @access      public
     * @param       string      $function
     * @param       array       $args
     * @throws      Services_Digg_Exception
     */
    public function __call($function, array $args)
    {
        if (!isset($args[0]) || !is_numeric($args[0])) {
            throw new Services_Digg_Exception('First argument must be numeric');
        } 

        $story = $args[0];

        $params = array();
        if (isset($args[1]) && is_array($args[1]) && count($args[1])) {
            $params = $args[1];
        }

        $endPoint = '/story/' . $story . '/' . $function;
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get comment activity for a story
     * 
     * @access      public
     * @param       int         $story      Story ID
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getCommentActivity($story, array $params = array())
    {
        $endPoint = '/story/' . $this->id . '/activity/comments';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a specific comment on a story
     *
     * @access      public
     * @param       int         $commentid  ID of comment to fetch
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getCommentById($commentid, array $params = array()) 
    {
        $endPoint = '/story/' . $this->id . '/comment/' . $commentid;
        $result = $this->sendRequest($endPoint, $params);
        return $result->comments[0];
    }

    /**
     * Get digg activity for a story
     * 
     * @access      public
     * @param       int         $story      Story ID
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getDiggActivity($story, array $params = array())
    {
        $endPoint = '/story/' . $this->id . '/activity/diggs';
        return $this->sendRequest($endPoint, $params);
    }
}

?>
