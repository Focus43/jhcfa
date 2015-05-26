/* global Elastic */
angular.module('artsy.common').

    directive('introAnim', ['$rootScope', 'Tween', function( $rootScope, Tween ){

        function _link( scope, $elem, attrs ){

            $rootScope.$broadcast('watchSpokes', true);

            Tween.fromTo($elem[0].querySelector('.tagline'), 1.8,
                {x:-800,scaleX:0,scaleY:0},
                {x:0,scaleX:1,scaleY:1, ease:Elastic.easeInOut, onComplete:function(){
                    $rootScope.$broadcast('watchSpokes', false);
                }, delay:0.5}
            );

        }

        return {
            link: _link,
            scope: false
        };
    }]);