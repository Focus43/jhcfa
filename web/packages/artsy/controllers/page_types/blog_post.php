<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use UserInfo;
    use FileSet;
    use File;
    use \Concrete\Package\Schedulizer\Src\EventTag;
    use Concrete\Package\Artsy\Controller AS PackageController;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;

    class BlogPost extends ArtsyPageController {

        protected $_includeThemeAssets      = true;
        protected $_includeOpenGraphTags    = false;

        public function on_start(){
            parent::on_start();
            $featured = EventTag::getByHandle('featured');
            if( is_object($featured) ){
                $this->set('featuredTagID', $featured->getID());
            }
            $this->set('pageOwnerUser', UserInfo::getByID($this->getPageObject()->getCollectionUserID()));

            // Opengraph tags
            $fileObj = $this->getPageObject()->getAttribute(PackageController::ATTR_COLLECTION_PAGE_IMAGE);
            if( $fileObj instanceof File && $fileObj->getFileID() >= 1 ){
                $this->addHeaderItem(sprintf('<meta property="og:image" content="%s" />', $fileObj->getThumbnailURL('event_thumb')));
            }

            $this->addHeaderItem(sprintf('<meta property="og:title" content="%s" />', $this->getPageObject()->getCollectionName()));
            $this->addHeaderItem(sprintf('<meta property="og:type" content="%s" />', 'article'));
        }

    }

}