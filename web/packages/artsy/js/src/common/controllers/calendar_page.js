angular.module('artsy.common').

    controller('CtrlCalendarPage', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            $scope.uiState = {
                fetchInProgress: false,
                showSearchExtras: false,
                showTagList: false,
                initialFetchComplete: false
            };

            $scope.filters = {
                fields:     ['calendarID'],
                keywords:   null,
                calendars:  "",
                tags:       "",
                categories: 1, //@todo:we just know this is going to be ID 1 right? easy to break...
                filepath:   true,
                start:      moment().startOf('month').format('YYYY-MM-DD'),
                end:        moment().endOf('month').format('YYYY-MM-DD'),//moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization,date_display,ticket_link,event_not_ticketed'
            };

            $scope.fetch = function(){
                $scope.uiState.fetchInProgress = true;
                Schedulizer.fetch($scope.filters).success(function( resp ){
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

            $scope.fetch();

            $scope.$watch('filters', function( val ){
                $scope.fetch();
            }, true);

            // Generate next 6 months list
            var currentMonth    = moment();
            currentMonth._selected = true;
            $scope.monthsToView = [currentMonth];
            for(var i = 1; i <= 5; i++){
                var next = currentMonth.clone().add(i, 'month');
                next._selected = false;
                $scope.monthsToView.push(next);
            }

            $scope.selectMonth = function( $index ){
                for(var i = 0, l = $scope.monthsToView.length; i < l; i++){
                    $scope.monthsToView[i]._selected = false;
                }
                $scope.monthsToView[$index]._selected = true;
                $scope.filters.start = $scope.monthsToView[$index].clone().startOf('month').format('YYYY-MM-DD');
                $scope.filters.end   = $scope.monthsToView[$index].clone().endOf('month').format('YYYY-MM-DD');
                $scope.fetch();
            };

            $scope.funcKeyup = function( $event ){
                $scope.uiState.showSearchExtras = ($event.target.value.length !== 0);
                $scope.uiState.fetchInProgress = true;
            };

            $scope.clearSearch = function(){
                $scope.uiState.showSearchExtras = false;
                $scope.filters.keywords = null;
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

        }
    ]);
