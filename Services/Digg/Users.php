<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Users endpoint for Digg API
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
 * Services_Digg_Users
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Users extends Services_Digg_Common
{
    /**
     * Search all users
     *
     * @access      public
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getAll(array $params = array())
    {
        return $this->sendRequest('/users', $params);
    }

    /**
     * Get a user by name
     *
     * @access      public
     * @param       string      $username       Username to fetch
     * @param       array       $params
     * @throws      Services_Digg_Exception
     */
    public function getUserByName($username, array $params = array())
    {
        $result = $this->sendRequest('/user/' . $username);
        return $result->users[0];
    }

    /**
     * Get a list of users by names
     *
     * @access      public
     * @param       array       $usernames  An array of usernames
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getUsersByName(array $usernames, array $params = array())
    {
        $endPoint = '/users/' . implode(',', $usernames);
        return $this->sendRequest($endPoint, $params);  
    }

    /**
     * Get a list of users' comments
     *
     * @access      public
     * @param       array       $usernames  An array of usernames
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getUsersComments(array $usernames, array $params = array())
    {
        $endPoint = '/users/' . implode(',', $usernames) . '/comments';
        return $this->sendRequest($endPoint, $params);  
    }

    /**
     * Get a list of users' diggs
     *
     * @access      public
     * @param       array       $usernames  An array of usernames
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getUsersDiggs(array $usernames, array $params = array())
    {
        $endPoint = '/users/' . implode(',', $usernames) . '/diggs';
        return $this->sendRequest($endPoint, $params);  
    }
}

?>
