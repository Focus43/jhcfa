<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use Page;
    use File;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;
    use \Concrete\Package\Schedulizer\Src\Event AS SchedulizerEvent;
    use \Concrete\Package\Schedulizer\Src\Calendar AS SchedulizerCalendar;
    use \Concrete\Package\Schedulizer\Src\EventList AS SchedulizerEventList;

    class Event extends ArtsyPageController {

        protected $_includeThemeAssets = true;

        public function view(){
            parent::view();
            $pageID = $this->getPageObject()->getCollectionID();
            /** @var $eventObj \Concrete\Package\Schedulizer\Src\Event */
            $eventObj = SchedulizerEvent::getByPageID($pageID);
            if( is_object($eventObj) ){
                $this->set('eventObj', $eventObj);
                $this->set('calendarObj', $eventObj->getCalendarObj());
                $this->set('eventTimes', (array) $this->eventList($eventObj)->get());
                // Event File
                $eventFileObj = File::getByID($eventObj->getFileID());
                if( is_object($eventFileObj) ){
                    $this->set('eventThumbnailPath', $eventFileObj->getThumbnailURL('event_thumb'));
                }
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