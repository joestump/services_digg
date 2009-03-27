<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Gallery photo endpoint class
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
 * Services_Digg_GalleryPhoto
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_GalleryPhoto extends Services_Digg_Common
{
    /**
     * __call
     *
     * @access      public
     * @param       string      $function       Endpoint to call
     * @param       array       $args
     * @throws      Services_Digg_Exception
     */
    public function __call($function, array $args)
    {
       if (!isset($args[0]) || !is_numeric($args[0])) {
            throw new Services_Digg_Exception('First argument must be numeric');
        }

        $photo = $args[0];

        $params = array();
        if (isset($args[1]) && is_array($args[1]) && count($args[1])) {
            $params = $args[1];
        }

        $endPoint = '/galleryphoto/' . $photo. '/' . $function;
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a specific comment on a photo
     *
     * @access      public
     * @param       int         $commentid  ID of comment to fetch
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getCommentById($commentid, array $params = array())
    {
        $endPoint = '/galleryphoto/' . $this->id . '/comment/' . $commentid;
        $result = $this->sendRequest($endPoint, $params);
        return $result->comments[0];
    }
}

?>
