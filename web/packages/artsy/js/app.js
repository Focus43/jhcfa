/* global FastClick */
;(function( window, angular, undefined ){ 'use strict';

    angular.module('artsy', [
            'artsy.common',
            'artsy.elements'
        ]).

        /**
         * @description App configuration
         * @param $provide
         * @param $locationProvider
         */
        config(['$provide', '$locationProvider',
            function( $provide ){



            }
        ]).

        run(['FastClick', function( FastClick ){
            FastClick.attach(document.body);
        }]);

    // Initialize manually instead of binding via HTML
    angular.element(document).ready(function(){
        angular.bootstrap(document, ['artsy']);
    });

})(window, window.angular);
angular.module('artsy.elements', []);
angular.module('artsy.common', []);
angular.module('artsy.common').

    directive('nav', [function(){

        function _link( scope, $elem, attrs ){

            scope.toggle = function(){
                angular.element(document.body).toggleClass('nav-open');
            };

        }

        return {
            restrict: 'E',
            link:     _link
        };
    }]);
/* global Modernizr */
/* global FastClick */
angular.module('artsy.common').

    /**
     * @description Modernizr provider
     * @param $window
     * @param $log
     * @returns Modernizr | false
     */
    provider('Modernizr', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['Modernizr'] || ($log.warn('Modernizr unavailable!'), false);
            }
        ];
    }).

    /**
     * @description TweenLite OR TweenMax provider
     * @param $window
     * @param $log
     * @returns TweenMax | TweenLite | false
     */
    provider('Tween', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['TweenMax'] || $window['TweenLite'] || ($log.warn('Tween library unavailable!'), false);
            }
        ];
    }).

    /**
     * @description Isotope provider
     * @param $window
     * @param $log
     * @returns Isotope | false
     */
    provider('Isotope', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['Isotope'] || ($log.warn('Isotope unavailable!'), false);
            }
        ];
    }).

    /**
     * @description FastClick provider
     * @param $window
     * @param $log
     * @returns FastClick | false
     */
    provider('FastClick', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['FastClick'] || ($log.warn('FastClick unavailable!'), false);
            }
        ];
    });