<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Stories endpoint driver
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
 * Services_Digg_Stories
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Stories extends Services_Digg_Common
{
    /**
     * __call
     *
     * @access      public
     * @param       string      $function       API endpiont to call
     * @param       array       $args
     * @throws      Services_Digg_Exception
     */
    public function __call($function, array $args) 
    {
        $endPoint = '/stories/' . $function;
        $params = array();
        if (isset($args[0]) && is_array($args[0])) {
            $params = $args[0];
        }
        
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get all stories
     *
     * @access      public
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getAll(array $params = array())
    {
        return $this->sendRequest('/stories', $params);
    }

    /**
     * Get a single story by ID
     *
     * @access      public
     * @param       int         $id         ID of story
     * @param       array       $params     API parameters
     * @throws      Services_Digg_Exception
     */
    public function getStoryById($id, array $params = array()) 
    {
        $result = $this->sendRequest('/story/' . $id, $params);
        return $result->stories[0];
    }

    /**
     * Get a single story by title
     *
     * @access      public
     * @param       string      $title      Clean title of story
     * @param       array       $params     API parameters
     * @throws      Services_Digg_Exception
     */
    public function getStoryByTitle($title, array $params = array())
    {
        $result = $this->sendRequest('/story/' . $title, $params);
        return $result->stories[0];
    }

    /**
     * Get a list of stories by their ID's
     *
     * @access      public
     * @param       array       $stories    An array of story ID's 
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getStoriesById(array $stories, array $params = array()) 
    {
        $endPoint = '/stories/' . implode(',', $stories);
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a list of stories' comments
     *
     * @access      public
     * @param       array       $stories    An array of story ID's 
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getStoriesComments(array $stories, array $params = array())
    {
        $endPoint = '/stories/' . implode(',', $stories) . '/comments';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get a list of stories' diggs
     *
     * @access      public
     * @param       array       $stories    An array of story ID's 
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getStoriesDiggs(array $stories, array $params = array())
    {
        $endPoint = '/stories/' . implode(',', $stories) . '/diggs';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get stories by container
     *
     * @access      public
     * @param       string      $container  Name of container (ie. Sports)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getContainer($container, array $params = array()) 
    {
        $endPoint = '/stories/container/' . $container;
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get top stories by container
     *
     * @access      public
     * @param       string      $container  Name of container (ie. Sports)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getContainerTop($container, array $params = array())
    {
        $endPoint = '/stories/container/' . $container . '/top';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get hot stories by container
     *
     * @access      public
     * @param       string      $container  Name of container (ie. Sports)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getContainerHot($container, array $params = array())
    {
        $endPoint = '/stories/container/' . $container . '/hot';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get popular stories in a specific container
     *
     * @access      public
     * @param       string      $container  Name of container (ie. Sports)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getContainerPopular($container, array $params = array()) 
    {
        $endPoint = '/stories/container/' . $container . '/popular';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get upcoming stories in a specific container
     *
     * @access      public
     * @param       string      $container  Name of container (ie. Sports)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getContainerUpcoming($container, array $params = array()) 
    {
        $endPoint = '/stories/container/' . $container . '/upcoming';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get stories in a specific topic
     *
     * @access      public
     * @param       string      $topic      Name of topic (ie. Apple)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getTopic($topic, array $params = array()) 
    {
        $endPoint = '/stories/topic/' . $topic;
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get top stories by topic
     *
     * @access      public
     * @param       string      $topic      Name of topic (ie. Apple)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getTopicTop($topic, array $params = array())
    {
        $endPoint = '/stories/topic/' . $topic . '/top';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get hot stories by topic
     *
     * @access      public
     * @param       string      $topic      Name of topic (ie. Apple)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getTopicHot($container, array $params = array())
    {
        $endPoint = '/stories/topic/' . $container . '/hot';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get popular stories in a specific topic
     *
     * @access      public
     * @param       string      $topic      Name of topic (ie. Apple)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getTopicPopular($topic, array $params = array()) 
    {
        $endPoint = '/stories/topic/' . $topic . '/popular';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get upcoming stories in a specific topic
     *
     * @access      public
     * @param       string      $topic      Name of topic (ie. Apple)
     * @param       array       $params     Digg API arguments  
     * @throws      Services_Digg_Exception
     */
    public function getTopicUpcoming($topic, array $params = array()) 
    {
        $endPoint = '/stories/topic/' . $topic . '/upcoming';
        return $this->sendRequest($endPoint, $params);
    }

    /**
     * Get popular stories' comments
     *
     * @access      public
     * @param       array       $params     Digg API arguments
     * @return      object
     * @throws      Services_Digg_Exception
     */
    public function getPopularComments(array $params = array()) 
    {
        return $this->sendRequest('/stories/popular/comments', $params);
    }

    /**
     * Get all comments on upcoming stories
     *
     * @access      public
     * @param       array       $params     API arguments
     * @return      object
     * @throws      Services_Digg_Exception
     */
    public function getUpcomingComments(array $params = array())
    {
        return $this->sendRequest('/stories/upcoming/comments', $params);
    }

    /**
     * Get popular stories' diggs
     *
     * @access      public
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getPopularDiggs(array $params = array())
    {
        return $this->sendRequest('/stories/popular/diggs', $params);
    }

    /**
     * Get upcoming stories' diggs
     *
     * @access      public
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getUpcomingDiggs(array $params = array())
    {
        return $this->sendRequest('/stories/upcoming/diggs', $params);
    }
}

?>
