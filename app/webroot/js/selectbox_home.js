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
        product: function (options) {
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
            changed = function ($select,productSpan) {
                var currentSelected = $select.find(':selected'),
                productSpanInner = productSpan.children(':first'),
                html = currentSelected.html() || '&nbsp;';

                productSpanInner.html(html);
                
                if (currentSelected.attr('disabled')) {
                    productSpan.addClass(getClass('DisabledOption'));
                } else {
                    productSpan.removeClass(getClass('DisabledOption'));
                }
                
                setTimeout(function () {
                    productSpan.removeClass(getClass('Open'));
                    $(document).off('mouseup.bringafriend');                  
                }, 60);
            },
            getClass = function(suffix){
                return prefix + suffix;
            };

            return this.each(function () {
                var $select = $(this),
                    productInnerSpan = $('<span />').addClass(getClass('Inner')),
                    productSpan = $('<span />');

                $select.after(productSpan.append(productInnerSpan));
                
                productSpan.addClass(prefix);

                if (options.mapClass) {
                    productSpan.addClass($select.attr('class'));
                }
                if (options.mapStyle) {
                    productSpan.attr('style', $select.attr('style'));
                }

                $select
                    .addClass('hasproduct')
                    .on('render.product', function () {
                        changed($select,productSpan);
                        $select.css('width','');			
                        var selectBoxWidth = parseInt($select.outerWidth(), 10) -
                                (parseInt(productSpan.outerWidth(), 10) -
                                    parseInt(productSpan.width(), 10));
                        
                        // Set to inline-block before calculating outerHeight
                        productSpan.css({
                            display: 'inline-block'
                        });
                        
                        var selectBoxHeight = productSpan.outerHeight();

                        if ($select.attr('disabled')) {
                            productSpan.addClass(getClass('Disabled'));
                        } else {
                            productSpan.removeClass(getClass('Disabled'));
                        }

                        productInnerSpan.css({
                            width:   selectBoxWidth,
                            display: 'inline-block'
                        });

                        $select.css({
                            '-webkit-appearance': 'menulist-button',
                            width:                productSpan.outerWidth(270),
                            position:             'absolute',
                            opacity:              0,
                            height:               selectBoxHeight,
                            fontSize:             productSpan.css('font-size')
                        });
                    })
                    .on('change.product', function () {
                        productSpan.addClass(getClass('Changed'));
                        changed($select,productSpan);
                    })
                    .on('keyup.product', function (e) {
                        if(!productSpan.hasClass(getClass('Open'))){
                            $select.trigger('blur.product');
                            $select.trigger('focus.product');
                        }else{
                            if(e.which==13||e.which==27){
                                changed($select,productSpan);
                            }
                        }
                    })
                    .on('mousedown.product', function () {
                        productSpan.removeClass(getClass('Changed'));
                    })
                    .on('mouseup.product', function (e) {
                        
                        if( !productSpan.hasClass(getClass('Open'))){
                            // if FF and there are other selects open, just apply focus
                            if($('.'+getClass('Open')).not(productSpan).length>0 && typeof InstallTrigger !== 'undefined'){
                                $select.trigger('focus.product');
                            }else{
                                productSpan.addClass(getClass('Open'));
                                e.stopPropagation();
                                $(document).one('mouseup.bringafriend', function (e) {
                                    if( e.target != $select.get(0) && $.inArray(e.target,$select.find('*').get()) < 0 ){
                                        $select.trigger('blur.product');
                                    }else{
                                        changed($select,productSpan);
                                    }
                                });
                            }
                        }
                    })
                    .on('focus.product', function () {
                        productSpan.removeClass(getClass('Changed')).addClass(getClass('Focus'));
                    })
                    .on('blur.product', function () {
                        productSpan.removeClass(getClass('Focus')+' '+getClass('Open'));
                    })
                    .on('mouseenter.product', function () {
                        productSpan.addClass(getClass('Hover'));
                    })
                    .on('mouseleave.product', function () {
                        productSpan.removeClass(getClass('Hover'));
                    })
                    .trigger('render.product');
            });
        }
    });
})(jQuery);
