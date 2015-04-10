<?php namespace Concrete\Package\Schedulizer\Src {

    use Loader;
    use DateTime;
    use DateTimeZone;
    use \Exception;

    /**
     * Class EventList. This goes completely around Doctrine and composes the database
     * query directly; no idea how to even begin building a query like this in an ORM.
     * @package Concrete\Package\Schedulizer\Src
     */
    class EventList {

        const DATE_FORMAT               = 'Y-m-d',
              DAYS_IN_FUTURE            = 45, // span 6 weeks for some calendar views
              DAYS_IN_FUTURE_MAX        = 365,
              LIMIT_PER_DAY_MAX         = 25,
              COLUMN_CAST_TIME          = 'time',
              COLUMN_CAST_TIME_UTC      = 'utc',
              COLUMN_CAST_TIME_LOCAL    = 'local',
              COLUMN_CAST_INT           = 'int',
              COLUMN_CAST_STRING        = 'str',
              COLUMN_CAST_BOOL          = 'bool';

        protected $startDTO; // set or calculated
        protected $endDTO; // set or calculated
        protected $limitPerDay  = null;
        protected $calendarIDs  = array();
        protected $eventIDs     = array();
        protected $queryDaySpan = self::DAYS_IN_FUTURE;
        protected $fetchColumns = array(
            '_syntheticDate'                => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_UTC),
            'computedStartUTC'              => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_UTC),
            'computedStartLocal'            => array(true, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_LOCAL),
            'computedEndUTC'                => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_UTC),
            'computedEndLocal'              => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_LOCAL),
            'eventID'                       => array(true, self::COLUMN_CAST_INT),
            'calendarID'                    => array(false, self::COLUMN_CAST_INT),
            'eventTimeID'                   => array(false, self::COLUMN_CAST_INT),
            'title'                         => array(true, self::COLUMN_CAST_STRING),
            'useCalendarTimezone'           => array(false, self::COLUMN_CAST_BOOL),
            'derivedTimezone'               => array(true, self::COLUMN_CAST_STRING),
            'eventColor'                    => array(false, self::COLUMN_CAST_STRING),
            'ownerID'                       => array(false, self::COLUMN_CAST_INT),
            'fileID'                        => array(false, self::COLUMN_CAST_INT),
            'startUTC'                      => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_UTC),
            'endUTC'                        => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_UTC),
            'isOpenEnded'                   => array(false, self::COLUMN_CAST_BOOL),
            'isAllDay'                      => array(false, self::COLUMN_CAST_BOOL),
            'isRepeating'                   => array(false, self::COLUMN_CAST_BOOL),
            'repeatTypeHandle'              => array(false, self::COLUMN_CAST_STRING),
            'repeatEvery'                   => array(false, self::COLUMN_CAST_INT),
            'repeatIndefinite'              => array(false, self::COLUMN_CAST_BOOL),
            'repeatEndUTC'                  => array(false, self::COLUMN_CAST_TIME, self::COLUMN_CAST_TIME_UTC),
            'repeatMonthlyMethod'           => array(false, self::COLUMN_CAST_STRING),
            'repeatMonthlySpecificDay'      => array(false, self::COLUMN_CAST_INT),
            'repeatMonthlyOrdinalWeek'      => array(false, self::COLUMN_CAST_INT),
            'repeatMonthlyOrdinalWeekday'   => array(false, self::COLUMN_CAST_INT),
            'repeatWeeklyDay'               => array(false, self::COLUMN_CAST_INT),
            'isSynthetic'                   => array(false, self::COLUMN_CAST_BOOL)
        );

        /**
         * @param array $calendarIDs
         */
        public function __construct( array $calendarIDs = array() ){
            $this->setCalendarIDs($calendarIDs);
        }

        /**
         * Allows specifying the results to be returned. Just pass in a column
         * name (as documented by fetchColumns), and it'll automatically be
         * included in the result set.
         * @param array $columns
         */
        public function includeColumns( array $columns = array() ){
            $available = array_keys($this->fetchColumns);
            foreach($columns AS $columnName){
                if( in_array($columnName, $available) ){
                    $this->fetchColumns[$columnName][0] = true;
                }
            }
        }

        /**
         * @todo: don't allow excluding derivedTimezone
         * @param array $columns
         */
        public function excludeColumns( array $columns = array() ){

        }

        /**
         * Set the start date
         * @param DateTime $start
         * @return $this
         */
        public function setStartDate( \DateTime $start ){
            $this->startDTO = $start;
            return $this;
        }

        /**
         * Set the end date time to filter by.
         * @param DateTime $end
         * @return $this
         */
        public function setEndDate( \DateTime $end ){
            $this->endDTO = $end;
            return $this;
        }

        /**
         * Add calendar id/idS to be filtered by.
         * @param $calendarIDs
         * @return $this
         */
        public function setCalendarIDs( $calendarIDs ){
            if( is_array($calendarIDs) ){
                $this->calendarIDs = array_unique(array_merge($this->calendarIDs, $calendarIDs));
                return $this;
            }
            array_push($this->calendarIDs, $calendarIDs);
            $this->calendarIDs = array_unique($this->calendarIDs);
            return $this;
        }

        /**
         * Add an id/idS to be filtered by.
         * @param $eventIDs
         * @return $this
         */
        public function setEventIDs( $eventIDs ){
            if( is_array($eventIDs) ){
                $this->eventIDs = array_unique(array_merge($this->eventIDs, $eventIDs));
                return $this;
            }
            array_push($this->eventIDs, $eventIDs);
            $this->eventIDs = array_unique($this->eventIDs);
            return $this;
        }

        /**
         * Use to restrict the number of results PER DAY that can
         * be returned.
         * @param $limit
         * @return $this
         */
        public function setLimitPerDay( $limit ){
            if( (int)$limit >= self::LIMIT_PER_DAY_MAX ){
                $limit = self::LIMIT_PER_DAY_MAX;
            }
            $this->limitPerDay = (int)$limit;
            return $this;
        }

        /**
         * @todo: probably figure out a way to re-enable a maximum limit on the query
         * day span so we can't arbitrarily murder the database...
         * @param int $number
         * @return $this
         */
        public function setDaysIntoFuture( $number = self::DAYS_IN_FUTURE ){
            if( (int)$number >= self::DAYS_IN_FUTURE_MAX ){
                $number = self::DAYS_IN_FUTURE_MAX;
            }
            $this->queryDaySpan = (int)$number;
            return $this;
        }

        /**
         * Fetch the results.
         * @return mixed
         * @throws Exception
         */
        public function get(){
            return Loader::db()->GetAll($this->assembledQuery());
        }

        /**
         * Get a list of results but group 'em by day
         */
        public function getGroupedByDay(){
            $grouped = array();
            foreach((array)$this->get() AS $row){
                $dateKey = substr($row['computedStartLocal'], 0, 10);
                if( ! $grouped[$dateKey] ){
                    $grouped[$dateKey] = array();
                }
                array_push($grouped[$dateKey], $row);
            }
            return $grouped;
        }


        /**
         * Gets the columns this query is going to use.
         * @return array
         */
        public function getQueryColumnSettings(){
            if( $this->_queryColumnSettings === null ){
                $this->_queryColumnSettings = array_filter($this->fetchColumns, function( $definition ){
                    return $definition[0] === true;
                });
            }
            return $this->_queryColumnSettings;
        }


        /**
         * Parse the entire query string together.
         * @return string
         * @throws Exception
         */
        protected function assembledQuery(){
            if( ! $this->_assembledQuery ){
                // Throw exception if no calendarIDs specified
                if( empty($this->calendarIDs) ){
                    throw new Exception("No calendar IDs specified.");
                }

                // If start hasn't been declared, set it to today but time 00:00:00
                if( !($this->startDTO instanceof DateTime) ){
                    $this->startDTO = new DateTime('now', new DateTimeZone('UTC'));
                    $this->startDTO->setTime(0,0,0);
                }

                // Conversely, if the endDTO *HAS* been set, automatically adjust
                // the queryDaySpan property to be the difference between start and end
                if( $this->endDTO instanceof DateTime ){
                    $daySpan = $this->endDTO->diff($this->startDTO, true)->days + 1;
                    $daySpan = ($daySpan >= self::DAYS_IN_FUTURE_MAX) ? self::DAYS_IN_FUTURE_MAX : $daySpan;
                    $this->queryDaySpan = $daySpan;
                }

                $this->_assembledQuery = $this->queryString();
            }
            return $this->_assembledQuery;
        }

        /**
         * To whoever may inherit this., I'm sorry. Anyways...
         * Restrictors on internal join (superbly limits result set). By
         * the time this gets called in the queryString() method, everything
         * used by this method will be "prepared" (ready to use).
         * @return string
         */
        protected function subqueryRestrictions(){
            $calendarIDs = join(',', $this->calendarIDs);
            $endDateDTO  = clone $this->startDTO;
            $endDateDTO->modify("+{$this->queryDaySpan} days");
            $endDate = $endDateDTO->format(self::DATE_FORMAT);

            $restrictor = "sev.calendarID in ({$calendarIDs}) AND (DATE(sevt.startUTC) < DATE('{$endDate}'))";
            if( !empty($this->eventIDs) ){
                $eventIDs = join(',', $this->eventIDs);
                $restrictor .= " AND sev.id in ({$eventIDs})";
            }

            return $restrictor;
        }


        /**
         * Setup the base query string. This is the stupidest/beastliest SQL query ever.
         * @todo: repeat yearly (just once per year)
         * @todo: last (> 4th) "Tuesday" or whatever day of the month.
         * @note: the end date time is only used in the subquery restrictors, and
         * gets setup automatically based on the query day span (eg. it isn't used
         * in a where clause anywhere except as a restriction on the massive internally
         * joined table)
         * @return string
         */
        protected function queryString(){
            $startDate      = $this->startDTO->format(self::DATE_FORMAT);
            $restrictor     = $this->subqueryRestrictions();
            $queryDaySpan   = $this->queryDaySpan;
            $selectColumns  = join(',', array_keys($this->getQueryColumnSettings()));
            // By default, we don't setup a limit per day...
            $limitPerDay = '';
            if( (int)$this->limitPerDay >= 1 ){
                $limitPerDay = sprintf(' LIMIT %s', (int)$this->limitPerDay);
            }

            return "SELECT {$selectColumns} FROM (
              SELECT
                _synthesized._syntheticDate,
                TIMESTAMP(_synthesized._syntheticDate, TIME(_events.startUTC)) AS computedStartUTC,
                (CASE WHEN (
                  _events.repeatTypeHandle = 'weekly') AND
                  (_synthesized._syntheticDate != DATE(CONVERT_TZ(TIMESTAMP(DATE(_synthesized._syntheticDate), TIME(_events.startUTC)), 'UTC', _events.derivedTimezone)))
                IS TRUE THEN
                  TIMESTAMP(_synthesized._syntheticDate, TIME(CONVERT_TZ(TIMESTAMP(DATE(_synthesized._syntheticDate), TIME(_events.startUTC)), 'UTC', _events.derivedTimezone)))
                ELSE
                  CONVERT_TZ(TIMESTAMP(DATE(_synthesized._syntheticDate), TIME(_events.startUTC)), 'UTC', _events.derivedTimezone)
                END) AS computedStartLocal,
                TIMESTAMPADD(MINUTE, TIMESTAMPDIFF(MINUTE,_events.startUTC,_events.endUTC), TIMESTAMP(_synthesized._syntheticDate, TIME(_events.startUTC))) AS computedEndUTC,
                CONVERT_TZ(TIMESTAMPADD(MINUTE, TIMESTAMPDIFF(MINUTE,_events.startUTC,_events.endUTC), TIMESTAMP(_synthesized._syntheticDate, TIME(_events.startUTC))), 'UTC', _events.derivedTimezone) AS computedEndLocal,
                _events.*,
                (CASE WHEN (_synthesized._syntheticDate != DATE(_events.startUTC)) IS TRUE THEN 1 ELSE 0 END) as isSynthetic
              FROM (
                SELECT DATE('{$startDate}' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) AS _syntheticDate
                FROM (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                CROSS JOIN (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                CROSS JOIN (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
                LIMIT {$queryDaySpan}
              ) AS _synthesized
              JOIN (
                SELECT
                  sev.id AS eventID,
                  sec.id AS calendarID,
                  sevt.id AS eventTimeID,
                  sev.title,
                  sev.useCalendarTimezone,
                  (CASE WHEN (sev.useCalendarTimezone = 1) IS TRUE THEN sec.defaultTimezone ELSE sev.timezoneName END) as derivedTimezone,
                  sev.eventColor,
                  sev.ownerID,
                  sev.fileID,
                  sevt.startUTC,
                  sevt.endUTC,
                  sevt.isOpenEnded,
                  sevt.isAllDay,
                  sevt.isRepeating,
                  sevt.repeatTypeHandle,
                  sevt.repeatEvery,
                  sevt.repeatIndefinite,
                  sevt.repeatEndUTC,
                  sevt.repeatMonthlyMethod,
                  sevt.repeatMonthlySpecificDay,
                  sevt.repeatMonthlyOrdinalWeek,
                  sevt.repeatMonthlyOrdinalWeekday,
                  sevtwd.repeatWeeklyday
                FROM SchedulizerCalendar sec
                  JOIN SchedulizerEvent sev ON sev.calendarID = sec.id
                  JOIN SchedulizerEventTime sevt ON sevt.eventID = sev.id
                  LEFT JOIN SchedulizerEventTimeWeekdays sevtwd ON sevtwd.eventTimeID = sevt.id
                WHERE ({$restrictor}) ORDER BY sevt.startUTC asc {$limitPerDay}
              ) AS _events
              WHERE(_events.isRepeating = 1
                AND (_events.repeatIndefinite = 1 OR (_synthesized._syntheticDate <= _events.repeatEndUTC AND _events.repeatIndefinite = 0))
                AND (DATE(_events.startUTC) <= _synthesized._syntheticDate)
                AND (_events.eventTimeID NOT IN (SELECT _nullifiers.eventTimeID FROM SchedulizerEventTimeNullify _nullifiers WHERE _synthesized._syntheticDate = DATE(_nullifiers.hideOnDate)))
                AND (
                  (_events.repeatTypeHandle = 'daily'
                    AND (DATEDIFF(_synthesized._syntheticDate,_events.startUTC) % _events.repeatEvery = 0 )
                  )

                  OR (_events.repeatTypeHandle = 'weekly'
                     AND (_events.repeatWeeklyday = DAYOFWEEK(_synthesized._syntheticDate))
                     AND (CEIL(DATEDIFF(_events.startUTC, _synthesized._syntheticDate) / 7 ) % _events.repeatEvery = 0)
                  )

                  OR ((_events.repeatTypeHandle = 'monthly' AND _events.repeatMonthlyMethod = 'specific')
                     AND (_events.repeatMonthlySpecificDay = DAYOFMONTH(_synthesized._syntheticDate))
                     AND ((MONTH(_synthesized._syntheticDate) - MONTH(_events.startUTC)) % _events.repeatEvery = 0)
                  )

                  OR ((_events.repeatTypeHandle = 'monthly' AND _events.repeatMonthlyMethod = 'ordinal')
                     AND ((DATE_ADD(DATE_SUB(LAST_DAY(_synthesized._syntheticDate), INTERVAL DAY(LAST_DAY(_synthesized._syntheticDate)) -1 DAY), INTERVAL (((_events.repeatMonthlyOrdinalWeekday + 7) - DAYOFWEEK(DATE_SUB(LAST_DAY(_synthesized._syntheticDate), INTERVAL DAY(LAST_DAY(_synthesized._syntheticDate)) -1 DAY))) % 7) + ((_events.repeatMonthlyOrdinalWeek * 7) -7) DAY)) = _synthesized._syntheticDate)
                     AND ((MONTH(_synthesized._syntheticDate) - MONTH(_events.startUTC)) % _events.repeatEvery = 0)
                  )

                  OR(_events.repeatTypeHandle = 'yearly'
                    AND ((YEAR(_synthesized._syntheticDate) - YEAR(_events.startUTC)) % _events.repeatEvery = 0)
                  )
                )
              )
              OR(
                (_events.isRepeating = 0 AND _synthesized._syntheticDate = DATE(_events.startUTC))
              )
            ) AS _eventList;";
        }

    }

}

