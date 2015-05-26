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
            defaultSpokeWidth       = 2,
            defaultSpokeDistance    = 10,
            defaultSpokeAnimTime    = 700,
            defaultSpokeAnimDelay   = 0,
            defaultSpokeAnimEase    = '>'; // http://documentup.com/wout/svg.js#animating-elements/easing

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
                animate(
                    // animation time
                    +(nodeData.attrs.spokeAnimationTime) || defaultSpokeAnimTime,
                    // easing function (string, so don't cast)
                    nodeData.attrs.spokeAnimationEase || defaultSpokeAnimEase,
                    // delay
                    +(nodeData.attrs.spokeAnimationDelay) || defaultSpokeAnimDelay
                ).
                during(function( t, morph ){
                    this.attr({y2: morph(ay,by), x2: morph(ax,bx)});
                });
                //.after(function(){ redraw = true; });
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
                console.log('_drawing_spokes_:)');
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