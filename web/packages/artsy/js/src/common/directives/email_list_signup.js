angular.module('artsy.common').

    directive('emailListSignup', ['$compile','$templateCache',
        function( $compile, $templateCache, $cookies ){

            function _link( scope, $elem, attrs, $cookies ){
                var $view;
                //check for our cookie that is set when modal is closed
                var checker;
                if(document.cookie.indexOf("closedSignup") >= 0){
                    checker = false;
                } else {
                    checker = true
                }
                console.log(checker)
                if(checker){
                    window.setTimeout(function() {
              
                        $view = $compile($templateCache.get('tpl/email-list-signup'))(scope, function( cloned ){
                            angular.element(document.body).append(cloned);
                        });
                    },2000);
               }
                $elem.on('click', function(){
                    $view = $compile($templateCache.get('tpl/email-list-signup'))(scope, function( cloned ){
                        angular.element(document.body).append(cloned);
                    });
                });

                scope.close = function(){
                    document.cookie = "closedSignup=true";
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