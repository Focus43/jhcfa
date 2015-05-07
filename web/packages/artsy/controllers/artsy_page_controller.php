<?php namespace Concrete\Package\Artsy\Controller {

    use PageController;
    use Concrete\Package\Artsy\Controller AS PackageController;

    /**
     * Class ArtsyPageController
     * @package Concrete\Package\Artsy\Controller
     */
    class ArtsyPageController extends PageController {

        protected $_includeThemeAssets = false;

        /**
         * Base controller's view method.
         * @return void
         */
        public function view(){
            if( $this->_includeThemeAssets === true ){
                $this->attachThemeAssets( $this );
            }
        }

        /**
         * @return void
         */
        public function on_start(){
            $this->set('documentClasses', join(' ', array(
                $this->pagePermissionObject()->canWrite() ? 'cms-admin' : null,
                $this->getPageObject()->isEditMode() ? 'cms-edit-mode' : null
            )));

            $this->set('templateHandle', sprintf('pg-%s', $this->getPageObject()->getPageTemplateHandle()));
        }

        /**
         * Include css/js assets in page output.
         * @param $pageController Controller : Forces the page controller to be injected!
         * @return void
         */
        public function attachThemeAssets( PageController $pageController ){
            // CSS
            $pageController->addHeaderItem( $this->getHelper('helper/html')->css('core.css', PackageController::PACKAGE_HANDLE) );
            $pageController->addHeaderItem( $this->getHelper('helper/html')->css('app.css', PackageController::PACKAGE_HANDLE) );
            // JS
            $pageController->addFooterItem( $this->getHelper('helper/html')->javascript('core.js', PackageController::PACKAGE_HANDLE) );
            $pageController->addFooterItem( $this->getHelper('helper/html')->javascript('app.js', PackageController::PACKAGE_HANDLE) );
        }

        /**
         * Memoize helpers (beware, once loaded its always the same instance).
         * @param string $handle Handle of the helper to load
         * @param bool | Package $pkg Package to get the helper from
         * @return ...Helper class of some sort
         */
        public function getHelper( $handle, $pkg = false ){
            $helper = '_helper_' . preg_replace("/[^a-zA-Z0-9]+/", "", $handle);
            if( $this->{$helper} === null ){
                $this->{$helper} = \Core::make($handle);
            }
            return $this->{$helper};
        }

        /**
         * Get the Concrete5 permission object for the given page.
         * @return Permissions
         */
        protected function pagePermissionObject(){
            if( $this->_pagePermissionObj === null ){
                $this->_pagePermissionObj = new \Concrete\Core\Permission\Checker( \Concrete\Core\Page\Page::getCurrentPage() );
            }
            return $this->_pagePermissionObj;
        }

    }

}