<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * User class for Digg API
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
 * Services_Digg_User
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_User extends Services_Digg_Common
{
    /**
     * __call
     *
     * This overloaded method handles '/user/{user name}/{endpoint}', such as
     * '/user/joestump/diggs'. It does not handle more detailed endpoints, such
     * ss '/user/joestump/activity/comments', which has its own method.
     *
     * @access      public
     * @param       string      $function       Simple endpoint for users
     * @param       array       $args           Arguments to pass to API
     * @return      mixed
     * @throws      Services_Digg_Exception
     */
    public function __call($function, $args) 
    {
        if (!isset($args[0]) || !strlen($args[0])) {
            throw new Services_Digg_Exception('Invalid or unsupplied username');
        }

        $params = array();
        if (isset($args[1]) && count($args[1])) {
            $params = $args[1];
        }

        $username = $args[0];
        $endPoint = '/user/' . $username . '/' . $function;        
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a user's comment activity
     *
     * @access      public
     * @param       string      $username
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getCommentActivity($username, array $params = array()) 
    {
        $endPoint = '/user/' . $username . '/activity/comments';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a user's digg activity
     *
     * @access      public
     * @param       string      $username
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getDiggsActivity($username, array $params = array()) 
    {
        $endPoint = '/user/' . $username . '/activity/diggs';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Is the user friends with a person
     *
     * Checks to see if the given $username is friends with the currently
     * instantiated user from $this->name.
     *
     * @access      public
     * @param       string      $username       Username to check against
     * @param       string      $friend         Username to check for
     * @return      boolean
     */
    public function isFriend($username, $friend) 
    {
        $endPoint = '/user/' . $username . '/friend/' . $friend;
        try {
            $result = $this->sendRequest($endPoint);
            return true;
        } catch (Services_Digg_Exception $error) {
            return false;
        }
    }

    /**
     * Is the person a fan of this user
     *
     * Checks to see if the given $username is a fan of the currently
     * instantiated user from $this->name.
     *
     * @access      public
     * @param       string      $username       Username to check against
     * @param       string      $fan            Username to check for
     * @return      boolean
     */
    public function isFan($username, $fan)
    {
        $endPoint = '/user/' . $username . '/fan/' . $fan;
        try {
            $result = $this->sendRequest($endPoint, array());
            return true;
        } catch (Services_Digg_Exception $error) {
            return false;
        }
    }

    /**
     * Get a user's friends' submissions
     *
     * @access      public
     * @param       string      $username       Username to get friends' subs
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getFriendsSubmissions($username, array $params = array())
    {
        $endPoint = '/user/' . $username . '/friends/submissions';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a user's friends' dugg stories
     *
     * @access      public
     * @param       string      $username       Username to get friends' duggs
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getFriendsDugg($username, array $params = array())
    {
        $endPoint = '/user/' . $username . '/friends/dugg';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a user's friends' commented stories
     *
     * @access      public
     * @param       string      $username       Username to get friends' cmts
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getFriendsCommented($username, array $params = array())
    {
        $endPoint = '/user/' . $username . '/friends/commented';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a user's friends' popular stories that they dugg
     *
     * @access      public
     * @param       string      $username       
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getFriendsPopular($username, array $params = array())
    {
        $endPoint = '/user/' . $username . '/friends/popular';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a user's friends' upcoming stories that they dugg
     *
     * @access      public
     * @param       string      $username       
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getFriendsUpcoming($username, array $params = array())
    {
        $endPoint = '/user/' . $username . '/friends/upcoming';
        return $this->sendRequest($endPoint, $params);
    }
}

?>
