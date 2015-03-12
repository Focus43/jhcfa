<?php namespace Concrete\Package\Artsy\Src\Helpers {

    use File;
    use FileSet;
    use FileList;
    use Concrete\Package\Artsy\Controller AS PackageController;

    class Masthead {

        const IMG_COMPRESSION   = 85,
              IMAGE_WIDTH       = 1920,
              IMAGE_HEIGHT      = 1080;

        /** @var $pageObj \Concrete\Core\Page\Page */
        protected $pageObj;


        /**
         * When initializing the helper, pass in the $pageObject for methods to
         * pull attributes from, if necessary.
         * @param \Concrete\Core\Page\Page $pageObject
         */
        public function __construct( \Concrete\Core\Page\Page $pageObject ){
            $this->pageObj = $pageObject;
        }


        /**
         * First, try and get a specific image assigned to the page attribute header_background,
         * and return the path to its' resized source.
         * Second, pull a random image from the Header Backgrounds file set and return the path
         * to its' resized source.
         *
         * @return string
         */
        public function getSingleImageSrc(){
            $fileObj = $this->pageObj->getAttribute(PackageController::ATTR_COLLECTION_BACKGROUND_IMG);
            if( $fileObj instanceof File && $fileObj->getFileID() >= 1 ){
                return $fileObj->getApprovedVersion()->getRelativePath();
                //return \Core::make('helper/image')->setJpegCompression(self::IMG_COMPRESSION)->getThumbnail($fileObj, self::IMAGE_WIDTH, self::IMAGE_HEIGHT)->src;
            }

            /** @var $fileList \Concrete\Core\File\FileList */
            $fileList = new FileList();
            $fileList->filterBySet(FileSet::getByName(PackageController::FILESET_BACKGROUND_IMG));
            $results = $fileList->getQueryObject()->execute()->fetchAll();
            if( !empty($results) ){
                return File::getByID($results[array_rand($results, 1)]['fID'])->getApprovedVersion()->getRelativePath();
            }
        }

    }

}