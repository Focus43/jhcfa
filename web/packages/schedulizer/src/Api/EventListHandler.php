<?php namespace Concrete\Package\Schedulizer\Src\Api {

    use \Exception;
    use \DateTime;
    use \DateTimeZone;
    use \Concrete\Package\Schedulizer\Src\EventList;
    use \Concrete\Package\Schedulizer\Src\Api\Utilities\EventFeedFormat;
    use \Symfony\Component\HttpFoundation\Request;
    use \Symfony\Component\HttpFoundation\JsonResponse;
    use \Concrete\Core\Controller\Controller AS CoreController;

    class EventListHandler extends CoreController {

        protected $responseObj;
        protected $requestObj;

        public function dispatch( Request $request, $calendarID = null ){
            $this->responseObj = new JsonResponse();
            $this->requestObj = $request;

            try {
                $this->execute($calendarID);
            }catch(Exception $e){
                $this->responseObj->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                $this->responseObj->setData((object) array(
                    'error' => $e->getMessage(),
                    'line'  => $e->getLine(),
                    'file'  => $e->getFile()
                ));
            }

            return $this->responseObj;
        }


        /**
         * Delegates parsing the query parameters to other methods,
         * and passes to EventFeedFormat to handle casting all the data
         * types and such.
         * @param $calendarID
         */
        protected function execute( $calendarID ){
            $eventList = new EventList(array($calendarID));
            $this->setStartDate($eventList);
            $this->setEndDate($eventList);
            $this->setFetchColumns($eventList);
            $this->responseObj->setData(new EventFeedFormat($eventList));
            $this->responseObj->setStatusCode(JsonResponse::HTTP_OK);
        }


        /**
         * eg. ?start=2015-04-02
         * @param EventList $eventList
         */
        protected function setStartDate( EventList $eventList ){
            if( !empty($this->requestParams()->start) ){
                $eventList->setStartDate(new DateTime($this->requestParams()->start, new DateTimeZone('UTC')));
            }
        }

        /**
         * eg. ?end=2015-04-02
         * @param EventList $eventList
         */
        protected function setEndDate( EventList $eventList ){
            if( !empty($this->requestParams()->end) ){
                $eventList->setEndDate(new DateTime($this->requestParams()->end, new DateTimeZone('UTC')));
            }
        }

        /**
         * Comma-delimited list of include fields.
         * eg. ?fields=eventID,calendarID
         * @param EventList $eventList
         */
        protected function setFetchColumns( EventList $eventList ){
            if( !empty($this->requestParams()->fields) ){
                $eventList->includeColumns(explode(',', $this->requestParams()->fields));
            }
        }

        /**
         * Get a parsed stdObject of the query string.
         * @return object
         */
        protected function requestParams(){
            if( $this->_requestParams === null ){
                parse_str($this->requestObj->getQueryString(), $parsed);
                $this->_requestParams = (object) $parsed;
            }
            return $this->_requestParams;
        }

    }

}