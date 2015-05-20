angular.module('artsy.common').

    directive('searchable', ['$http', '$compile', '$templateCache',
        function( $http, $compile, $templateCache ){

            function _link( $scope, $elem, attrs ){
                var $html = angular.element(document.documentElement);

                // Compile HTML within this directive
                $compile($elem.contents())($scope);

                // Compile the results template
                var $tpl  = angular.element($templateCache.get('/search-form-tpl')),
                    $cpld = $compile($tpl),
                    $lnkd = $cpld($scope);
                angular.element(document.body).append($lnkd);

                // If status is open, set on the HTML/document element
                $scope.$watch('status.open', function( isOpen, lastIsOpen ){
                    if( isOpen !== lastIsOpen ){
                        $html.toggleClass('search-results-open', isOpen);
                    }
                });
            }

            return {
                scope: {
                    searchPath: '@searchable'
                },
                restrict: 'A',
                link: _link,
                controller: ['$scope', function( $scope ){
                    $scope.pageHits = [];

                    $scope.status = {
                        open:  false,
                        value: '',
                        displayValue: '',
                        loading: true
                    };

                    $scope.$watch('status.displayValue', function( searchValue ){
                        $scope.status.open = (searchValue && searchValue.length >= 1);
                    });

                    $scope.clear = function(){
                        $scope.status.value = '';
                        $scope.status.displayValue = '';
                    };

                    $scope.funcKeyup = function($event){
                        $scope.status.displayValue = $event.target.value;
                        $scope.status.loading = true;
                    };

                    $scope.$watch('status.value', function( searchValue ){
                        if( searchValue && $scope.searchForm.$valid ){
                            $http.get($scope.searchPath, {
                                cache: false,
                                params: {_s: $scope.status.value}
                            }).success(function( resp ){
                                $scope.pageHits = resp.pages;
                                $scope.status.loading = false;
                            });
                        }
                    });
                }]
            };
        }
    ]);