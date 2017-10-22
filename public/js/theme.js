/*
 Name: Theme Base
 Written by: 
 Theme Version:	1.0
 */

// Theme
window.theme = {};

// Theme Common Functions
window.theme.fn = {

    getOptions: function(opts) {

        'use strict';

        if (typeof(opts) == 'object') {

            return opts;

        } else if (typeof(opts) == 'string') {

            try {
                return JSON.parse(opts.replace(/'/g,'"').replace(';',''));
            } catch(e) {
                return {};
            }

        } else {

            return {};

        }

    }

};

// Scroll to Top
(function(theme, $) {

    'use strict';

    theme = theme || {};

    $.extend(theme, {

        PluginScrollToTop: {

            defaults: {
                wrapper: $('body'),
                offset: 150,
                buttonClass: 'scroll-to-top',
                iconClass: 'fa fa-chevron-up',
                delay: 1000,
                visibleMobile: false,
                label: false,
                easing: 'easeOutBack'
            },

            initialize: function(opts) {
                var initialized = true;

                this
                    .setOptions(opts)
                    .build()
                    .events();

                return this;
            },

            setOptions: function(opts) {
                this.options = $.extend(true, {}, this.defaults, opts);

                return this;
            },

            build: function() {
                var self = this,
                    $el;

                // Base HTML Markup
                $el = $('<a />')
                    .addClass(self.options.buttonClass)
                    .attr({
                        'href': '#'
                    })
                    .append(
                        $('<i />')
                            .addClass(self.options.iconClass)
                    );

                // Visible Mobile
                if (!self.options.visibleMobile) {
                    $el.addClass('mobile-hidden');
                }

                // Label
                if (self.options.label) {
                    $el.append(
                        $('<span />').html(self.options.label)
                    );
                }

                this.options.wrapper.append($el);

                this.$el = $el;

                return this;
            },

            events: function() {
                var self = this,
                    _isScrolling = false;

                // Click Element Action
                self.$el.on('click', function(e) {
                    e.preventDefault();
                    $('body, html').animate({
                        scrollTop: 0
                    }, self.options.delay, self.options.easing);
                    return false;
                });

                // Show/Hide Button on Window Scroll event.
                $(window).scroll(function() {

                    if (!_isScrolling) {

                        _isScrolling = true;

                        if ($(window).scrollTop() > self.options.offset) {

                            self.$el.stop(true, true).addClass('visible');
                            _isScrolling = false;

                        } else {

                            self.$el.stop(true, true).removeClass('visible');
                            _isScrolling = false;

                        }

                    }

                });

                return this;
            }

        }

    });

}).apply(this, [window.theme, jQuery]);


// Search
(function(theme, $) {

    'use strict';

    theme = theme || {};

    $.extend(theme, {

        PluginSearch: {

            defaults: {
                wrapper: $('.search-form')
            },

            initialize: function($wrapper, opts) {
                this.$wrapper = ($wrapper || this.defaults.wrapper);

                this
                    .setOptions(opts)
                    .build();

                return this;
            },

            setOptions: function(opts) {
                this.options = $.extend(true, {}, this.defaults, opts, theme.fn.getOptions(this.$wrapper.data('plugin-options')));

                return this;
            },

            build: function() {

                var $wrappers = this.$wrapper;

                $wrappers.each(function() {
                    var $wrapper = $(this);

                    $wrapper.parent().on('click', '.search-toggle', function(e) {
                        $wrapper.find('.header-search-wrapper').toggleClass('open');
                        e.preventDefault();
                        e.stopPropagation();
                    });

                    $wrapper.on('click', function(e) {
                        e.stopPropagation();
                    });

                    if (!('ontouchstart' in document)) {
                        $('html,body').on('click', function() {
                            $wrapper.find('.header-search-wrapper').removeClass('open');
                        });
                    }

                    if (($.isFunction($.fn.validate))) {
                        $wrapper.validate({
                            errorPlacement: function(error, element) {}
                        });
                    }
                });

                return this;
            }

        }

    });

}).apply(this, [window.theme, jQuery]);

// Masonry
(function(theme, $) {

    'use strict';

    theme = theme || {};

    var instanceName = '__masonry';

    var PluginMasonry = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginMasonry.defaults = {
        itemSelector: 'li'
    };

    PluginMasonry.prototype = {
        initialize: function($el, opts) {
            if ($el.data(instanceName)) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend(true, {}, PluginMasonry.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            if (!($.isFunction($.fn.isotope))) {
                return this;
            }

            var self = this;

            self.options.wrapper.waitForImages(function() {
                self.options.wrapper.isotope(this.options);
            });

            return this;
        }

    };

    // expose to scope
    $.extend(theme, {
        PluginMasonry: PluginMasonry
    });

    // jquery plugin
    $.fn.themePluginMasonry = function(opts) {
        return this.map(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginMasonry($this, opts);
            }

        });
    };

}).apply(this, [window.theme, jQuery]);

// Carousel
(function(theme, $) {

    'use strict';

    theme = theme || {};

    var instanceName = '__carousel';

    var PluginCarousel = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginCarousel.defaults = {
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            479: {
                items: 1
            },
            768: {
                items: 2
            },
            979: {
                items: 3
            },
            1199: {
                items: 4
            }
        },
        navText: []
    };

    PluginCarousel.prototype = {
        initialize: function($el, opts) {
            if ($el.data(instanceName)) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend(true, {}, PluginCarousel.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            if (!($.isFunction($.fn.owlCarousel))) {
                return this;
            }

            var $el = this.options.wrapper;

            // Add Theme Class
            $el.addClass('owl-theme');

            // Force RTL according to HTML dir attribute
            if ($('html').attr('dir') == 'rtl') {
                this.options = $.extend(true, {}, this.options, {
                    rtl: true
                });
            }

            if (this.options.items == 1) {
                this.options.responsive = {};
            }

            if (this.options.items > 4) {
                this.options = $.extend(true, {}, this.options, {
                    responsive: {
                        1199: {
                            items: this.options.items
                        }
                    }
                });
            }

            // Auto Height Fixes
            if (this.options.autoHeight) {
                var itemsHeight = [];

                $el.find('.owl-item').each(function(){
                    if( $(this).hasClass('active') ) {
                        itemsHeight.push( $(this).height() );
                    }
                });

                $(window).afterResize(function() {
                    $el.find('.owl-stage-outer').height( Math.max.apply(null, itemsHeight) );
                });

                $(window).on('load', function() {
                    $el.find('.owl-stage-outer').height( Math.max.apply(null, itemsHeight) );
                });
            }

            // Initialize OwlCarousel
            $el.owlCarousel(this.options).addClass('owl-carousel-init');

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginCarousel: PluginCarousel
    });

    // jquery plugin
    $.fn.themePluginCarousel = function(opts) {
        return this.map(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginCarousel($this, opts);
            }

        });
    };

}).apply(this, [window.theme, jQuery]);

