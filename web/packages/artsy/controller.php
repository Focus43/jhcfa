<?php namespace Concrete\Package\Artsy {
    defined('C5_EXECUTE') or die(_("Access Denied."));

    /** @link https://github.com/concrete5/concrete5-5.7.0/blob/develop/web/concrete/config/app.php#L10-L90 Aliases */
    use Loader; /** @see \Concrete\Core\Legacy\Loader */
    use Router; /** @see \Concrete\Core\Routing\Router */
    use Route; /** @see \Concrete\Core\Support\Facade\Route */
    use Package; /** @see \Concrete\Core\Package\Package */
    use BlockType; /** @see \Concrete\Core\Block\BlockType\BlockType */
    use BlockTypeSet; /** @see \Concrete\Core\Block\BlockType\Set */
    use PageType; /** @see \Concrete\Core\Page\Type\Type */
    use PageTemplate; /** @see \Concrete\Core\Page\Template */
    use PageTheme; /** @see \Concrete\Core\Page\Theme\Theme */
    use FileSet; /** @see \Concrete\Core\File\Set\Set */
    use CollectionAttributeKey; /** @see \Concrete\Core\Attribute\Key\CollectionKey */
    use UserAttributeKey; /** @see \Concrete\Core\Attribute\Key\UserKey */
    use FileAttributeKey; /** @see \Concrete\Core\Attribute\Key\FileKey */
    use Group; /** @see \Concrete\Core\User\Group\Group */
    use GroupSet; /** @see \Concrete\Core\User\Group\GroupSet */
    use Stack; /** @see \Concrete\Core\Page\Stack\Stack */
    use Concrete\Core\Page\Type\PublishTarget\Type\Type as PublishTargetType;

    class Controller extends Package {

        const PACKAGE_HANDLE                    = 'artsy';
        const ATTR_COLLECTION_BACKGROUND_IMG    = 'header_background';
        const FILESET_BACKGROUND_IMG            = 'Random Header Backgrounds';
        const STACK_HOMEPAGE_VIDEO              = 'Homepage_Video';
        const AREA_MAIN                         = 'Main';
        const AREA_MAIN_2                       = 'Main 2';

        protected $pkgHandle 			        = self::PACKAGE_HANDLE;
        protected $appVersionRequired 	        = '5.7.3.2';
        protected $pkgVersion 			        = '0.04';


        /**
         * @return string
         */
        public function getPackageName(){
            return t('Artsy');
        }


        /**
         * @return string
         */
        public function getPackageDescription() {
            return t('Center For the Arts');
        }


        /**
         * Run hooks high up in the load chain.
         * @return void
         */
        public function on_start(){
            define('ARTSY_IMAGE_PATH', DIR_REL . '/packages/' . $this->pkgHandle . '/images/');
        }


        /**
         * Proxy to the parent uninstall method
         * @return void
         */
        public function uninstall() {
            parent::uninstall();

            try {
                // delete database tables (if applicable)
            }catch(Exception $e){ /* FAIL GRACEFULLY */ }
        }


        /**
         * Run before install or upgrade to ensure dependencies
         * are present.
         * @todo: include package dependency checks
         */
        private function checkDependencies(){

        }


        /**
         * @return void
         */
        public function upgrade(){
            $this->checkDependencies();
            parent::upgrade();
            $this->installAndUpdate();
        }


        /**
         * @return void
         */
        public function install() {
            $this->checkDependencies();
            $this->_packageObj = parent::install();
            $this->installAndUpdate();
        }


        /**
         * Handle all the updating methods.
         * @return void
         */
        private function installAndUpdate(){
            $this->setupAttributeTypeAssociations()
                ->setupCollectionAttributes()
                ->setupFileAttributes()
                ->setupFileSets()
                ->setupStacks()
                ->setupTheme()
                ->setupTemplates()
                ->setupPageTypes()
                ->assignPageTypes()
                ->setupSinglePages()
                ->setupBlockTypeSets()
                ->setupBlocks();
        }


        /**
         * @return Controller
         */
        private function setupAttributeTypeAssociations(){
            return $this;
        }


        /**
         * @return Controller
         */
        private function setupCollectionAttributes(){
            if( !is_object(CollectionAttributeKey::getByHandle(self::ATTR_COLLECTION_BACKGROUND_IMG)) ){
                CollectionAttributeKey::add($this->attributeType('image_file'), array(
                    'akHandle'  => self::ATTR_COLLECTION_BACKGROUND_IMG,
                    'akName'    => 'Background Image'
                ), $this->packageObject());
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupFileAttributes(){
            return $this;
        }


        /**
         * @return Controller
         */
        private function setupFileSets(){
            if( ! is_object(FileSet::getByName(self::FILESET_BACKGROUND_IMG)) ){
                FileSet::createAndGetSet(self::FILESET_BACKGROUND_IMG, FileSet::TYPE_PUBLIC);
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupStacks(){
            if( ! is_object(Stack::getByName(self::STACK_HOMEPAGE_VIDEO)) ){
                Stack::addStack(self::STACK_HOMEPAGE_VIDEO);
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupTheme(){
            try {
                if( ! is_object(PageTheme::getByHandle('artsy')) ){
                    /** @var $theme \Concrete\Core\Page\Theme\Theme */
                    $theme = PageTheme::add('artsy', $this->packageObject());
                    $theme->applyToSite();
                }
            }catch(Exception $e){ /* fail gracefully */ }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupTemplates(){
            if( ! PageTemplate::getByHandle('default') ){
                PageTemplate::add('default', t('Default'), 'full.png', $this->packageObject());
            }

            if( ! PageTemplate::getByHandle('home') ){
                PageTemplate::add('home', t('Home'), 'full.png', $this->packageObject());
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupPageTypes(){
            /** @var $pageType \Concrete\Core\Page\Type\Type */
            $pageType = PageType::getByHandle('page');

            // Delete it?
            if( is_object($pageType) && !((int)$pageType->getPackageID() >= 1) ){
                $pageType->delete();
            }

            if( !is_object(PageType::getByHandle('page')) ){
                /** @var $ptPage \Concrete\Core\Page\Type\Type */
                $ptPage = PageType::add(array(
                    'handle'                => 'page',
                    'name'                  => t('Page'),
                    'defaultTemplate'       => PageTemplate::getByHandle('default'),
                    'ptIsFrequentlyAdded'   => 1,
                    'ptLaunchInComposer'    => 1
                ), $this->packageObject());

                // Set configured publish target
                $ptPage->setConfiguredPageTypePublishTargetObject(
                    PublishTargetType::getByHandle('all')->configurePageTypePublishTarget($ptPage, array(
                        'ptID' => $ptPage->getPageTypeID()
                    ))
                );

                /** @var $layoutSet \Concrete\Core\Page\Type\Composer\FormLayoutSet */
                $layoutSet = $ptPage->addPageTypeComposerFormLayoutSet('Basics', 'Basics');

                /** @var $controlTypeCorePageProperty \Concrete\Core\Page\Type\Composer\Control\Type\CorePagePropertyType */
                $controlTypeCorePageProperty = \Concrete\Core\Page\Type\Composer\Control\Type\Type::getByHandle('core_page_property');

                /** @var $controlTypeName \Concrete\Core\Page\Type\Composer\Control\CorePageProperty\NameCorePageProperty */
                $controlTypeName = $controlTypeCorePageProperty->getPageTypeComposerControlByIdentifier('name');
                $controlTypeName->addToPageTypeComposerFormLayoutSet($layoutSet)
                    ->updateFormLayoutSetControlRequired(true);

                /** @var $controlTypePublishTarget \Concrete\Core\Page\Type\Composer\Control\CorePageProperty\PublishTargetCorePageProperty */
                $controlTypePublishTarget = $controlTypeCorePageProperty->getPageTypeComposerControlByIdentifier('publish_target');
                $controlTypePublishTarget->addToPageTypeComposerFormLayoutSet($layoutSet)
                    ->updateFormLayoutSetControlRequired(true);
            }

            return $this;
        }


        /**
         * @return Controller
         */
        function assignPageTypes(){
            Loader::db()->Execute('UPDATE Pages set pkgID = ? WHERE cID = 1', array(
                (int) $this->packageObject()->getPackageID()
            ));

            // Things available through the API
            $homePageCollection = \Concrete\Core\Page\Page::getByID(1)->getVersionToModify();
            $homePageCollection->update(array(
                'pTemplateID' => PageTemplate::getByHandle('home')->getPageTemplateID()
            ));
            $homePageCollection->setPageType(PageType::getByHandle('page'));

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupSinglePages(){
            return $this;
        }


        /**
         * @return Controller
         */
        private function setupBlockTypeSets(){
            if( !is_object(BlockTypeSet::getByHandle(self::PACKAGE_HANDLE)) ){
                BlockTypeSet::add(self::PACKAGE_HANDLE, self::PACKAGE_HANDLE, $this->packageObject());
            }

            return $this;
        }


        /**
         * @return Controller
         */
        private function setupBlocks(){
            if(!is_object(BlockType::getByHandle('photo_wall'))) {
                BlockType::installBlockTypeFromPackage('photo_wall', $this->packageObject());
            }
//            if(!is_object(BlockType::getByHandle('accordion'))) {
//                BlockType::installBlockTypeFromPackage('accordion', $this->packageObject());
//            }
//
//            if(!is_object(BlockType::getByHandle('quotes'))) {
//                BlockType::installBlockTypeFromPackage('quotes', $this->packageObject());
//            }
//
//            if(!is_object(BlockType::getByHandle('statistic'))) {
//                BlockType::installBlockTypeFromPackage('statistic', $this->packageObject());
//            }

            return $this;
        }


        /**
         * Get the package object; if it hasn't been instantiated yet, load it.
         * @return \Concrete\Core\Package\Package
         */
        private function packageObject(){
            if( $this->_packageObj === null ){
                $this->_packageObj = Package::getByHandle( $this->pkgHandle );
            }
            return $this->_packageObj;
        }


        /**
         * @return AttributeType
         */
        private function attributeType( $handle ){
            if( is_null($this->{"at_{$handle}"}) ){
                $attributeType = \Concrete\Core\Attribute\Type::getByHandle($handle);
                if( is_object($attributeType) && $attributeType->getAttributeTypeID() >= 1 ){
                    $this->{"at_{$handle}"} = $attributeType;
                }
            }
            return $this->{"at_{$handle}"};
        }

    }
}
