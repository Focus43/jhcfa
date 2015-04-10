<?php namespace Concrete\Package\Schedulizer\Src\Api {

    use Config;
    use User;
    use \Exception;
    use \Concrete\Package\Schedulizer\Src\Calendar;
    use \Concrete\Package\Schedulizer\Src\Event;
    use \Symfony\Component\HttpFoundation\Request;
    use \Symfony\Component\HttpFoundation\JsonResponse;
    use \Concrete\Core\Controller\Controller AS CoreController;

    class CalendarEventsHandler extends CoreController {

        const   VERBOSITY_SIMPLE    = 'simple',
                VERBOSITY_COMPLETE  = 'complete';

        protected $_response;
        protected $_request;

        /**
         * Dispatch to the correct handler
         * @param Request $request
         * @param $calendarID
         * @return JsonResponse
         */
        public function dispatch( Request $request, $calendarID, $verbosity = self::VERBOSITY_SIMPLE ){
            $this->_response = new JsonResponse();
            $this->_request  = $request;

            // Right out of the gate, if no calendarID is passed, return not acceptable
            if( empty($calendarID) ){
                $this->_response->setStatusCode(JsonResponse::HTTP_NOT_ACCEPTABLE);
                $this->_response->setData((object) array(
                    'error' => 'CalendarID must be passed as a route parameter'
                ));
                return $this->_response;
            }

            try {
                $verbosity = empty($verbosity) ? self::VERBOSITY_SIMPLE : $verbosity;
                switch($verbosity){
                    case self::VERBOSITY_SIMPLE: $this->getSimple($calendarID); break;
                }
            }catch(Exception $e){
                $this->_response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                $this->_response->setData((object) array(
                    'error' => $e->getMessage(),
                    'line'  => $e->getLine(),
                    'file'  => $e->getFile()
                ));
            }

            return $this->_response;
        }

        /**
         * Get a calendar by its ID
         * @param null $calendarID
         * @return mixed
         */
        public function getSimple( $calendarID ){
            $events = Event::fetchSimplebyCalendarID($calendarID);
            // Set response data
            $this->_response->setData($events);
            $this->_response->setStatusCode(JsonResponse::HTTP_OK);
        }

        /**
         * Get a parsed stdObject of the query string.
         * @return object
         */
        protected function requestParams(){
            if( $this->_requestParams === null ){
                parse_str($this->_request->getQueryString(), $parsed);
                $this->_requestParams = (object) $parsed;
            }
            return $this->_requestParams;
        }

    }

}