// Lightbox
(function(theme, $) {

    'use strict';

    theme = theme || {};

    var instanceName = '__lightbox';

    var PluginLightbox = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginLightbox.defaults = {
        tClose: 'Close (Esc)',
        tLoading: 'Loading...',
        gallery: {
            tPrev: 'Previous (Left arrow key)',
            tNext: 'Next (Right arrow key)',
            tCounter: '%curr% of %total%'
        },
        image: {
            tError: '<a href="%url%">The image</a> could not be loaded.'
        },
        ajax: {
            tError: '<a href="%url%">The content</a> could not be loaded.'
        },
        callbacks: {
            open: function() {
                $('html').addClass('lightbox-opened');
            },
            close: function() {
                $('html').removeClass('lightbox-opened');
            }
        }
    };

    PluginLightbox.prototype = {
        initialize: function($el, opts) {
            if ($el.data(instanceName)) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend(true, {}, PluginLightbox.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            if (!($.isFunction($.fn.magnificPopup))) {
                return this;
            }

            this.options.wrapper.magnificPopup(this.options);

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginLightbox: PluginLightbox
    });

    // jquery plugin
    $.fn.themePluginLightbox = function(opts) {
        return this.map(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginLightbox($this, opts);
            }

        });
    };

}).apply(this, [window.theme, jQuery]);

