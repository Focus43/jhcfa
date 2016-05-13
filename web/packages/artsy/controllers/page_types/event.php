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

            /** @var int $pageID *THIS* page ID being viewed */
            $pageID = (int) $this->getPageObject()->getCollectionID();

            /** @var $eventObj \Concrete\Package\Schedulizer\Src\Event */
            $eventObj = SchedulizerEvent::getByPageID($pageID);

            /** @var $schedulizerCollection \Concrete\Package\Schedulizer\Src\Collection */
            $schedulizerCollection = $this->schedulizerMasterCollectionObj();

            // Assuming $schedulizerCollection is an object (it should be cause it shouldn't be
            // deleted, ever); then get the *approved* version object
            if( is_object($schedulizerCollection) ){
                $eventObj = $eventObj->getVersionApprovedByCollection($schedulizerCollection);
            }

            // If we have a valid object, pass things to the view
            if( is_object($eventObj) ){
                $first10EventTimes = $this->eventTimes($eventObj);
                $this->set('eventObj', $eventObj);
                $this->set('calendarObj', $eventObj->getCalendarObj());
                $this->set('first10EventTimes', $first10EventTimes);
                $this->thumbnailData($eventObj);
                $this->getJsonGoogleSearchTags($eventObj, $first10EventTimes);
            }
        }

        // this is the function to dump the JSON-LD info into Events pages
        protected function getJsonGoogleSearchTags($eventObj, $first10EventTimes){
          $payload["@context"] = "http://schema.org/";
          $payload["@type"] = "Event";
          $payload["name"] = $eventObj->getTitle();
          //$payload["image"] = $this->addHeaderItem(sprintf('<meta property="og:image" content="%s" />', $thumbnailPath));
          $payload["startDate"] = $this->formatAsUTC($first10EventTimes[0]['computedStartUTC']);
          $payload["location"] = array(
            "@type" => "Place",
            "name" => "The Center",
            "sameAs" => "http://jhcenterforthearts.org/",
            "address" => array(
            "streetAddress" => "240 S. Glenwood St.",
            "addressLocality" => "Jackson Hole",
            "addressRegion" => "Wyoming",
            "postalCode" => "83001",
            "addressCountry" => "USA"),
          );
        //  print_r($first10EventTimes[0]);
          $this->set('googleJsonPayload', json_encode($payload));
        }

        protected function formatAsUTC($dateString){
          $dateObj = new \DateTime($dateString, new \DateTimeZone('UTC'));
          return $dateObj->format(\DateTime::ISO8601);
        }

        /**
         * Get image for event (if exists), and pass its path to the view, as well as setting
         * the og:image meta tag.
         * @param SchedulizerEvent $eventObj
         * @return void
         */
        protected function thumbnailData( \Concrete\Package\Schedulizer\Src\Event $eventObj ){
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


        /**
         * Use the schedulizer event list for query'ing times.
         * @param SchedulizerEvent $eventObj
         * @return SchedulizerEventList
         */
        protected function eventTimes( \Concrete\Package\Schedulizer\Src\Event $eventObj ){
            // Create event list object
            $eventListObj = new SchedulizerEventList(array($eventObj->getCalendarID()));
            $eventListObj->setEventIDs(array($eventObj->getID()));
            $eventListObj->setFilterByMasterCollection(true);
            // $eventObj->getEarliestStartTime() returns a filtered DateTime object representing earliest occurrence of the event
            //$eventListObj->setStartDate($eventObj->getEarliestStartTime());
            $eventListObj->setDaysIntoFuture(365);
            $eventListObj->includeColumns(array(
              'computedStartLocal', 'computedStartUTC'
            ));

            // Get event times and split into first 10 and then the rest
            $allEventTimes      = (array) $eventListObj->get();
            $first10EventTimes  = array_slice($allEventTimes, 0, 10);
            $moreEventTimes     = array_slice($allEventTimes, 10);
            // when this function is invoked this will automatically set more event times
            // on the view, but we return first 10 event times so the data can be used for
            // other things in the controller
            $this->set('moreEventTimes', (array) $moreEventTimes);

            return $first10EventTimes;
        }


        /**
         * @return \Concrete\Package\Schedulizer\Src\Collection | void
         */
        protected function schedulizerMasterCollectionObj(){
            if( $this->_schedulizerMasterCollection === null ){
                $this->_schedulizerMasterCollection = SchedulizerCollection::getMasterCollection();
            }
            return $this->_schedulizerMasterCollection;
        }

    }

}
