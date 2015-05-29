/* global FastClick */
;(function( window, angular, undefined ){ 'use strict';

    angular.module('artsy', ['artsy.common', 'ngSanitize']).

    /**
    * @description App configuration
    * @param $provide
    * @param $locationProvider
    */
    config(['$provide', '$locationProvider',
        function( $provide, $locationProvider ){

        }
    ]).

    /**
    * On run...
    */
    run(['$rootScope', '$window', '$timeout', '$q', 'FastClick', 'BrowserDetect', '$compile',
        function( $rootScope, $window, $timeout, $q, FastClick, BrowserDetect, $compile ){
            // Bind fastclick
            FastClick.attach(document.body);

            // Set the browser as an attribute on the html tag
            document.documentElement.setAttribute('data-ua', BrowserDetect.browser);

            // This sucks... but we cant do it any other way for now
            var themeWraps = document.querySelectorAll('[class*="wrap-theme-"]');
            if( themeWraps.length ){
                for(var i = 0, len = themeWraps.length; i < len; i++){
                    var $element = angular.element(themeWraps[i]);
                    while( ! $element.hasClass('container') && $element.length ){
                        console.log('locating_parent_container');
                        $element = angular.element($element.parent());
                    }
                    if( $element.length ){
                        $element.addClass('overflowable-x');
                    }
                }
            }

            // C5 edit mode ONLY
            if( angular.element(document.documentElement).hasClass('cms-edit-mode') ){
                // Wait for ConcreteEvent to be available in the window...
                $q(function(resolve, reject){
                    (function _wait(){
                        $timeout(function(){
                            if( $window['ConcreteEvent'] ){
                                resolve($window['ConcreteEvent']);
                                return;
                            }
                            _wait();
                        }, 200);
                    })();
                }).then(function( ConcreteEvent ){
                    /**
                     * @todo: Find a better way to evaluate lazy-loaded directives after a
                     * block gets updated vs recompiling the entire document... That seems
                     * dangerous...
                     */
                    ConcreteEvent.subscribe('EditModeAddBlockComplete EditModeUpdateBlockComplete EditModeExitInlineSaved EditModeExitInline', function(){
                        $timeout(function(){
                            console.log("Recompiling DOM");
                            $compile(document.body)($rootScope);
                        }, 2000);
                    });
                });
            }
        }
    ]);


    /************************************************************
    Bootstrap angular manually vs. binding w/ ng-app in the DOM
    ************************************************************/
    angular.element(document).ready(function(){
        angular.bootstrap(document.body, ['artsy']);
    });

})(window, window.angular);
