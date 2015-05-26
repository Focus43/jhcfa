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
                    var containerEl = themeWraps[i];
                    while( ! containerEl.classList.contains('container') ){
                        containerEl = containerEl.parentNode;
                    }
                    if( containerEl ){
                        containerEl.classList.add('overflowable-x');
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

            angular.element($elem[0].querySelectorAll('.sub-trigger')).on('click', function(){
                $currentLiSub = angular.element(this.parentNode.parentNode);
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
angular.module('artsy.common').

    directive('searchable', ['$http', '$compile', '$templateCache',
        function( $http, $compile, $templateCache ){

            function _link( $scope, $elem, attrs ){
                var $html = angular.element(document.documentElement);

                // Compile HTML within this directive
                $compile($elem.contents())($scope);

                // Compile the results template
                var $tpl  = angular.element($templateCache.get('/search-form-tpl')),
                    $cpld = $compile($tpl),
                    $lnkd = $cpld($scope);
                angular.element(document.body).append($lnkd);

                // If status is open, set on the HTML/document element
                $scope.$watch('status.open', function( isOpen, lastIsOpen ){
                    if( isOpen !== lastIsOpen ){
                        $html.toggleClass('search-results-open', isOpen);
                    }
                });
            }

            return {
                scope: {
                    searchPath: '@searchable'
                },
                restrict: 'A',
                link: _link,
                controller: ['$scope', function( $scope ){
                    $scope.pageHits = [];

                    $scope.status = {
                        open:  false,
                        value: '',
                        displayValue: '',
                        loading: true
                    };

                    $scope.$watch('status.displayValue', function( searchValue ){
                        $scope.status.open = (searchValue && searchValue.length >= 1);
                    });

                    $scope.clear = function(){
                        $scope.status.value = '';
                        $scope.status.displayValue = '';
                    };

                    $scope.funcKeyup = function($event){
                        $scope.status.displayValue = $event.target.value;
                        $scope.status.loading = true;
                    };

                    $scope.$watch('status.value', function( searchValue ){
                        if( searchValue && $scope.searchForm.$valid ){
                            $http.get($scope.searchPath, {
                                cache: false,
                                params: {_s: $scope.status.value}
                            }).success(function( resp ){
                                $scope.pageHits = resp.pages;
                                $scope.status.loading = false;
                            });
                        }
                    });
                }]
            };
        }
    ]);
angular.module('artsy.common').

    directive('spokeTo', ['$window', '$rootScope', 'SVG', 'Tween', function( $window, $rootScope, SVG, Tween ){

        var body                    = document.body,
            html                    = document.documentElement,
            docWidth                = document.body.getBoundingClientRect().width,
            docHeight               = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight),
            svgCanvas               = SVG(document.body),
            redraw                  = false,
            overrideRedraw          = false,
            linkedNodes             = [],
            defaultSpokeOffset      = 5,
            defaultSpokeWidth       = 4,
            defaultSpokeDistance    = 10;

        // Create the SVG canvas ONCe
        svgCanvas.size(docWidth,docHeight).attr('class', 'spoke-canvas');

        /**
         * Whenever an update occurs, adjust the line settings...
         * @param nodePair
         */
        function render( nodeData ){
            // Calculate the midpoints and angles b/w nodes as radians
            var rectA           = nodeData.nodes[0].getBoundingClientRect(),
                rectB           = nodeData.nodes[1].getBoundingClientRect(),
                radiusA         = rectA.width / 2,
                radiusB         = rectB.width / 2,
                xMidA           = rectA.left + radiusA,
                yMidA           = rectA.top + radiusA,
                xMidB           = rectB.left + radiusB,
                yMidB           = rectB.top + radiusB,
                thetaA          = Math.atan2((yMidB - yMidA),(xMidB - xMidA)),
                thetaB          = Math.atan2((yMidA - yMidB),(xMidA - xMidB)),
                spokeOffset    = +(nodeData.attrs.spokeOffset) || defaultSpokeOffset,
                calcdRadiusA    = radiusA + spokeOffset,
                calcdRadiusB    = radiusB + spokeOffset,
                existingLine    = nodeData.spoke;

            // Calculate the points moved to the outside of the circle
            var ax = xMidA + calcdRadiusA * Math.cos(thetaA),
                ay = yMidA + calcdRadiusA * Math.sin(thetaA),
                bx = xMidB + calcdRadiusB * Math.cos(thetaB),
                by = yMidB + calcdRadiusB * Math.sin(thetaB);

            // If line has already been rendered, just needs updating
            if( existingLine ){
                existingLine.plot(ax,ay,bx,by);
                return;
            }

            // If we get here, its rendering for the first time, so all we do is
            // generate the line and store the reference to it with the nodeData
            nodeData.spoke = svgCanvas.line(ax,ay,ax,ay).stroke({
                width: +(nodeData.attrs.spokeWidth) || defaultSpokeWidth,
                linecap: 'round',
                dasharray: '0.1,' + (nodeData.attrs.spokeDistance || defaultSpokeDistance),
                color:'#ffffff'
            });

            nodeData.spoke.
                animate(400).
                during(function( t, morph ){
                    this.attr({y2: morph(ay,by), x2: morph(ax,bx)});
                }).
                after(function(){
                    redraw = true;
                });
        }

        /**
         * Animation frame binding, but only gets run whenever an onscroll
         * or window resize event happens.
         */
        Tween.ticker.addEventListener('tick', function(){
            if( redraw || overrideRedraw ){
                for(var i = 0, len = linkedNodes.length; i < len; i++){
                    render.call(this, linkedNodes[i]);
                }
                console.log('redrawn');
                redraw = false;
            }
        });

        /**
         * Scroll event.
         */
        angular.element($window).bind('scroll', function(){
            redraw = true;
        });

        /**
         * Window was resized.
         */
        angular.element($window).bind('resize', function(){
            docWidth    = document.body.getBoundingClientRect().width;
            docHeight   = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
            svgCanvas.size(docWidth,docHeight);
            redraw = true;
        });

        /**
         * Listen for overrides broadcast by other elements that might use animation
         * that would require updating the spokes.
         */
        $rootScope.$on('watchSpokes', function( event, override ){
            overrideRedraw = override;
        });

        /**
         * Link function just takes care of adding to the nodePairs we're tracking.
         * @example: <svg spoke-to=".another-svg" spoke-offset="20" spoke-width="10" spoke-distance="20"><circle></circle></svg>
         * @param scope
         * @param $elem
         * @param attrs
         * @private
         */
        function _link( scope, $elem, attrs ){
            linkedNodes.push({
                nodes: [
                    $elem[0].querySelector('circle'),
                    document.querySelector(attrs.spokeTo).querySelector('circle')
                ],
                attrs: attrs
            });

            redraw = true;
        }

        return {
            link: _link,
            scope: false
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
                categories: null,
                filepath:   true,
                end:        moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization,date_display'
            };

            $scope.fetch = function(){
                Schedulizer.fetch($scope.filters).success(function( resp ){
                    $scope.eventData = resp;
                }).error(function(){
                    console.log('err');
                });
            };

            $scope.setCategory = function( int ){
                $scope.filters.categories = int;
            };

            $scope.fetch();

        }
    ]);

angular.module('artsy.common').

    controller('CtrlFeaturedEvents', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            Schedulizer.fetch({
                filepath:true,
                limit:10,
                end:moment().add(6, 'months').format("YYYY-MM-DD"),
                attributes: 'date_display'
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
            // Have to extend an empty object so we don't rewrite the original
            // _filters.fields property to a string!
            var filtersCopy = angular.extend({}, _filters, {
                fields: mergeFields(_filters.fields || [], defaultParams.fields)
            });
            return $http.get(eventRoute, {
                cache:  (_cache === false) ? false : true,
                params: angular.extend({}, defaultParams, filtersCopy)
            });
        };

    }]);