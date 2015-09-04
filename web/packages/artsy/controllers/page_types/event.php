<?php namespace Concrete\Package\Artsy\Controller\PageType {

    use Package;
    use Page;
    use File;
    use \Concrete\Package\Schedulizer\Src\Collection AS SchedulizerCollection;
    use \Concrete\Package\Schedulizer\Src\Event AS SchedulizerEvent;
    use \Concrete\Package\Schedulizer\Src\Calendar AS SchedulizerCalendar;
    use \Concrete\Package\Schedulizer\Src\EventList AS SchedulizerEventList;
    use Concrete\Package\Artsy\Controller\ArtsyPageController;

    class Event extends ArtsyPageController {

        protected $_includeThemeAssets          = true;
        protected $_includeOpenGraphImageTag    = false;

        public function view(){
            parent::view();
            // Set open graph article type
            $this->addHeaderItem(sprintf('<meta property="og:type" content="%s" />', 'article'));

            // Display stuff
            $pageID     = $this->getPageObject()->getCollectionID();
            $eventObj   = SchedulizerEvent::getByPageID($pageID);
            $packageObj = Package::getByHandle('schedulizer');

            // Checks for using Schedulizer's master collection
            if( (bool) $packageObj->configGet($packageObj::CONFIG_ENABLE_MASTER_COLLECTION) ){
                $masterCollID = (int) $packageObj->configGet($packageObj::CONFIG_MASTER_COLLECTION_ID);
                /** @var $collectionObj \Concrete\Package\Schedulizer\Src\Collection */
                $collectionObj = SchedulizerCollection::getByID($masterCollID);
                if( is_object($collectionObj) && is_object($eventObj) ){
                    $eventObj = $eventObj->getVersionApprovedByCollection($collectionObj->getID());
                }
            }

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
                        // Set opengraph tag
                        $this->addHeaderItem(sprintf('<meta property="og:image" content="%s" />', $thumbnailPath));
                    }
                }
            }
        }


        /**
         * Use the schedulizer event list for query'ing times.
         * @param SchedulizerEvent $eventObj
         * @return SchedulizerEventList
         */
        protected function eventList( \Concrete\Package\Schedulizer\Src\Event $eventObj ){
            // Create event list object
            $eventListObj = new SchedulizerEventList(array($eventObj->getCalendarID()));
            $eventListObj->setEventIDs(array($eventObj->getID()));
            $eventListObj->setFilterByMasterCollection(true);
            // $eventObj->getEarliestStartTime() returns a filtered DateTime object representing earliest occurrence of the event
            //$eventListObj->setStartDate($eventObj->getEarliestStartTime());
            $eventListObj->setDaysIntoFuture(365);
            $eventListObj->includeColumns(array(
                'computedStartLocal'
            ));
            return $eventListObj;
        }

    }

}