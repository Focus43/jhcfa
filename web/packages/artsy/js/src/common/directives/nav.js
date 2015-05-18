angular.module('artsy.common').

    directive('nav', [function(){

        function _link( scope, $elem, attrs ){

            scope.toggle = function(){
                angular.element(document.documentElement).toggleClass('nav-open');
            };

        }

        return {
            restrict: 'E',
            link:     _link
        };
    }]);