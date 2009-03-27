<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Gallery photos endpoint driver
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
 * Services_Digg_GalleryPhotos
 *  
 * @category    Services
 * @package     Services_Digg
 * @author      Joe Stump <joe@joestump.net> 
 */
class Services_Digg_GalleryPhotos extends Services_Digg_Common
{
    /**
     * Get all users' gallery photos
     *
     * @access      public
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getAll(array $params = array())
    {
        return $this->sendRequest('/galleryphotos', $params);
    }

    /**
     * Get a single gallery photo by ID
     *
     * @access      public
     * @param       int         $id     ID of gallery photo
     * @throws      Services_Digg_Exception
     */
    public function getGalleryPhotoById($id) 
    {
        $result = $this->sendRequest('/galleryphoto/' . $id);
        if (isset($result->photos[0])) {
            return $result->photos[0];
        }

        throw new Services_Digg_Exception('Photo not found', 404);
    }

    /**
     * Get a list of gallery phtoos by their ID's
     *
     * @access      public
     * @param       array       $photos     An array of photo ID's 
     * @param       array       $params     Digg API arguments
     * @throws      Services_Digg_Exception
     */
    public function getGalleryPhotosById(array $photos, array $params = array())
    {
        $endPoint = '/galleryphotos/' . implode(',', $photos);
        return $this->sendRequest($endPoint, $params);
    }
}

?>
