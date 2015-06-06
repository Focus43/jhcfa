<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use UserInfo;
    use FileSet;
    use File;
    use \Concrete\Package\Schedulizer\Src\EventTag;
    use Concrete\Package\Artsy\Controller AS PackageController;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;

    class BlogPost extends ArtsyPageController {

        protected $_includeThemeAssets          = true;
        protected $_includeOpenGraphImageTag    = false;

        public function on_start(){
            parent::on_start();

            $featured = EventTag::getByHandle('featured');
            if( is_object($featured) ){
                $this->set('featuredTagID', $featured->getID());
            }
            $this->set('pageOwnerUser', UserInfo::getByID($this->getPageObject()->getCollectionUserID()));

            // Opengraph tags
            $this->addHeaderItem(sprintf('<meta property="og:type" content="%s" />', 'article'));
            // If an image is SET, specify open graph image tag
            $fileObj = $this->getPageObject()->getAttribute(PackageController::ATTR_COLLECTION_PAGE_IMAGE);
            if( $fileObj instanceof File && $fileObj->getFileID() >= 1 ){
                $this->addHeaderItem(sprintf('<meta property="og:image" content="%s" />', $fileObj->getThumbnailURL('event_thumb')));
            }
        }

    }

}