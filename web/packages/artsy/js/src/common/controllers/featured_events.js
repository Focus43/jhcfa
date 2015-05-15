angular.module('artsy.common').

    controller('CtrlFeaturedEvents', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer ){

            $scope.eventData = [];

            Schedulizer.fetch({
                filepath:true,
                limit:5
            }).success(function( resp ){
                $scope.eventData = resp;
            });


        }
    ]);