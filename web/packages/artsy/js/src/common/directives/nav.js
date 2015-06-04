/* global Power1 */
angular.module('artsy.common').

    directive('nav', ['Tween', function( Tween ){

        function _link( scope, $elem, attrs ){

            var $html     = angular.element(document.documentElement),
                $majority = angular.element($elem[0].querySelector('.majority')),
                $currentLiSub;

            scope.status = {
                open: false
            };

            scope.toggle = function(){
                scope.status.open = !scope.status.open;

            };

            scope.$watch('status.open', function( _status ){
                angular.element(document.documentElement).toggleClass('nav-open', _status);
            });

            //angular.element($elem[0].querySelectorAll('.sub-trigger')).on('click', function(){
            //    $currentLiSub = angular.element(this.parentNode.parentNode);
            //    $currentLiSub.toggleClass('sub-active');
            //    $majority.toggleClass('show-subs');
            //});
            angular.element($elem[0].querySelectorAll('.sub-trigger')).on('click', function(){
                $currentLiSub = angular.element(this.parentNode);
                $currentLiSub.toggleClass('sub-active');
                $majority.toggleClass('show-subs');
            });

            angular.element($elem[0].querySelectorAll('.unsub')).on('click', function(){
                $currentLiSub.toggleClass('sub-active');
                $majority.toggleClass('show-subs');
            });

            var lastScroll = 0,
                threshold  = 50,
                isDocked   = false;
            Tween.ticker.addEventListener('tick', function(){
                if( lastScroll !== window.pageYOffset ){
                    lastScroll = window.pageYOffset;
                    if( (lastScroll > threshold) !== isDocked ){
                        isDocked = !isDocked;
                        $html.toggleClass('dock-nav-icon', isDocked);
                    }
                }
            });
        }

        return {
            restrict: 'E',
            link:     _link
        };
    }]);