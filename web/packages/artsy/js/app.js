/* global FastClick */
;(function( window, angular, undefined ){ 'use strict';

    angular.module('artsy', ['artsy.common', 'ngSanitize']).

    /**
     * @description App configuration
     * @param $provide
     * @param $locationProvider
     */
    config(['$provide', '$locationProvider',
        function( $provide ){

            // @todo: disable html5 navigation

        }
    ]).

    /**
     * On run...
     */
    run(['FastClick', function( FastClick ){
        FastClick.attach(document.body);
    }]);


    /************************************************************
    Bootstrap angular manually vs. binding w/ ng-app in the DOM
    ************************************************************/
    angular.element(document).ready(function(){
        angular.bootstrap(document, ['artsy']);
    });

})(window, window.angular);
angular.module('artsy.common', []);
angular.module('artsy.common').

    directive('accordion', [
        function(){

            function _link( scope, $elem, attrs ){
                var $groups = angular.element($elem[0].querySelectorAll('.group'));
                $groups.on('click', function(){
                    angular.element(this).toggleClass('active');
                });
            }

            return {
                restrict: 'A',
                link:     _link
            };
        }
    ]);
angular.module('artsy.common').

    /**
     * Event rendering directive. This should be used inside a parent Controller or something
     * that can control the scope and pass event list data.
     * @usage: <div event-list="listData" />, whereas the parent controller can
     * set the listData on the scope.
     */
    directive('eventList', ['moment', function( moment ){

        function _link( scope, $elem, attrs, Controller, transcludeFn ){

            var transcludedNodes    = [],
                transcludedScopes   = [];

            scope.$watch('_data', function( list ){
                if( list ){
                    // @todo: do a check in here to see if we're appending but keeping the existing
                    // results, or replacing the existing ones, and cleanup old nodes/scopes if
                    // need be (https://docs.angularjs.org/api/ng/service/$compile see section on cleanup)
                    var _node; while(_node = transcludedNodes.pop()){
                        _node.remove();
                    }

                    var _scope; while(_scope = transcludedScopes.pop()){
                        _scope.$destroy();
                    }

                    list.forEach(function( eventObj ){
                        var $newScope = scope.$new();
                        $newScope.eventObj = eventObj;
                        $newScope.moment   = moment(eventObj.computedStartLocal);
                        transcludeFn($newScope, function( $cloned, $scope ){
                            $elem.append($cloned);
                            transcludedNodes.push($cloned);
                            transcludedScopes.push($scope);
                        });
                    });
                }
            }, true);

        }

        return {
            link:       _link,
            transclude: true,
            scope:      {_data: '=eventList'},
            controller: [function(){}]
        };
    }]);

