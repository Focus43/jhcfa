angular.module('artsy.common').

    controller('CtrlCalendarPage', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            $scope.filters = {
                fields:     ['calendarID'],
                keywords:   null,
                calendars:  "",
                tags:       "",
                categories: 1,
                filepath:   true,
                end:        moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization,date_display'
            };

            // Initialize with values...
            //scope.filters.calendars = document.querySelector('.calendar-list').children[0].value;
            //scope.filters.tags = document.querySelector('.tag-list').children[0].value;
            //angular.element(document.querySelector('[data-handle="Events"]')).trigger('click');

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
