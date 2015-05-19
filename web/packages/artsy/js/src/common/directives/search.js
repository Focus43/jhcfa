angular.module('artsy.common').

    directive('search', ['$http', '$compile', '$templateCache', function( $http, $compile, $templateCache ){

        function _link( scope, $elem, attrs ){
            scope.pageHits = [];
            scope.eventHits = [];

            scope.status = {
                open:  false,
                value: ''
            };

            var $tpl  = angular.element($templateCache.get('/search-form-tpl')),
                $cpld = $compile($tpl),
                $lnkd = $cpld(scope);
            angular.element(document.body).append($lnkd);

            $elem.on('click', function(){
                console.log('clicked');
                scope.status.open = !scope.status.open;
                scope.$digest();
            });

            scope.$watch('status.open', function(status){
                if( status ){
                    setTimeout(function(){
                        document.querySelector('[search-box] input').focus();
                    }, 150);
                }
            });

            scope.$watch('status.value', function( searchValue ){
                if( searchValue && scope.searchForm.$valid ){
                    $http.get(scope.searchPath, {
                        cache: false,
                        params: {_s: scope.status.value}
                    }).success(function( resp ){
                        scope.pageHits  = resp.pages;
                        scope.eventHits = resp.events;
                    });
                }
            });
        }

        return {
            scope: {
                searchPath: '@search'
            },
            restrict: 'A',
            link: _link
        };
    }]);