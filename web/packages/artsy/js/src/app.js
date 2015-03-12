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

})(window, window.angular);