<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use Page;
    use File;
    use \Concrete\Package\Schedulizer\Src\Event AS SchedulizerEvent;
    use \Concrete\Package\Schedulizer\Src\Calendar AS SchedulizerCalendar;
    use \Concrete\Package\Schedulizer\Src\EventList AS SchedulizerEventList;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;

    class Event extends ArtsyPageController {

        protected $_includeThemeAssets          = true;
        protected $_includeOpenGraphImageTag    = false;

        public function view(){
            parent::view();
            $pageID = $this->getPageObject()->getCollectionID();
            /** @var $eventObj \Concrete\Package\Schedulizer\Src\Event */
            $eventObj = SchedulizerEvent::getByPageID($pageID);
            if( is_object($eventObj) ){
                $this->set('eventObj', $eventObj);
                $this->set('calendarObj', $eventObj->getCalendarObj());

                // Get event times and split into first 10 and then the rest
                $allEventTimes      = (array) $this->eventList($eventObj)->get();
                $first10EventTimes  = array_slice($allEventTimes, 0, 10);
                $moreEventTimes     = array_slice($allEventTimes, 10);
                $this->set('first10EventTimes', (array) $first10EventTimes);
                $this->set('moreEventTimes', (array) $moreEventTimes);

                // Event File
                $fileID = $eventObj->getFileID();
                if( (int)$fileID >= 1 ){
                    $eventFileObj = File::getByID($fileID);
                    if( is_object($eventFileObj) ){
                        $thumbnailPath = $eventFileObj->getThumbnailURL('event_thumb');
                        // Pass to the view
                        $this->set('eventThumbnailPath', $thumbnailPath);
                        // Set opengraph tag as well!
                        $this->addHeaderItem(sprintf('<meta property="og:image" content="%s" />', $thumbnailPath));
                    }
                }
            }

            // Set open graph article type
            $this->addHeaderItem(sprintf('<meta property="og:type" content="%s" />', 'article'));
        }

        protected function eventList( $eventObj ){
            $eventListObj = new SchedulizerEventList(array($eventObj->getCalendarID()));
            $eventListObj->setEventIDs(array($eventObj->getID()));
            $eventListObj->setDaysIntoFuture(365);
            $eventListObj->includeColumns(array(
                'computedStartLocal'
            ));
            return $eventListObj;
        }

    }

}