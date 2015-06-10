angular.module('artsy.common').

    controller('CtrlFeaturedEvents', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            /**
             * Need to use a watch to make sure ng-init completes and
             * only send request once we have a valid value for featuredTagID
             */
            $scope.$watch('featuredTagID', function( featuredTagID ){
                if( featuredTagID ){
                    Schedulizer.fetch({
                        fields: ['tags'],
                        filepath:true,
                        limit:10,
                        start:moment().format('YYYY-MM-DD'),
                        end:moment().add(6, 'months').format("YYYY-MM-DD"),
                        attributes: 'date_display',
                        tags: featuredTagID // passed via ng-init
                    }).success(function( resp ){
                        $scope.eventData = resp;
                    });
                }
            });

        }
    ]);