angular.module("artsy.common").

    directive('masonry', ['Masonry', 'imagesLoaded',
        function( Masonry, imagesLoaded ){

            function _link(scope, $elem, attrs){
                var element = $elem[0];

                scope.masonry = new Masonry(element, {
                    //columnWidth:  '.grid-sizer',
                    itemSelector: '[node]',
                    percentPosition: true
                });

                //var element     = $elem[0],
                //    //filters     = element.querySelectorAll('[isotope-filters] a[data-filter]'),
                //    container   = element.querySelector('[isotope-grid]'),
                //    gridNodes   = element.querySelectorAll('.isotope-node');
                //
                //
                //// Initialize Isotope instance
                //imagesLoaded(container, function(){
                //    scope.isotopeInstance = new Isotope(container, {
                //        itemSelector: '.isotope-node',
                //        layoutMode: attrs.isotope || 'masonry',
                //        cellsByColumn: {
                //            columnWidth: '.grid-sizer',
                //            columnHeight: '.grid-sizer'
                //        }
                //    });
                //});
                //
                //// Filters
                ////angular.element(filters).on('click', function(){
                ////    angular.element(filters).removeClass('active');
                ////    angular.element(this).addClass('active');
                ////    var _filter = this.getAttribute('data-filter');
                ////    scope.isotopeInstance.arrange({
                ////        filter: _filter
                ////    });
                ////});
                //
                //// Click to activate
                //angular.element(gridNodes).on('click', function(){
                //    angular.element(gridNodes).removeClass('active');
                //    angular.element(this).addClass('active');
                //});
            }

            return {
                restrict:   'A',
                scope:      true,
                link:       _link
            };
        }
    ]);
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
angular.module('artsy.common').

    directive('svgize', ['SVG', function( SVG ){

        function _link( scope, $elem, attrs ){

            var draw            = SVG($elem[0]),
                canvasWidth     = $elem[0].clientWidth,
                canvasHeight    = $elem[0].clientHeight,
                centerX         = canvasWidth / 2,
                centerY         = canvasHeight / 2,
                circleDiameter  = 400,
                circleRadius    = circleDiameter / 2,
                logoScale       = 0.7;

            var logoGroup = draw.group();
            logoGroup.svg(document.querySelector('svg[logo]').innerHTML);
            logoGroup.transform({scaleX:logoScale,scaleY:logoScale});
            var logoGroupBBox = logoGroup.bbox(),
                logoGroupX    = (canvasWidth - logoGroupBBox.width) - 15,
                logoGroupY    = 15;
            logoGroup.transform({x:logoGroupX, y:logoGroupY});
            logoGroup.attr('logo', 'lorem');

            var tagLineGroup  = draw.group().attr({'class':'tag-line'}),
                tagLineCircle = tagLineGroup.circle(circleDiameter),
                tagLineText   = tagLineGroup.text(function(add){
                    add.tspan('we are a').fill('#fff').attr({dy:0,x:0});
                    add.tspan('hub').fill('#fff').attr({dy:130,x:-7});
                    add.tspan('for the artistic, cultural and').fill('#fff').attr({dy:40,x:0});
                    add.tspan('creative activity in jackson hole').fill('#fff').attr({dy:35,x:0});
                }).attr({'font-family':'inherit'});

            tagLineGroup.transform({x:centerX, y:centerY});
            tagLineText.transform({x:-120,y:-90});
            tagLineCircle.attr({cx:0, cy:0}).fill('rgba(208,7,121,0.7)');

            var logoEllipse     = logoGroup.node.querySelector('ellipse'),
                logoEllipseBBox = logoEllipse.getBBox(),
                logoCircleX     = logoGroupX + ((logoEllipseBBox.width * logoScale) / 2),
                logoCircleY     = logoGroupY + (logoEllipseBBox.height * logoScale) / 2,
                angle           = Math.atan2(centerY - logoCircleY, centerX - logoCircleX),// * 180 / Math.PI,
                circX           = centerX - ((circleDiameter + 4) / 2) * Math.cos(angle),
                circY           = centerY - ((circleDiameter + 4) / 2) * Math.sin(angle);

            draw.line(logoCircleX,logoCircleY,circX,circY).stroke({
                width: 2,
                linecap: 'round',
                dasharray: '1,5',
                color: '#fff'
            }).attr('class', 'spoke-line').back();

            var lineY1 = centerY + (circleRadius + 4),
                lineY2 = centerY + (circleRadius + 290);

            draw.line(centerX, lineY1, centerX, lineY2).stroke({
                width: 2,
                linecap: 'round',
                dasharray: '1,5',
                color: '#fff'
            }).attr('class', 'down-line');

            // "click down" arrow hint
            //draw.circle(50).attr({cx:centerX,cy:lineY2 + 29});
            //draw.line(centerX, lineY2 + 37, centerX - 15, lineY2 + 21).stroke({
            //    width:2,
            //    color:'#fff'
            //});
            //draw.line(centerX, lineY2 + 37, centerX + 15, lineY2 + 21).stroke({
            //    width:2,
            //    color:'#fff'
            //});

            // scroll navs
            var scrollNavGroup = draw.group().attr('class', 'scroll-navs');
            scrollNavGroup.circle(20).attr('class', 'active').fill('rgba(255,255,255,0.25)');
            scrollNavGroup.circle(20).attr({cy:50}).fill('rgba(255,255,255,0.25)');
            scrollNavGroup.circle(20).attr({cy:90}).fill('rgba(255,255,255,0.25)');
            scrollNavGroup.transform({
                x: canvasWidth - 40,
                y: centerY - (scrollNavGroup.bbox().height / 2)
            });
        }

        return {
            link: _link
        };
    }]);
