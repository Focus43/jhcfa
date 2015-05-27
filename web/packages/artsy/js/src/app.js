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

            // @todo: fix interfering links

        }
    ]).

    /**
    * On run...
    */
    run(['FastClick',
        function( FastClick ){
            FastClick.attach(document.body);

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
        }
    ]);


    /************************************************************
    Bootstrap angular manually vs. binding w/ ng-app in the DOM
    ************************************************************/
    angular.element(document).ready(function(){
        angular.bootstrap(document.body, ['artsy']);
    });

})(window, window.angular);