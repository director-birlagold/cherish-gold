/*!
 * jquery.bringafriend() - v0.5.1
 * http://adam.co/lab/jquery/bringafriend/
 * 2014-03-19
 *
 * Copyright 2013 Adam Coulombe
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @license http://www.gnu.org/licenses/gpl.html GPL2 License 
 */

(function ($) {
    'use strict';

    $.fn.extend({
        bringafriend1: function (options) {
            // filter out <= IE6
            if (typeof document.body.style.maxHeight === 'undefined') {
                return this;
            }
            var defaults = {
                    customClass: '',
                    mapClass:    true,
                    mapStyle:    true,
					
            },
            options = $.extend(defaults, options),
            prefix = options.customClass,
            changed = function ($select,bringafriend1Span) {
                var currentSelected = $select.find(':selected'),
                bringafriend1SpanInner = bringafriend1Span.children(':first'),
                html = currentSelected.html() || '&nbsp;';

                bringafriend1SpanInner.html(html);
                
                if (currentSelected.attr('disabled')) {
                    bringafriend1Span.addClass(getClass('DisabledOption'));
                } else {
                    bringafriend1Span.removeClass(getClass('DisabledOption'));
                }
                
                setTimeout(function () {
                    bringafriend1Span.removeClass(getClass('Open'));
                    $(document).off('mouseup.bringafriend');                  
                }, 60);
            },
            getClass = function(suffix){
                return prefix + suffix;
            };

            return this.each(function () {
                var $select = $(this),
                    bringafriend1InnerSpan = $('<span />').addClass(getClass('Inner')),
                    bringafriend1Span = $('<span />');

                $select.after(bringafriend1Span.append(bringafriend1InnerSpan));
                
                bringafriend1Span.addClass(prefix);

                if (options.mapClass) {
                    bringafriend1Span.addClass($select.attr('class'));
                }
                if (options.mapStyle) {
                    bringafriend1Span.attr('style', $select.attr('style'));
                }

                $select
                    .addClass('hasbringafriend1')
                    .on('render.bringafriend1', function () {
                        changed($select,bringafriend1Span);
                        $select.css('width','');			
                        var selectBoxWidth = parseInt($select.outerWidth(), 10) -
                                (parseInt(bringafriend1Span.outerWidth(), 10) -
                                    parseInt(bringafriend1Span.width(), 10));
                        
                        // Set to inline-block before calculating outerHeight
                        bringafriend1Span.css({
                            display: 'inline-block'
                        });
                        
                        var selectBoxHeight = bringafriend1Span.outerHeight();

                        if ($select.attr('disabled')) {
                            bringafriend1Span.addClass(getClass('Disabled'));
                        } else {
                            bringafriend1Span.removeClass(getClass('Disabled'));
                        }

                        bringafriend1InnerSpan.css({
                            width:   selectBoxWidth,
                            display: 'inline-block'
                        });

                        $select.css({
                            '-webkit-appearance': 'menulist-button',
                            width:                bringafriend1Span.outerWidth(270),
                            position:             'absolute',
                            opacity:              0,
                            height:               selectBoxHeight,
                            fontSize:             bringafriend1Span.css('font-size')
                        });
                    })
                    .on('change.bringafriend1', function () {
                        bringafriend1Span.addClass(getClass('Changed'));
                        changed($select,bringafriend1Span);
                    })
                    .on('keyup.bringafriend1', function (e) {
                        if(!bringafriend1Span.hasClass(getClass('Open'))){
                            $select.trigger('blur.bringafriend1');
                            $select.trigger('focus.bringafriend1');
                        }else{
                            if(e.which==13||e.which==27){
                                changed($select,bringafriend1Span);
                            }
                        }
                    })
                    .on('mousedown.bringafriend1', function () {
                        bringafriend1Span.removeClass(getClass('Changed'));
                    })
                    .on('mouseup.bringafriend1', function (e) {
                        
                        if( !bringafriend1Span.hasClass(getClass('Open'))){
                            // if FF and there are other selects open, just apply focus
                            if($('.'+getClass('Open')).not(bringafriend1Span).length>0 && typeof InstallTrigger !== 'undefined'){
                                $select.trigger('focus.bringafriend1');
                            }else{
                                bringafriend1Span.addClass(getClass('Open'));
                                e.stopPropagation();
                                $(document).one('mouseup.bringafriend', function (e) {
                                    if( e.target != $select.get(0) && $.inArray(e.target,$select.find('*').get()) < 0 ){
                                        $select.trigger('blur.bringafriend1');
                                    }else{
                                        changed($select,bringafriend1Span);
                                    }
                                });
                            }
                        }
                    })
                    .on('focus.bringafriend1', function () {
                        bringafriend1Span.removeClass(getClass('Changed')).addClass(getClass('Focus'));
                    })
                    .on('blur.bringafriend1', function () {
                        bringafriend1Span.removeClass(getClass('Focus')+' '+getClass('Open'));
                    })
                    .on('mouseenter.bringafriend1', function () {
                        bringafriend1Span.addClass(getClass('Hover'));
                    })
                    .on('mouseleave.bringafriend1', function () {
                        bringafriend1Span.removeClass(getClass('Hover'));
                    })
                    .trigger('render.bringafriend1');
            });
        }
    });
})(jQuery);
