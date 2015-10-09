angular.module('artsy.common').

    directive('emailListSignup', ['$compile', '$templateCache',
        function( $compile, $templateCache ){

            function _link( scope, $elem, attrs ){
                var $view;

                $elem.on('click', function(){
                    $view = $compile($templateCache.get('tpl/email-list-signup'))(scope, function( cloned ){
                        angular.element(document.body).append(cloned);
                    });
                });

                scope.close = function(){
                    $view.remove();
                };
            }

            return {
                restrict:   'A',
                link:       _link,
                scope:      {
                    emailListSignup: '@'
                },
                controller: ['$scope', '$http', function( $scope, $http ){
                    $scope.fields    = {};
                    $scope.working   = false;
                    $scope.confirmed = false;

                    $scope.doSignup = function(){
                        $scope.working = true;
                        $http.post($scope.emailListSignup, $scope.fields).success(function( resp ){
                            $scope.working   = false;
                            $scope.confirmed = resp.success;
                        });
                    };
                }]
            };
        }
    ]);