<?php    
namespace Concrete\Package\FsOpenGraphProtocolLite\Src\Generate;

/**
 * Support code
 *
 * @package     FS Open Graph Protocol Lite
 * @author      Fagan Systems
 * @copyright   Copyright (c) 2015. (http://www.fagan-systems.com)
 * @license     http://www.fagan-systems.com/faqhelp/commercial-license  Commercial License
 *
 */

use Loader;
use Page;
use Package;
use File;
use View;
use Config;
use Localization;

class FsOpenGraphProtocol {
    
    public function writeogp( $view )
    {
        $navigation = Loader::helper("navigation");
        $th = Loader::helper('text');
        
        $page = Page::getCurrentPage();
        
        if (!is_object($page) || $page->getError() == COLLECTION_NOT_FOUND || $page->isAdminArea()) {
            return;
        }
        
        $pkg = Package::getByHandle('fs_open_graph_protocol_lite');
        $fb_admin = $pkg->getConfig()->get('concrete.ogp.fb_admin_id');
        $fb_app_id = $pkg->getConfig()->get('concrete.ogp.fb_app_id');
        $thumbnailID = $pkg->getConfig()->get('concrete.ogp.og_thumbnail_id');
        $default_title=$pkg->getConfig()->get('concrete.ogp.default_title');
        $default_description=$pkg->getConfig()->get('concrete.ogp.default_description');
        $seo_select=$pkg->getConfig()->get('concrete.ogp.seo_select');

        $pageTitle = $page->getCollectionAttributeValue('og_title');
        if (!$pageTitle) {
            $pageTitle = $page->getCollectionName();
            if (!$pageTitle) {
                $pageTitle = $page->getCollectionAttributeValue('meta_title');
                if (!$pageTitle) {
                    $pageTitle = $default_title;
                    if ($page->isSystemPage()) {
                        $pageTitle = t($pageTitle);
                    }
                }
            }
        }

        $pageDescription = $page->getCollectionAttributeValue('og_description');
        if (!$pageDescription) {
            $pageDescription = $page->getCollectionDescription();
            if (!$pageDescription) {
                $pageDescription = $page->getCollectionAttributeValue('meta_description');
                if (!$pageDescription) {
                    $pageDescription = $default_description;
                }
            }
        }
        $pageDescription = $th->shortenTextWord($pageDescription, 200, '');
        
        $pageOgType = $page->getCollectionAttributeValue('og_type');
        if ( !$pageOgType ) {
            if ( $page->getCollectionID() == HOME_CID ){
                $pageOgType = 'website';
            } else {
                $pageOgType = 'article';
            }
        }

        $og_image = $page->getAttribute('og_image');
        if (!$og_image instanceof File) {
            $og_image = $page->getAttribute('thumbnail');
            if (!$og_image instanceof File && !empty($thumbnailID)) {
                $og_image = File::getByID($thumbnailID);
            }
        }
        
        if ($og_image instanceof File && !$og_image->isError()) {
            $fv = $og_image->getApprovedVersion();
            $size = $fv->getFullSize();
            // if the image is more the 1MB scale it
            if ($size > 1024768) {
                $thumb = Loader::helper('image')->getThumbnail($og_image,1200,630,true);
                $og_image_width = $thumb->width;
                $og_image_height = $thumb->height;
                $og_image_url = BASE_URL . $thumb->src;
            } else {
                $og_image_width = $og_image->getAttribute('width');
                $og_image_height = $og_image->getAttribute('height');
                $og_image_url = BASE_URL . File::getRelativePathFromID($og_image->getFileID());
            }
        }

        // if we are on the home page then skip the seo
        if ( $page->getCollectionID() != HOME_CID ){
            if ($seo_select) {
                $pageTitle = $th->entities(Config::get('concrete.site')) . '::' . $pageTitle;
            }
        }

        $v = View::getInstance();
        $v->addHeaderItem('<meta property="og:title" content="' . $th->entities($pageTitle) . '" />');
        $v->addHeaderItem('<meta property="og:description" content="' . $th->entities($pageDescription) . '" />');
        $v->addHeaderItem('<meta property="og:type" content="' .  $th->entities($pageOgType) . '" />');
        $v->addHeaderItem('<meta property="og:url" content="' . $navigation->getLinkToCollection($page,true) . '" />');
        if ( isset($og_image_url) && isset($og_image_width) && isset($og_image_height) ) {
            $v->addHeaderItem('<meta property="og:image" content="' .  $og_image_url . '" />');
            $v->addHeaderItem('<meta property="og:image:width" content="' .  $og_image_width . '" />');
            $v->addHeaderItem('<meta property="og:image:height" content="' .  $og_image_height . '" />');
        }
        if ( $page->getCollectionID() != HOME_CID ) {
            $v->addHeaderItem('<meta property="og:site_name" content="' .  $th->entities(Config::get('concrete.site')) . '" />');
        }
        if ( $fb_admin ) {
            $v->addHeaderItem('<meta property="fb:admins" content="' . $th->entities($fb_admin) . '" />');
        }
        if ( $fb_app_id ) {
            $v->addHeaderItem('<meta property="fb:app_id" content="' . $th->entities($fb_app_id) . '" />');
        }

        $localization = Localization::getInstance();
        $locale = $localization->getLocale();
        $v->addHeaderItem('<meta name="og:locale" content="' . $th->entities($locale) . '" />');
        
        $cv = $page->getVersionObject();
        if (is_object($cv)) {
            $lastModified = $cv->getVersionDateCreated();
            $lastModified = date(DATE_ATOM, strtotime($lastModified));
            $v->addHeaderItem('<meta name="og:updated_time" content="' . $th->entities($lastModified) . '" />');
        }
    }
}