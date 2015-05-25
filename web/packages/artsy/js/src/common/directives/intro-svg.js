angular.module('artsy.common').

    directive('introSvg', ['SVG', function( SVG ){

        function _link( scope, $elem, attrs ){

            //var draw            = SVG($elem[0]),
            //    canvasWidth     = $elem[0].clientWidth,
            //    canvasHeight    = $elem[0].clientHeight,
            //    centerX         = canvasWidth / 2,
            //    centerY         = canvasHeight / 2,
            //    circleDiameter  = 400,
            //    circleRadius    = circleDiameter / 2,
            //    logoScale       = 0.7;
            //
            //var logoGroup = draw.group();
            //logoGroup.svg(document.querySelector('svg.svg-logo').innerHTML);
            //logoGroup.transform({scaleX:logoScale,scaleY:logoScale});
            //var logoGroupBBox = logoGroup.bbox(),
            //    logoGroupX    = (canvasWidth - logoGroupBBox.width) - 15,
            //    logoGroupY    = 15;
            //logoGroup.transform({x:logoGroupX, y:logoGroupY});
            //logoGroup.attr('class', 'svg-logo');
            //
            //var tagLineGroup  = draw.group().attr({'class':'tag-line'}),
            //    tagLineCircle = tagLineGroup.circle(circleDiameter),
            //    tagLineText   = tagLineGroup.text(function(add){
            //        add.tspan('we are a').fill('#fff').attr({dy:0,x:0});
            //        add.tspan('hub').fill('#fff').attr({dy:130,x:-7});
            //        add.tspan('for the artistic, cultural and').fill('#fff').attr({dy:40,x:0});
            //        add.tspan('creative activity in jackson hole').fill('#fff').attr({dy:35,x:0});
            //    }).attr({'font-family':'inherit'});
            //
            //tagLineGroup.transform({x:centerX, y:centerY});
            //tagLineText.transform({x:-120,y:-90});
            //tagLineCircle.attr({cx:0, cy:0}).fill('rgba(208,7,121,0.7)');
            //
            //var logoEllipse     = logoGroup.node.querySelector('ellipse'),
            //    logoEllipseBBox = logoEllipse.getBBox(),
            //    logoCircleX     = logoGroupX + ((logoEllipseBBox.width * logoScale) / 2),
            //    logoCircleY     = logoGroupY + (logoEllipseBBox.height * logoScale) / 2,
            //    angle           = Math.atan2(centerY - logoCircleY, centerX - logoCircleX),// * 180 / Math.PI,
            //    circX           = centerX - ((circleDiameter + 4) / 2) * Math.cos(angle),
            //    circY           = centerY - ((circleDiameter + 4) / 2) * Math.sin(angle);
            //
            //draw.line(logoCircleX,logoCircleY,circX,circY).stroke({
            //    width: 2,
            //    linecap: 'round',
            //    dasharray: '1,5',
            //    color: '#fff'
            //}).attr('class', 'spoke-line').back();
            //
            //var lineY1 = centerY + (circleRadius + 4),
            //    lineY2 = centerY + (circleRadius + 290);
            //
            //draw.line(centerX, lineY1, centerX, lineY2).stroke({
            //    width: 2,
            //    linecap: 'round',
            //    dasharray: '1,5',
            //    color: '#fff'
            //}).attr('class', 'down-line');

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
            //var scrollNavGroup = draw.group().attr('class', 'scroll-navs');
            //scrollNavGroup.circle(20).attr('class', 'active').fill('rgba(255,255,255,0.25)');
            //scrollNavGroup.circle(20).attr({cy:50}).fill('rgba(255,255,255,0.25)');
            //scrollNavGroup.circle(20).attr({cy:90}).fill('rgba(255,255,255,0.25)');
            //scrollNavGroup.transform({
            //    x: canvasWidth - 40,
            //    y: centerY - (scrollNavGroup.bbox().height / 2)
            //});
        }

        return {
            link: _link
        };
    }]);