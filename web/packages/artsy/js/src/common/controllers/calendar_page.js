angular.module('artsy.common').

    controller('CtrlCalendarPage', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            // Initialize with values...
            //scope.filters.calendars = $elem[0].querySelector('.calendar-list').children[0].value;
            //scope.filters.tags = $elem[0].querySelector('.tag-list').children[0].value;

            $scope.eventData = [];

            $scope.filters = {
                fields:     ['calendarID'],
                keywords:   null,
                calendars:  null,
                tags:       null,
                categories: null,
                filepath:   true,
                end:        moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization,date_display'
            };

            $scope.fetch = function(){
                Schedulizer.fetch($scope.filters).success(function( resp ){
                    $scope.eventData = resp;
                }).error(function(){
                    console.log('err');
                });
            };

            $scope.setCategory = function( int ){
                $scope.filters.categories = int;
            };

            $scope.fetch();

        }
    ]);
