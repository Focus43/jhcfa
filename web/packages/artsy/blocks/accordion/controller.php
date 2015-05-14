<?php namespace Concrete\Package\Artsy\Block\Accordion;

    use Loader;
    use \Concrete\Core\Editor\LinkAbstractor;

    /**
     * Accordion
     */
    class Controller extends \Concrete\Core\Block\BlockController {

        protected $btTable 									= 'btAccordion';
        protected $btInterfaceWidth 						= '580';
        protected $btInterfaceHeight						= '400';
        protected $btDefaultSet                             = 'artsy';
        protected $btCacheBlockRecord 						= true;
        protected $btCacheBlockOutput 						= true;
        protected $btCacheBlockOutputOnPost 				= true;
        protected $btCacheBlockOutputForRegisteredUsers 	= false;
        protected $btCacheBlockOutputLifetime 				= 0;

        public function getBlockTypeDescription(){
            return t("Create an accordion");
        }


        public function getBlockTypeName(){
            return t("Accordion");
        }


        public function add(){
            $this->edit();
        }


        public function composer(){
            $this->edit();
        }


        public function edit(){
            $this->requireAsset('redactor');
            $this->requireAsset('core/file-manager');

            // Pass data
            $this->set('dataFields', (array) Loader::helper('json')->decode($this->dataFields));
        }


        public function view(){
            $this->set('dataFields', (array) Loader::helper('json')->decode($this->dataFields));
        }


        public function _translateFromEditMode( $content ){
            return LinkAbstractor::translateFromEditMode($content);
        }


        public function _translateFrom( $content ){
            return LinkAbstractor::translateFrom($content);
        }


        public function save( $args ){
            $data = array();
            foreach((array)$args['heading'] AS $index => $heading){
                if( !empty($heading) ){
                    array_push($data, (object)array(
                        'heading' => $heading,
                        'body'    => LinkAbstractor::translateTo($args['body'][$index])
                    ));
                }
            }

            parent::save(array(
                'dataFields' => Loader::helper('json')->encode($data)
            ));
        }

    }