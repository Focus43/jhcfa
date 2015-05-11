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
angular.module('artsy.common', []);
angular.module('artsy.elements', []);
angular.module('artsy.common').

    directive('hubSpoke', ['d3', function( d3 ){

        function _link( scope, $elem, attrs ){

            var svgElement   = d3.select($elem[0]),
                canvasWidth  = $elem[0].clientWidth,
                canvasHeight = $elem[0].clientHeight,
                centerX      = canvasWidth / 2,
                centerY      = canvasHeight / 2;

            var circleRadius = 190;

            var group = svgElement.append('g').
                attr('class', 'tag-line').
                attr('transform','translate('+centerX+','+centerY+')');

            var circ = group.append('circle').
                    attr('cx', 0).
                    attr('cy', 0).
                    attr('r', circleRadius).
                    style('fill', 'rgba(208, 7, 121, 0.7)');

            var text = group.append('text').
                attr('transform', 'translate(-100,-90)');

            var elem = text.selectAll('tspan').data([
                {label:'we are a', dy:0},
                {label:'hub', dy:145, x:-7},
                {label:'for the artistic, cultural and', dy:40},
                {label:'creative activity in jackson hole', dy:35}
            ]);

            elem.enter().append('tspan').
                text(function(d){ return d.label; }).
                attr('fill', '#fff').
                attr('x', function( d ){
                    return d.x || 0;
                }).
                attr('dy', function( d ){
                    return d.dy || 0;
                });

            var link2 = svgElement.append('line').
                attr('x1', 200).
                attr('y1', 200).
                attr('x2', 500).
                attr('y2', 500).
                style("stroke-width", 2).
                style("stroke-linecap", "round").
                style("stroke-dasharray", "1,5").
                style("stroke", "#fff");

            //var link = svgElement.selectAll(".link")
            //    .data([1])
            //    .enter().append("line")
            //    .attr("class", "link")
            //    .style("stroke-width", 2)
            //    .style("stroke-linecap", "round")
            //    .style("stroke-dasharray", "1,5")
            //    .style("stroke", "#fff");

            // Edge connections
            var links = [
                {source:0, target:1}
            ];

            var force = d3.layout.force().
                size([canvasWidth, canvasHeight]).
                nodes([
                    {x:200, y:200},
                    {x:400, y:400}
                ]).
                links(links);
            force.linkDistance(200);

            var link = svgElement.selectAll('.link').
                data(links).
                enter().
                append('line').
                attr('class', '.link');

            force.on('end', function(){

            });

//            var element = $elem[0],
//                parentElm = angular.element(element).parent(),
//                divId = parentElm.attr("id"),
//                mainNode = element.querySelector("a"),
//                subNodes = element.querySelectorAll("li"),
//                width = parentElm[0].offsetWidth,
//                height = parentElm[0].offsetHeight,
//                clickEvent = attrs.clickEvent;
//
//            var subNodeRadius = 0,
//                rectWidth = 100,
//                rectHeight = 20,
//                graph = {
//                    nodes: [],
//                    links: []
//                };
//            // set up nodes
//            graph.nodes.push({
//                label: mainNode.text,
//                x: width*0.9,
//                y: height*0.12, // upper right corner.
//                group: 0,
//                size: 10,
//                color: '#6FB844',
//                fixed: true
//            });
//            angular.forEach(subNodes, function(elm, idx){
//                var pos = idx*100;
//                graph.nodes.push({
//                    label: elm.querySelector("a").text,
//                    group: 1,
//                    x: pos,
//                    y: pos,
//                    color: "#ffffff",
//                    clickEvent: elm.onclick
//                });
//                graph.links.push({
//                    source: 0,
//                    target: (idx+1)
//                });
//            });
//            // Add svg to DOM
//            angular.element(element).remove();
//            var svg = d3.select("#" + divId).append("svg")
//                .attr("preserveAspectRatio", "xMaxYMax meet")
//                .attr("viewBox", "0 0 " + width + " " + height);
//            // Add filter
////                angular.element(document.getElementById(divId)).find("svg")
////                    .append('<filter x="0" y="0" width="1" height="1" id="highlight"> <feFlood flood-color="#aaf"/> <feComposite in="SourceGraphic"/> </filter>');
//
//            var force = d3.layout.force()
//                //.theta(-20)
//                //.gravity(0.25)
//                .charge(-7999) //-1550
//                .linkDistance(450)
//                .size([width, height]);
//
//            force.nodes(graph.nodes).links(graph.links).start();
//
//            var link = svg.selectAll(".link")
//                .data(graph.links)
//                .enter().append("line")
//                .attr("class", "link")
//                .style("stroke-width", 2)
//                .style("stroke-linecap", "round")
//                .style("stroke-dasharray", "1,5")
//                .style("stroke", "#fff");
//
//            var node = svg.selectAll(".node")
//                .data(graph.nodes)
//                .enter().append("circle")
//                .attr("class", "node-circle")
//                .attr("r", function(d) { return (d.size) ? d.size+"px" : subNodeRadius + "px"; })
//                .style("fill", function(d) { return d.color; } )
//                //.attr("cx", function(d) { return d.x; })
//                //.attr("cy", function(d) { return d.y; });
//                .attr("cx", function(d) { return 0; })
//                .attr("cy", function(d) { return 0; });
//
//            // add tooltip to subnodes
//            var subNodes2 = graph.nodes.slice(1);
//            //var rect = svg.selectAll("rect")
//            //    .data(subNodes2)
//            //    .enter().append("rect")
//            //    .attr("x", function(d) { return d.x; })
//            //    .attr("y", function(d) { return d.y + subNodeRadius; })
//            //    .attr('width', rectWidth)
//            //    .attr('height', rectHeight)
//            //    .attr('stroke', '#6FB844')
//            //    .style('fill', '#6FB844');
//            //
//            var text = svg.selectAll("text")
//                .data(subNodes2)
//                .enter().append("text")
//                .attr("class", "node-label")
//                .attr("x", function(d) { return d.x; })
//                .attr("y", function(d) { return d.y + subNodeRadius; })
//                .text(function(d) { return d.label; })
//                .style('fill', 'white')
//                .style("text-anchor", "middle");
//
//            node.on("click", function() {
//                alert('clicked');
//                // replace w clickevent for the nodes or one passed as attribute
//                if (clickEvent) {
//                    clickEvent();
//                }
//            });
//
//            // make it all move!
//            force.on("tick", function() {
//                link.attr("x1", function(d) { return d.source.x; })
//                    .attr("y1", function(d) { return d.source.y; })
//                    .attr("x2", function(d) { return d.target.x; })
//                    .attr("y2", function(d) { return d.target.y; });
//
//                node.attr("cx", function(d) { return d.x; })
//                    .attr("cy", function(d) { return d.y; });
//
//                text.attr("x", function(d) { return d.x; })
//                    .attr("y", function(d) { return d.y + 20; });
//
//                //text.attr("x", function(d) { return d.x; })
//                //    .attr("y", function(d) { return d.y + subNodeRadius*2; });
//
//                //rect.attr("x", function(d) { return d.x - rectWidth/2; })
//                //    .attr("y", function(d) { return d.y + subNodeRadius + 3; });
//            });

        }

        return {
            restrict: 'A',
            scope: {
                //@ reads the attribute value, = provides two-way binding, & works with functions
                graph: '=',
                width: '@',
                height: '@'
            },
            link: _link
        };
    }]);
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
                lineY2 = centerY + (circleRadius + 90);

            draw.line(centerX, lineY1, centerX, lineY2).stroke({
                width: 2,
                linecap: 'round',
                dasharray: '1,5',
                color: '#fff'
            });

            // "click down" arrow hint
            draw.circle(50).attr({cx:centerX,cy:lineY2 + 29});
            draw.line(centerX, lineY2 + 37, centerX - 15, lineY2 + 21).stroke({
                width:2,
                color:'#fff'
            });
            draw.line(centerX, lineY2 + 37, centerX + 15, lineY2 + 21).stroke({
                width:2,
                color:'#fff'
            });

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
    //provider('Isotope', function(){
    //    this.$get = ['$window', '$log',
    //        function( $window, $log ){
    //            return $window['Isotope'] || ($log.warn('Isotope unavailable!'), false);
    //        }
    //    ];
    //}).

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

    ///**
    // * @description D3 provider
    // * @param $window
    // * @param $log
    // * @returns D3 | false
    // */
    //provider('d3', function(){
    //    this.$get = ['$window', '$log',
    //        function( $window, $log ){
    //            return $window['d3'] || ($log.warn('D3-JS unavailable!'), false);
    //        }
    //    ];
    //}).

    /**
     * @description svg.js provider
     * @param $window
     * @param $log
     * @returns D3 | false
     */
    provider('SVG', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['SVG'] || ($log.warn('SVG.js unavailable!'), false);
            }
        ];
    });