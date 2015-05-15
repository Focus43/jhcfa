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
                category:   null,
                filepath:   true,
                end:        moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization'
            };

            $scope.fetch = function(){
                Schedulizer.fetch($scope.filters).success(function( resp ){
                    $scope.eventData = resp;
                }).error(function(){
                    console.log('err');
                });
            };

            $scope.fetch();

        }
    ]);
