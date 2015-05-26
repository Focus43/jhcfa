/* global Power2 */
angular.module('artsy.common').

    directive('scrollTo', ['$window', '$rootScope', 'Tween',
        function( $window, $rootScope, Tween ){

            function _link( scope, $elem, attrs ){

                //$rootScope.$broadcast('watchSpokes', true);

                var target = document.querySelector(attrs.scrollTo);
                if( target ){
                    $elem.on('click', function( _ev ){
                        _ev.preventDefault();
                        Tween.to($window, 0.65, {
                            scrollTo: {y:target.offsetTop},
                            ease: Power2.easeOut
                        });
                        // If any siblings exist, remove active
                        angular.element($elem[0].parentNode.children).removeClass('active');
                        $elem.addClass('active');
                    });
                }

            }

            return {
                link: _link,
                scope: false
            };
        }
    ]);