// Parallax
(function(theme, $) {

    'use strict';

    theme = theme || {};

    var instanceName = '__parallax';

    var PluginParallax = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginParallax.defaults = {
        speed: 1.5,
        horizontalPosition: '50%',
        offset: 0
    };

    PluginParallax.prototype = {
        initialize: function($el, opts) {
            if ($el.data(instanceName)) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend(true, {}, PluginParallax.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            var self = this,
                $window = $(window),
                offset,
                yPos,
                background;

            // Create Parallax Element
            background = $('<div class="parallax-background"></div>');

            // Set Style for Parallax Element
            background.css({
                'background-image' : 'url(' + self.options.wrapper.data('image-src') + ')',
                'background-size' : 'cover',
                'position' : 'absolute',
                'top' : 0,
                'left' : 0,
                'width' : '100%',
                'height' : '180%'
            });

            // Add Parallax Element on DOM
            self.options.wrapper.prepend(background);

            // Set Overlfow Hidden and Position Relative to Parallax Wrapper
            self.options.wrapper.css({
                'position' : 'relative',
                'overflow' : 'hidden'
            });

            // Parallax Effect on Scroll & Resize
            var parallaxEffectOnScrolResize = function() {
                $window.on('scroll resize', function() {
                    offset  = self.options.wrapper.offset();
                    yPos    = -($window.scrollTop() - (offset.top)) / ((self.options.speed + 2) + (self.options.offset));
                    var plxPos  = (yPos < 0) ? Math.abs(yPos) : -Math.abs(yPos);
                    background.css({
                        'transform' : 'translate3d(0, '+ plxPos +'px, 0)',
                        'background-position-x' : self.options.horizontalPosition
                    });
                });

                $window.trigger('scroll');
            };

            if (!$.browser.mobile) {
                parallaxEffectOnScrolResize();
            } else {
                if( self.options.enableOnMobile == true ) {
                    parallaxEffectOnScrolResize();
                } else {
                    self.options.wrapper.addClass('parallax-disabled');
                }
            }

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginParallax: PluginParallax
    });

    // jquery plugin
    $.fn.themePluginParallax = function(opts) {
        return this.map(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginParallax($this, opts);
            }

        });
    };

}).apply(this, [window.theme, jQuery]);

// Revolution Slider
(function(theme, $) {

    'use strict';

    theme = theme || {};

    var instanceName = '__revolution';

    var PluginRevolutionSlider = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginRevolutionSlider.defaults = {
        sliderType: 'standard',
        sliderLayout: 'fullwidth',
        delay: 9000,
        gridwidth: 1170,
        gridheight: 500,
        spinner: 'spinner3',
        disableProgressBar: 'on',
        parallax: {
            type: 'off',
            bgparallax: 'off'
        },
        navigation: {
            keyboardNavigation: 'off',
            keyboard_direction: 'horizontal',
            mouseScrollNavigation: 'off',
            onHoverStop: 'off',
            touch: {
                touchenabled: 'on',
                swipe_threshold: 75,
                swipe_min_touches: 1,
                swipe_direction: 'horizontal',
                drag_block_vertical: false
            },
            arrows: {
                enable: true,
                hide_onmobile: true,
                hide_under: 480,
                hide_onleave: true,
                hide_delay: 200,
                hide_delay_mobile: 1200,
                left: {
                    h_align: 'left',
                    v_align: 'center',
                    h_offset: 0,
                    v_offset: 0
                },
                right: {
                    h_align: 'right',
                    v_align: 'center',
                    h_offset: 0,
                    v_offset: 0
                }
            }
        }
    };

    PluginRevolutionSlider.prototype = {
        initialize: function($el, opts) {
            if ($el.data(instanceName)) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build()
                .events();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend(true, {}, PluginRevolutionSlider.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            if (!($.isFunction($.fn.revolution))) {
                return this;
            }

            // Single Slider Class
            if(this.options.wrapper.find('> ul > li').length == 1) {
                this.options.wrapper.addClass('slider-single-slide');
            }

            this.options.wrapper.revolution(this.options);

            return this;
        },

        events: function() {

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginRevolutionSlider: PluginRevolutionSlider
    });

    // jquery plugin
    $.fn.themePluginRevolutionSlider = function(opts) {
        return this.map(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginRevolutionSlider($this, opts);
            }

        });
    };

}).apply(this, [window.theme, jQuery]);

