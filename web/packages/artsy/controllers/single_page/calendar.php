<?php namespace Concrete\Package\Artsy\Controller\SinglePage {

    use \Concrete\Package\Schedulizer\Src\Calendar AS SchedulizerCalendar;
    use \Concrete\Package\Schedulizer\Src\EventTag AS SchedulizerTag;
    use \Concrete\Package\Schedulizer\Src\EventCategory AS SchedulizerCategory;
    use \Concrete\Package\Schedulizer\Src\Attribute\Key\SchedulizerEventKey;
    use \Concrete\Package\Artsy\Controller\ArtsyPageController;

    class Calendar extends ArtsyPageController {

        protected $_includeThemeAssets = true;

        public function view(){
            parent::view();
            $this->set('tagList', $this->tagList());
            $this->set('calendarList', $this->calendarList());
            $this->set('categoryList', $this->categoryList());
        }

        protected function tagList(){
            if( $this->_tagList === null ){
                $this->_tagList = array();
                foreach(SchedulizerTag::fetchAll() AS $tagObj){
                    $this->_tagList[$tagObj->getID()] = $tagObj->getDisplayText();
                }
            }
            return $this->_tagList;
        }

        protected function calendarList(){
            if( $this->_calendarList === null ){
                $this->_calendarList = array();
                foreach(SchedulizerCalendar::fetchAll() AS $calendarObj){
                    $this->_calendarList[$calendarObj->getID()] = $calendarObj->getTitle();
                }
            }
            return $this->_calendarList;
        }

        protected function categoryList(){
            if( $this->_categoryList === null ){
                $this->_categoryList = array();
                foreach(SchedulizerCategory::fetchAll() AS $categoryObj){
                    $this->_categoryList[$categoryObj->getID()] = $categoryObj->getDisplayText();
                }
            }
            return $this->_categoryList;
        }

    }
}