angular.module('artsy.common').

    controller('CtrlCalendarPage', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            // Initialize with values...
            //scope.filters.calendars = $elem[0].querySelector('.calendar-list').children[0].value;
            //scope.filters.tags = $elem[0].querySelector('.tag-list').children[0].value;

            $scope.eventData = [];

            $scope.filters = {
                fields:     ['calendarID'],
                keywords:   null,
                calendars:  null,
                tags:       null,
                category:   null,
                filepath:   true,
                end:        moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization'
            };

            $scope.fetch = function(){
                Schedulizer.fetch($scope.filters).success(function( resp ){
                    $scope.eventData = resp;
                }).error(function(){
                    console.log('err');
                });
            };

            $scope.fetch();

        }
    ]);

angular.module('artsy.common').

    controller('CtrlFeaturedEvents', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer ){

            $scope.eventData = [];

            Schedulizer.fetch({
                filepath:true,
                limit:5
            }).success(function( resp ){
                $scope.eventData = resp;
            });


        }
    ]);
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
                return $window['TweenMax'] || $window['TweenLite'] || ($log.warn('Greensock Tween library unavailable!'), false);
            }
        ];
    }).

    /**
     * @description MomentJS
     * @param $window
     * @param $log
     * @returns moment | TweenLite | false
     */
    provider('moment', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['moment'] || ($log.warn('MomentJS library unavailable!'), false);
            }
        ];
    }).

    /**
     * @description Masonry provider
     * @param $window
     * @param $log
     * @returns Masonry | false
     */
    provider('Masonry', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['Masonry'] || ($log.warn('Masonry unavailable!'), false);
            }
        ];
    }).

    /**
     * @description imagesLoaded provider
     * @param $window
     * @param $log
     * @returns imagesLoaded | false
     */
    provider('imagesLoaded', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['imagesLoaded'] || ($log.warn('imagesLoaded unavailable!'), false);
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
    }).

    /**
     * @description svg.js provider
     * @param $window
     * @param $log
     * @returns SVG | false
     */
    provider('SVG', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['SVG'] || ($log.warn('SVG.js unavailable!'), false);
            }
        ];
    });
angular.module('artsy.common').

    service('Schedulizer', ['$http', function( $http ){

        var eventRoute      = '/_schedulizer/event_list',
            defaultParams   = {
                fields:     ['computedStartLocal', 'computedStartUTC', 'title'],
                pagepath:   true,
                grouping:   true
            };

        /**
         * Joins the alwaysFields with custom fields and ensures no duplication.
         * @param _fields
         * @returns {*}
         * @private
         */
        function mergeFields( a, b ){
            var joined = a.concat(b);
            return joined.filter(function( item, pos ){
                return joined.indexOf(item) === pos;
            });
        }

        /**
         * @param fields array
         * @param filters object
         * @param cache bool
         */
        this.fetch = function( _filters, _cache ){
            // Merge array fields passed in filters w/ defaults, then join as a string "a,b,c"
            _filters['fields'] = mergeFields(_filters.fields || [], defaultParams.fields).join(',');
            // Issue request and return promise
            return $http.get(eventRoute, {
                cache:  (_cache === false) ? false : true,
                params: angular.extend(defaultParams, _filters)
            });
        };

    }]);