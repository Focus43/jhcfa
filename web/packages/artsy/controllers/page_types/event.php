<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use Page;
    use FileSet;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;
    use \Concrete\Package\Schedulizer\Src\Event AS SchedulizerEvent;
    use \Concrete\Package\Schedulizer\Src\Calendar AS SchedulizerCalendar;
    use \Concrete\Package\Schedulizer\Src\EventList AS SchedulizerEventList;

    class Event extends ArtsyPageController {

        protected $_includeThemeAssets = true;

        public function view(){
            parent::view();
            $this->set('mastheadHelper', new \Concrete\Package\Artsy\Src\Helpers\Masthead($this->getPageObject()));
            $pageID = Page::getCurrentPage()->getCollectionID();
            /** @var $eventObj \Concrete\Package\Schedulizer\Src\Event */
            $eventObj = SchedulizerEvent::getByPageID($pageID);
            if( is_object($eventObj) ){
                $this->set('eventObj', $eventObj);
                $this->set('calendarObj', SchedulizerCalendar::getByID($eventObj->getCalendarID()));
                $this->set('eventTimes', (array) $this->eventList($eventObj)->get());
            }
        }

        protected function eventList( $eventObj ){
            $eventListObj = new SchedulizerEventList(array($eventObj->getCalendarID()));
            $eventListObj->setEventIDs(array($eventObj->getID()));
            $eventListObj->setDaysIntoFuture(31);
            $eventListObj->includeColumns(array(
                'computedStartLocal'
            ));
            return $eventListObj;
        }

    }

}