/*!
 * jquery.state_select() - v0.5.1
 * http://adam.co/lab/jquery/state_select/
 * 2014-03-19
 *
 * Copyright 2013 Adam Coulombe
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @license http://www.gnu.org/licenses/gpl.html GPL2 License 
 */

(function ($) {
    'use strict';

    $.fn.extend({
        state_select: function (options) {
            // filter out <= IE6
            if (typeof document.body.style.maxHeight === 'undefined') {
                return this;
            }
            var defaults = {
                    customClass: 'state_select',
                    mapClass:    true,
                    mapStyle:    true,
					
            },
            options = $.extend(defaults, options),
            prefix = options.customClass,
            changed = function ($select,state_selectSpan) {
                var currentSelected = $select.find(':selected'),
                state_selectSpanInner = state_selectSpan.children(':first'),
                html = currentSelected.html() || '&nbsp;';

                state_selectSpanInner.html(html);
                
                if (currentSelected.attr('disabled')) {
                    state_selectSpan.addClass(getClass('DisabledOption'));
                } else {
                    state_selectSpan.removeClass(getClass('DisabledOption'));
                }
                
                setTimeout(function () {
                    state_selectSpan.removeClass(getClass('Open'));
                    $(document).off('mouseup.state_select');                  
                }, 60);
            },
            getClass = function(suffix){
                return prefix + suffix;
            };

            return this.each(function () {
                var $select = $(this),
                    state_selectInnerSpan = $('<span />').addClass(getClass('Inner')),
                    state_selectSpan = $('<span />');

                $select.after(state_selectSpan.append(state_selectInnerSpan));
                
                state_selectSpan.addClass(prefix);

                if (options.mapClass) {
                    state_selectSpan.addClass($select.attr('class'));
                }
                if (options.mapStyle) {
                    state_selectSpan.attr('style', $select.attr('style'));
                }

                $select
                    .addClass('hasstate_select')
                    .on('render.state_select', function () {
                        changed($select,state_selectSpan);
                        $select.css('width','');			
                        var selectBoxWidth = parseInt($select.outerWidth(), 10) -
                                (parseInt(state_selectSpan.outerWidth(), 10) -
                                    parseInt(state_selectSpan.width(), 10));
                        
                        // Set to inline-block before calculating outerHeight
                        state_selectSpan.css({
                            display: 'inline-block'
                        });
                        
                        var selectBoxHeight = state_selectSpan.outerHeight();

                        if ($select.attr('disabled')) {
                            state_selectSpan.addClass(getClass('Disabled'));
                        } else {
                            state_selectSpan.removeClass(getClass('Disabled'));
                        }

                        state_selectInnerSpan.css({
                            width:   selectBoxWidth,
                            display: 'inline-block'
                        });

                        $select.css({
                            '-webkit-appearance': 'menulist-button',
                            width:                state_selectSpan.outerWidth(123),
                            position:             'absolute',
                            opacity:              0,
                            height:               selectBoxHeight,
                            fontSize:             state_selectSpan.css('font-size')
                        });
                    })
                    .on('change.state_select', function () {
                        state_selectSpan.addClass(getClass('Changed'));
                        changed($select,state_selectSpan);
                    })
                    .on('keyup.state_select', function (e) {
                        if(!state_selectSpan.hasClass(getClass('Open'))){
                            $select.trigger('blur.state_select');
                            $select.trigger('focus.state_select');
                        }else{
                            if(e.which==13||e.which==27){
                                changed($select,state_selectSpan);
                            }
                        }
                    })
                    .on('mousedown.state_select', function () {
                        state_selectSpan.removeClass(getClass('Changed'));
                    })
                    .on('mouseup.state_select', function (e) {
                        
                        if( !state_selectSpan.hasClass(getClass('Open'))){
                            // if FF and there are other selects open, just apply focus
                            if($('.'+getClass('Open')).not(state_selectSpan).length>0 && typeof InstallTrigger !== 'undefined'){
                                $select.trigger('focus.state_select');
                            }else{
                                state_selectSpan.addClass(getClass('Open'));
                                e.stopPropagation();
                                $(document).one('mouseup.state_select', function (e) {
                                    if( e.target != $select.get(0) && $.inArray(e.target,$select.find('*').get()) < 0 ){
                                        $select.trigger('blur.state_select');
                                    }else{
                                        changed($select,state_selectSpan);
                                    }
                                });
                            }
                        }
                    })
                    .on('focus.state_select', function () {
                        state_selectSpan.removeClass(getClass('Changed')).addClass(getClass('Focus'));
                    })
                    .on('blur.state_select', function () {
                        state_selectSpan.removeClass(getClass('Focus')+' '+getClass('Open'));
                    })
                    .on('mouseenter.state_select', function () {
                        state_selectSpan.addClass(getClass('Hover'));
                    })
                    .on('mouseleave.state_select', function () {
                        state_selectSpan.removeClass(getClass('Hover'));
                    })
                    .trigger('render.state_select');
            });
        }
    });
})(jQuery);
