<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use FileSet;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;

    class Page extends ArtsyPageController {

        protected $_includeThemeAssets = true;

        public function view(){
            parent::view();
            $this->set('mastheadHelper', new \Concrete\Package\Artsy\Src\Helpers\Masthead($this->getPageObject()));
        }

    }

}