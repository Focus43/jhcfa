angular.module('artsy.common').

    controller('CtrlFeaturedEvents', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            Schedulizer.fetch({
                filepath:true,
                limit:10,
                end:moment().add(6, 'months').format("YYYY-MM-DD"),
                attributes: 'date_display'
            }).success(function( resp ){
                $scope.eventData = resp;
            });


        }
    ]);