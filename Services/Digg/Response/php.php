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
 * Services_Digg_Response_php
 *  
 * Parses the PHP response type from the Digg API. Digg's API responds with
 * PHP, JSON and XML currently.  
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_Response_php extends Services_Digg_Response_Common
{
    /**
     * Parse PHP respnse
     *
     * @access      public
     * @return      mixed       DiggAPIError on failure
     */
    public function parse()
    {
        $result = @unserialize($this->response);
        if (!is_object($result)) {
            throw new Services_Digg_Response_Exception('Could not parse result');
        }

        if ($result instanceof DiggAPIError) {
            throw new Services_Digg_Response_Exception($result->message, $result->code);
        }

        return $result;
    }
}

if (!class_exists('DiggAPIStory', false)) {
    require_once 'Services/Digg/Story.php';

    /**
     * DiggAPIStory
     *
     * @author      Joe Stump <joe@joestump.net>
     * @see         Services_Digg_Story
     */
    class DiggAPIStory extends Services_Digg_Story
    {
        public function __call($function, array $args)
        {
            $params = array();
            if (isset($args[0]) && is_array($args[0]) && count($args[0])) {
                $params = $args[0];
            }

            return parent::__call($function, array($this->id, $params));
        }

        /**
         * Get comment activity for a story
         * 
         * @access      public
         * @param       array       $params     Digg API arguments
         * @throws      PEAR_Exception
         */
        public function getCommentActivity(array $params = array()) 
        {
            return parent::getCommentActivity($this->id, $params);
        }

        /**
         * Get digg activity for a story
         * 
         * @access      public
         * @param       array       $params     Digg API arguments
         * @throws      PEAR_Exception
         */
        public function getDiggActivity(array $params = array()) 
        {
            return parent::getCommentActivity($this->id, $params);
        }
    }
}

if (!class_exists('DiggAPIGalleryPhoto', false)) {
    require_once 'Services/Digg/GalleryPhoto.php';

    /**
     * DiggAPIStory
     *
     * @author      Joe Stump <joe@joestump.net>
     * @see         Services_Digg_GalleryPhoto
     */
    class DiggAPIGalleryPhoto extends Services_Digg_GalleryPhoto
    {
        /**
         * Make a second service call
         *
         * @param       string      $function
         * @param       array       $args
         */
        public function __call($function, array $args)
        {
            $params = array();
            if (isset($args[0]) && is_array($args[0]) && count($args[0])) {
                $params = $args[0];
            }

            return parent::__call($function, array($this->id, $params));
        }
    }
}


if (!class_exists('DiggAPIError', false)) {
    /**
     * DiggAPIError
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net> 
     * @throws      PEAR_Exception
     */
    class DiggAPIError 
    {
        /**
         * Error message
         *
         * @access      public
         * @var         string      $message    Error message
         */
        public $message = '';

        /**
         * Error code
         *
         * @access      public
         * @var         int         $code       Error code
         */
        public $code = 0;

        /**
         * Get error message
         *
         * @access      public
         * @return      string      Error message
         */
        public function getMessage()
        {
            return $this->message;
        }

        /**
         * Get error code
         *
         * @access      public
         * @return      int         Error code
         */
        public function getCode()
        {
            return $this->code;
        }
    }
}

