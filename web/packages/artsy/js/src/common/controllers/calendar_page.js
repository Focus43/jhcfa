angular.module('artsy.common').

    controller('CtrlCalendarPage', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            $scope.uiState = {
                fetchInProgress: false,
                showSearchExtras: false,
                showTagList: false,
                initialFetchComplete: false,
                clearAllViz: false
            };

            $scope.overrideDateRange = {
                start: moment().startOf('month'),//.format('YYYY-MM-DD'),
                end: moment().add(5, 'months').endOf('month')//.format('YYYY-MM-DD')
            };

            $scope.isTextSearch = false;

            $scope.filters = {
                //collection_id:  1, //@todo: make dynamic!
                master_collection: true,
                fields:         ['calendarID'],
                keywords:       null,
                calendars:      "",
                tags:           "",
                categories:     1, //@todo: we just know this is going to be ID 1 (meaning, the categoryID) right? easy to break...
                filepath:       true,
                start:          moment().startOf('month').format('YYYY-MM-DD'),
                end:            moment().endOf('month').format('YYYY-MM-DD'),//moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes:     'presenting_organization,date_display,ticket_link,event_not_ticketed'
            };

            $scope.fetch = function(){
                $scope.uiState.fetchInProgress = true;

                var data = ($scope.isTextSearch === false) ? $scope.filters : angular.extend({}, $scope.filters, {
                    start: $scope.overrideDateRange.start.format('YYYY-MM-DD'),
                    end: $scope.overrideDateRange.end.format('YYYY-MM-DD')
                });

                Schedulizer.fetch(data).success(function( resp ){
                    $scope.eventData = resp;
                    $scope.uiState.fetchInProgress = false;
                    $scope.uiState.initialFetchComplete = true;
                }).error(function(){
                    console.log('err');
                });
            };

            $scope.setCategory = function( int ){
                $scope.filters.categories = int;
            };

            // On page load, since $watch automatically applies itself once filters object becomes available,
            // this will initialize the first load
            $scope.$watch('filters', function( filters ){
                $scope.isTextSearch = angular.isString(filters.keywords) && filters.keywords.length;
                if( filters ){
                    $scope.fetch();

                    if( $scope.filters.keywords !== null || $scope.filters.calendars !== '' || $scope.filters.tags !== '' ){
                        $scope.uiState.clearAllViz = true;
                    }
                }
            }, true);

            // Generate next 6 months list
            var monthListStart = moment();

            // User can view previous or future months other
            // than the default 5; this takes care of generating
            function generateMonthList(){
                monthListStart._selected = true;
                $scope.monthsToView = [monthListStart];
                for(var i = 1; i < 4; i++){
                    var next = monthListStart.clone().add(i, 'month');
                    next._selected = false;
                    $scope.monthsToView.push(next);
                }
            }

            // Populate month list right away
            generateMonthList();

            // Scroll month list back or forward
            $scope.scrollMonth = function( _dir ){
                if( _dir === 'prev' ){
                    monthListStart.subtract(1, 'month');
                }else{
                    monthListStart.add(1, 'month');
                }
                $scope.$applyAsync(function(){
                    generateMonthList();
                    $scope.selectMonth($scope.selectedMonthIndex || 0);
                });
            };

            $scope.selectedMonthIndex = 0;
            $scope.selectMonth = function( $index ){
                for(var i = 0, l = $scope.monthsToView.length; i < l; i++){
                    $scope.monthsToView[i]._selected = false;
                }
                $scope.monthsToView[$index]._selected   = true;
                $scope.selectedMonthIndex               = $index;
                $scope.filters.start                    = $scope.monthsToView[$index].clone().startOf('month').format('YYYY-MM-DD');
                $scope.filters.end                      = $scope.monthsToView[$index].clone().endOf('month').format('YYYY-MM-DD');
            };

            $scope.funcKeyup = function( $event ){
                $scope.uiState.showSearchExtras = ($event.target.value.length !== 0);
                $scope.uiState.fetchInProgress = true;
            };

            $scope.clearSearch = function(){
                $scope.uiState.showSearchExtras = false;
                $scope.filters.keywords = null;
            };

            $scope.clearAll = function(){
                $scope.uiState.clearAllViz = false;
                $scope.uiState.showSearchExtras = false;
                $scope.filters.keywords = null;
                $scope.filters.tags = "";
                $scope.filters.calendars = "";
                $scope.filters.categories = 1;
            };

            $scope.selectedTags = [];
            $scope.toggleTag = function( tagID ){
                // Exists; so splice it off
                if( $scope.selectedTags.indexOf(tagID) !== -1 ){
                    $scope.selectedTags.splice($scope.selectedTags.indexOf(tagID), 1);
                    $scope.filters.tags = $scope.selectedTags.join(',');
                    return;
                }
                // Doesn't exist, append it
                $scope.selectedTags.push(tagID);
                $scope.filters.tags = $scope.selectedTags.join(',');
            };

            $scope.nextMonth = function(){
                var nextIndex = $scope.selectedMonthIndex + 1;
                if( $scope.monthsToView[nextIndex] ){
                    $scope.selectMonth(nextIndex);
                }
            };

            $scope.prevMonth = function(){
                var prevIndex = $scope.selectedMonthIndex - 1;
                if( $scope.monthsToView[prevIndex] ){
                    $scope.selectMonth(prevIndex);
                }
            };

        }
    ]);
