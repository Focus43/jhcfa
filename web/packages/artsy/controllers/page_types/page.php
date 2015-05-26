<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use FileSet;
    use \Concrete\Package\Schedulizer\Src\EventTag;
    use \Concrete\Package\Artsy\Controller\ArtsyPageController;

    class Page extends ArtsyPageController {

        protected $_includeThemeAssets = true;

        public function on_start(){
            parent::on_start();
            $featured = EventTag::getByHandle('featured');
            if( is_object($featured) ){
                $this->set('featuredTagID', $featured->getID());
            }
        }

    }

}