/*------------------------------------------------
 * Theme Plugin Initialization
 *----------------------------------------------*/

// Commom Plugins
(function($) {

    'use strict';

    // Scroll to Top
    if (typeof theme.PluginScrollToTop !== 'undefined') {
        theme.PluginScrollToTop.initialize();
    }

    // Search
    if (typeof theme.PluginSearch !== 'undefined') {
        theme.PluginSearch.initialize();
    }

}).apply(this, [jQuery]);

// Carousel
(function($) {

    'use strict';

    if ($.isFunction($.fn['themePluginCarousel'])) {

        $(function() {
            $('[data-plugin-carousel]:not(.manual), .owl-carousel:not(.manual)').each(function() {
                var $this = $(this),
                    opts;

                var pluginOptions = theme.fn.getOptions($this.data('plugin-options'));
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginCarousel(opts);
            });
        });

    }

}).apply(this, [jQuery]);

// Masonry
(function($) {

    'use strict';

    if ($.isFunction($.fn['themePluginMasonry'])) {

        $(function() {
            $('[data-plugin-masonry]:not(.manual)').each(function() {
                var $this = $(this),
                    opts;

                var pluginOptions = theme.fn.getOptions($this.data('plugin-options'));
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginMasonry(opts);
            });
        });

    }

}).apply(this, [jQuery]);

// Lightbox
(function($) {

    'use strict';

    if ($.isFunction($.fn['themePluginLightbox'])) {

        $(function() {
            $('[data-plugin-lightbox]:not(.manual), .lightbox:not(.manual)').each(function() {
                var $this = $(this),
                    opts;

                var pluginOptions = theme.fn.getOptions($this.data('plugin-options'));
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginLightbox(opts);
            });
        });

    }

}).apply(this, [jQuery]);

// Parallax
(function($) {

    'use strict';

    if ($.isFunction($.fn['themePluginParallax'])) {

        $(function() {
            $('[data-plugin-parallax]:not(.manual)').each(function() {
                var $this = $(this),
                    opts;

                var pluginOptions = theme.fn.getOptions($this.data('plugin-options'));
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginParallax(opts);
            });
        });

    }

}).apply(this, [jQuery]);

// Events
(function( $ ) {

    'use strict';

    /*
     Popup with video or map
     */
    $('.popup-video, .popup-gmaps').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

}).apply( this, [ jQuery ]);

// Revolution Slider
(function($) {

    'use strict';

    if ($.isFunction($.fn['themePluginRevolutionSlider'])) {

        $(function() {
            $('[data-plugin-revolution-slider]:not(.manual), .slider-container .slider:not(.manual)').each(function() {
                var $this = $(this),
                    opts;

                var pluginOptions = theme.fn.getOptions($this.data('plugin-options'));
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginRevolutionSlider(opts);
            });
        });

    }

}).apply(this, [jQuery]);
