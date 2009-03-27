<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Comment endpoint class
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
 * Services_Digg_Comment
 *
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Comment extends Services_Digg_Common
{
    /**
     * Type of comment (story v. gallery photo)
     *
     * @var         string      $type
     */
    protected $type = 'story';

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
        $params = array();
        if (isset($args[0]) && is_array($args[0]) && count($args[0])) {
            $params = $args[0];
        }

        $endPoint = '/'. $this->type . '/' . $this->story . '/comment/' . 
                    $this->id . '/' . $function;
        return $this->sendRequest($endPoint, $params);
    }
}

?>