if (!class_exists('DiggAPIUser', false)) {
    require_once 'Services/Digg/User.php';

    /**
     * DiggAPIUser
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net> 
     * @see         Services_Digg_User
     */
    class DiggAPIUser extends Services_Digg_User
    {
        /**
         * __call
         * 
         * @access      public
         * @param       string      $function
         * @param       array       $args
         * @return      mixed
         */
        public function __call($function, array $args) 
        {
            $params = array();
            if (isset($args[0]) && is_array($args[0]) && count($args[0])) {
                $params = $args[0];
            }

            return parent::__call($function, array($this->name, $params));
        }

        /**
         * Get a user's comment activity
         *
         * @access      public
         * @param       array       $params
         * @throws      PEAR_Exception
         */
        public function getCommentActivity(array $params = array()) 
        {
            return parent::getCommentActivity($this->name, $params);
        }

        /**
         * Get a user's digg activity
         *
         * @access      public
         * @param       array       $params
         * @throws      PEAR_Exception
         */
        public function getDiggsActivity(array $params = array()) 
        {
            return parent::getDiggsActivity($this->name, $params);
        }

        /**
         * Is the user friends with a person
         *
         * @access      public
         * @param       string      $friend         Username to check for
         * @return      boolean
         */
        public function isFriend($friend)
        {
            return parent::isFan($this->name, $friend);
        }

        /**
         * Is the person a fan of this user
         *
         * @access      public
         * @param       string      $fan            Username to check for
         * @return      boolean
         */
        public function isFan($fan)
        {
            return parent::isFan($this->name, $fan);
        }

        /**
         * Get a user's friends' submissions
         *
         * @access      public
         * @param       array       $params
         * @throws      Services_Digg_Exception
         */
        public function getFriendsSubmissions(array $params = array())
        {
            $endPoint = '/user/' . $this->name . '/friends/submissions';
            return $this->sendRequest($endPoint, $params);
        }

        /**
         * Get a user's friends' dugg stories
         *
         * @access      public
         * @param       array       $params
         * @throws      Services_Digg_Exception
         */
        public function getFriendsDugg(array $params = array())
        {
            $endPoint = '/user/' . $this->name . '/friends/dugg';
            return $this->sendRequest($endPoint, $params);
        }
    
        /**
         * Get a user's friends' commented stories
         *
         * @access      public
         * @param       array       $params
         * @throws      Services_Digg_Exception
         */
        public function getFriendsCommented(array $params = array())
        {
            $endPoint = '/user/' . $this->name . '/friends/commented';
            return $this->sendRequest($endPoint, $params);
        }

        /**
         * Get a user's friends' popular stories that they dugg
         *
         * @access      public
         * @param       array       $params
         * @throws      Services_Digg_Exception
         */
        public function getFriendsPopular(array $params = array())
        {
            $endPoint = '/user/' . $this->name . '/friends/popular';
            return $this->sendRequest($endPoint, $params);
        }
    
        /**
         * Get a user's friends' upcoming stories that they dugg
         *
         * @access      public
         * @param       array       $params
         * @throws      Services_Digg_Exception
         */
        public function getFriendsUpcoming(array $params = array())
        {
            $endPoint = '/user/' . $this->name . '/friends/upcoming';
            return $this->sendRequest($endPoint, $params);
        }
    }
}

if (!class_exists('DiggAPIComment', false)) {
    require_once 'Services/Digg/Comment.php';

    /**
     * DiggAPIComment
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     * @see         Services_Digg_Comment
     */
    class DiggAPIComment extends Services_Digg_Comment
    {
        /**
         * Get a comment's replies
         *
         * This function returns replies to the current comment. It only makes
         * the second API call if the reply count is greater than zero.
         *
         * @access      public
         * @param       array       $params     Digg API arguments
         * @return      object      Instance of DiggAPIEvents
         */
        public function replies(array $params = array())
        {
            if ($this->replies > 0) {
                $endPoint = '/story/' . $this->story . '/comment/' . $this->id .
                            '/replies';
                return $this->sendRequest($endPoint, $params);
            }

            $ret = new DiggAPIEvents();
            $ret->timestamp = time();
            $ret->total = $ret->offset = $ret->count = 0;
            return $ret;
        }

        /**
         * __toString
         *
         * @access      public
         * @return      string      Comment's content
         */
        public function __toString() 
        {
            return $this->content;
        }
    }
}

