angular.module("artsy.common").

    directive('isotope', ['Isotope', 'imagesLoaded',
        function( Isotope, imagesLoaded ){

            function _link(scope, $elem, attrs){
                var element     = $elem[0],
                    //filters     = element.querySelectorAll('[isotope-filters] a[data-filter]'),
                    container   = element.querySelector('[isotope-grid]'),
                    gridNodes   = element.querySelectorAll('.isotope-node');


                // Initialize Isotope instance
                imagesLoaded(container, function(){
                    scope.isotopeInstance = new Isotope(container, {
                        itemSelector: '.isotope-node',
                        layoutMode: attrs.isotope || 'masonry',
                        cellsByColumn: {
                            columnWidth: '.grid-sizer',
                            columnHeight: '.grid-sizer'
                        }
                    });
                });

                // Filters
                //angular.element(filters).on('click', function(){
                //    angular.element(filters).removeClass('active');
                //    angular.element(this).addClass('active');
                //    var _filter = this.getAttribute('data-filter');
                //    scope.isotopeInstance.arrange({
                //        filter: _filter
                //    });
                //});

                // Click to activate
                angular.element(gridNodes).on('click', function(){
                    angular.element(gridNodes).removeClass('active');
                    angular.element(this).addClass('active');
                });
            }

            return {
                restrict:   'A',
                scope:      true,
                link:       _link
            };
        }
    ]);