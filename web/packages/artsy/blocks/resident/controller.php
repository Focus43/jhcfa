<?php namespace Concrete\Package\Artsy\Block\Resident;

    use Loader;

    class Controller extends \Concrete\Core\Block\BlockController {


        protected $btTable 									= 'btResident';
        protected $btInterfaceWidth 						= '650';
        protected $btInterfaceHeight						= '480';
        protected $btDefaultSet                             = 'artsy';
        protected $btCacheBlockRecord 						= true;
        protected $btCacheBlockOutput 						= true;
        protected $btCacheBlockOutputOnPost 				= true;
        protected $btCacheBlockOutputForRegisteredUsers 	= false;
        protected $btCacheBlockOutputLifetime 				= 0;

        public function getBlockTypeDescription(){
            return t("Add Resident Information");
        }


        public function getBlockTypeName(){
            return t("Resident Information");
        }


        public function view(){
            $this->requireAsset('redactor');
            $this->requireAsset('core/file-manager');
            $this->addFooterItem('<script type="text/javascript">var CCM_EDITOR_SECURITY_TOKEN = \''.Loader::helper('validation/token')->generate('editor').'\'</script>');
        }


        public function add(){
            $this->edit();
        }


        public function composer(){
            $this->edit();
        }


        /**
         * Called automatically by framework
         * @param array $args
         */
        public function save( $args ){
            parent::save( $args );
        }

    }