if (!class_exists('DiggAPIActivityPeriod', false)) {
    /**
     * DiggAPIActivityPeriod
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIActivityPeriod
    {

    }
}

if (!class_exists('DiggAPIActivity', false)) {
    /**
     * DiggAPIActivity
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIActivity
    {
        /**
         * Rewind $activity array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (is_array($this->activity) && count($this->activity)) {
                reset($this->activity);
            }

            return false;
        }

        /**
         * Return current element of $activity
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (is_array($this->activity) && count($this->activity)) {
                return current($this->activity);
            }

            return false;
        }

        /**
         * Return a key from $activity array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (is_array($this->activity) && count($this->activity)) {
                return key($this->activity);
            }

            return false;
        }

        /**
         * Advance the internal pointer of $activity array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (is_array($this->activity) && count($this->activity)) {
                return next($this->activity);
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
}

if (!class_exists('DiggAPIContainer', false)) {
    /**
     * DiggAPIContainer
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIContainer
    {

    }
}

if (!class_exists('DiggAPIDigg', false)) {
    /**
     * DiggAPIDigg
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIDigg 
    {

    }
}

if (!class_exists('DiggAPIErrors', false)) {
    /**
     * DiggAPIError
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIErrors
    {
        /**
         * Rewind $errors array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (is_array($this->errors) && count($this->errors)) {
                reset($this->errors);
            }

            return false;
        }

        /**
         * Return current element of $errors
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (is_array($this->errors) && count($this->errors)) {
                return current($this->errors);
            }

            return false;
        }

        /**
         * Return a key from $errors array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (is_array($this->errors) && count($this->errors)) {
                return key($this->errors);
            }

            return false;
        }

        /**
         * Advance the internal pointer of $errors array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (is_array($this->errors) && count($this->errors)) {
                return next($this->errors);
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
} 

if (!class_exists('DiggAPIEvents', false)) {
    /**
     * DiggAPIEvents
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIEvents implements Iterator
    {
        /**
         * Which array to iterate
         *
         * The DiggAPIEvents class is returned for both comments and diggs.
         * In order for PHP5 object iteration to happen we need to figure out
         * which events are returned (diggs v. comments) and iterate through
         * that array.
         *
         * @access      private
         * @var         string      $iterate
         */
        private $iterator = null;

        /**
         * __wakeup
         *
         * When this is unserialized we check to see if the events listed 
         * are diggs or comments and then set $iterator appropriately.
         *
         * @access      public
         * @return      void
         * @see         DiggAPIEvents::$iterator
         */
        public function __wakeup() 
        {
            if (isset($this->diggs) && 
                is_array($this->diggs)) {
                $this->iterator = 'diggs';
            } elseif (isset($this->comments) &&
                      is_array($this->comments)) {
                $this->iterator = 'comments';
            }
        }

        /**
         * Rewind $stories array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (!is_null($this->iterator)) {
                reset($this->{$this->iterator});
            }

            return false;
        }

        /**
         * Return current element of $stories
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (!is_null($this->iterator)) {
                return current($this->{$this->iterator});
            }

            return false;
        }

        /**
         * Return a key from $stories array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (!is_null($this->iterator)) {
                return key($this->{$this->iterator});
            }

            return false;
        }

        /**
         * Advance the internal pointer of $stories array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (!is_null($this->iterator)) {
                return next($this->{$this->iterator});
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
}   

if (!class_exists('DiggAPIStories', false)) {
    /**
     * DiggAPIStories
     *
     * The stories return object uses PHP5 object iteration so that you can
     * quickly iterate through responses. 
     *
     * <code>
     * <?php
     * 
     * require_once 'Services/Digg.php'; 
     * $api = Services_Digg::factory('Stories'); 
     * $stories = $api->getAll(array('count' => 10));
     * foreach ($stories as $story) { 
     *     echo $story->title . '<br />' . "\n"; 
     * } 
     * 
     * ?>
     * </code>
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     * @link        http://www.php.net/manual/en/language.oop5.iterations.php
     */
    class DiggAPIStories implements Iterator
    {
        /**
         * Rewind $stories array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (isset($this->stories) && is_array($this->stories) && 
                count($this->stories)) {
                reset($this->stories);
            }

            return false;
        }

        /**
         * Return current element of $stories
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (isset($this->stories) && is_array($this->stories) && 
                count($this->stories)) {
                return current($this->stories);
            }

            return false;
        }

        /**
         * Return a key from $stories array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (isset($this->stories) && is_array($this->stories) && 
                count($this->stories)) {
                return key($this->stories);
            }

            return false;
        }

        /**
         * Advance the internal pointer of $stories array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (isset($this->stories) && is_array($this->stories) && 
                count($this->stories)) {
                return next($this->stories);
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
}

if (!class_exists('DiggAPIGallery', false)) {
    /**
     * DiggAPIGallery
     *
     * The stories return object uses PHP5 object iteration so that you can
     * quickly iterate through responses. 
     *
     * <code>
     * <?php
     * 
     * require_once 'Services/Digg.php'; 
     * $api = Services_Digg::factory('GalleryPhotos'); 
     * $photos = $api->getAll(array('count' => 10));
     * foreach ($photos as $photo) { 
     *     echo $photo->title . '<br />' . "\n"; 
     * } 
     * 
     * ?>
     * </code>
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     * @link        http://www.php.net/manual/en/language.oop5.iterations.php
     */
    class DiggAPIGallery implements Iterator
    {
        /**
         * Rewind $photos array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (isset($this->photos) && is_array($this->photos) && 
                count($this->photos)) {
                reset($this->photos);
            }

            return false;
        }

        /**
         * Return current element of $photos
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (isset($this->photos) && is_array($this->photos) && 
                count($this->photos)) {
                return current($this->photos);
            }

            return false;
        }

        /**
         * Return a key from $photos array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (isset($this->photos) && is_array($this->photos) && 
                count($this->photos)) {
                return key($this->photos);
            }

            return false;
        }

        /**
         * Advance the internal pointer of $photos array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (isset($this->photos) && is_array($this->photos) && 
                count($this->photos)) {
                return next($this->photos);
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
}


if (!class_exists('DiggAPITopic', false)) {
    /**
     * DiggAPITopic
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPITopic
    {

    }
}

if (!class_exists('DiggAPIThumbnail', false)) {
    /**
     * DiggAPIThumbnail
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIThumbnail 
    {

    }
}

if (!class_exists('DiggAPITopics', false)) {
    /**
     * DiggAPITopics
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPITopics implements Iterator 
    {
        /**
         * Rewind $topics array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (is_array($this->topics) && count($this->topics)) {
                reset($this->topics);
            }

            return false;
        }

        /**
         * Return current element of $topics
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (is_array($this->topics) && count($this->topics)) {
                return current($this->topics);
            }

            return false;
        }

        /**
         * Return a key from $topics array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (is_array($this->topics) && count($this->topics)) {
                return key($this->topics);
            }

            return false;
        }

        /**
         * Advance the internal pointer of $topics array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (is_array($this->topics) && count($this->topics)) {
                return next($this->topics);
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
}

if (!class_exists('DiggAPILink', false)) {
    /**
     * DiggAPILink
     * 
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPILink 
    {

    }
}

if (!class_exists('DiggAPIUsers', false)) {
    /**
     * DiggAPIUsers
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIUsers implements Iterator
    {
        /**
         * Rewind $users array
         *
         * @access      public
         * @return      void
         */
        public function rewind() 
        {
            if (is_array($this->users) && count($this->users)) {
                reset($this->users);
            }

            return false;
        }

        /**
         * Return current element of $users
         *
         * @access      public
         * @return      mixed
         */
        public function current()
        {
            if (is_array($this->users) && count($this->users)) {
                return current($this->users);
            }

            return false;
        }

        /**
         * Return a key from $users array
         *
         * @access      public
         * @return      mixed
         */
        public function key()
        {
            if (is_array($this->users) && count($this->users)) {
                return key($this->users);
            }

            return false;
        }

        /**
         * Advance the internal pointer of $users array
         *
         * @access      public
         * @return      mixed
         */
        public function next()
        {
            if (is_array($this->users) && count($this->users)) {
                return next($this->users);
            }

            return false;
        }

        /**
         * Is the next iteration valid?
         *
         * @access      public
         * @return      boolean
         */
        public function valid()
        {
            return ($this->current() !== false);
        }
    }
}

if (!class_exists('DiggAPIAPIGroups', false)) {
    /**
     * DiggAPIAPIGroups
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIAPIGroups implements IteratorAggregate
    {
        public function getIterator()
        {
            return new ArrayObject($this->groups);
        }
    }
}

if (!class_exists('DiggAPIAPIGroup', false)) {
    /**
     * DiggAPIAPIGroup
     *
     * @category    Services
     * @package     Services_Digg
     * @author      Joe Stump <joe@joestump.net>
     */
    class DiggAPIAPIGroup
    {

    }
}


?>
