/**
 *
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 **/
;(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery);

/*
 * jQuery Superfish Menu Plugin - v1.7.7
 * Copyright (c) 2015 
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */

;(function(e,s){"use strict";var o=function(){var o={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",menuArrowClass:"sf-arrows"},n=function(){var s=/^(?![\w\W]*Windows Phone)[\w\W]*(iPhone|iPad|iPod)/i.test(navigator.userAgent);return s&&e("html").css("cursor","pointer").on("click",e.noop),s}(),t=function(){var e=document.documentElement.style;return"behavior"in e&&"fill"in e&&/iemobile/i.test(navigator.userAgent)}(),i=function(){return!!s.PointerEvent}(),r=function(e,s){var n=o.menuClass;s.cssArrows&&(n+=" "+o.menuArrowClass),e.toggleClass(n)},a=function(s,n){return s.find("li."+n.pathClass).slice(0,n.pathLevels).addClass(n.hoverClass+" "+o.bcClass).filter(function(){return e(this).children(n.popUpSelector).hide().show().length}).removeClass(n.pathClass)},l=function(e){e.children("a").toggleClass(o.anchorClass)},h=function(e){var s=e.css("ms-touch-action"),o=e.css("touch-action");o=o||s,o="pan-y"===o?"auto":"pan-y",e.css({"ms-touch-action":o,"touch-action":o})},u=function(s,o){var r="li:has("+o.popUpSelector+")";e.fn.hoverIntent&&!o.disableHI?s.hoverIntent(c,f,r):s.on("mouseenter.superfish",r,c).on("mouseleave.superfish",r,f);var a="MSPointerDown.superfish";i&&(a="pointerdown.superfish"),n||(a+=" touchend.superfish"),t&&(a+=" mousedown.superfish"),s.on("focusin.superfish","li",c).on("focusout.superfish","li",f).on(a,"a",o,p)},p=function(s){var o=e(this),n=m(o),t=o.siblings(s.data.popUpSelector);return n.onHandleTouch.call(t)===!1?this:(t.length>0&&t.is(":hidden")&&(o.one("click.superfish",!1),"MSPointerDown"===s.type||"pointerdown"===s.type?o.trigger("focus"):e.proxy(c,o.parent("li"))()),void 0)},c=function(){var s=e(this),o=m(s);clearTimeout(o.sfTimer),s.siblings().superfish("hide").end().superfish("show")},f=function(){var s=e(this),o=m(s);n?e.proxy(d,s,o)():(clearTimeout(o.sfTimer),o.sfTimer=setTimeout(e.proxy(d,s,o),o.delay))},d=function(s){s.retainPath=e.inArray(this[0],s.$path)>-1,this.superfish("hide"),this.parents("."+s.hoverClass).length||(s.onIdle.call(v(this)),s.$path.length&&e.proxy(c,s.$path)())},v=function(e){return e.closest("."+o.menuClass)},m=function(e){return v(e).data("sf-options")};return{hide:function(s){if(this.length){var o=this,n=m(o);if(!n)return this;var t=n.retainPath===!0?n.$path:"",i=o.find("li."+n.hoverClass).add(this).not(t).removeClass(n.hoverClass).children(n.popUpSelector),r=n.speedOut;if(s&&(i.show(),r=0),n.retainPath=!1,n.onBeforeHide.call(i)===!1)return this;i.stop(!0,!0).animate(n.animationOut,r,function(){var s=e(this);n.onHide.call(s)})}return this},show:function(){var e=m(this);if(!e)return this;var s=this.addClass(e.hoverClass),o=s.children(e.popUpSelector);return e.onBeforeShow.call(o)===!1?this:(o.stop(!0,!0).animate(e.animation,e.speed,function(){e.onShow.call(o)}),this)},destroy:function(){return this.each(function(){var s,n=e(this),t=n.data("sf-options");return t?(s=n.find(t.popUpSelector).parent("li"),clearTimeout(t.sfTimer),r(n,t),l(s),h(n),n.off(".superfish").off(".hoverIntent"),s.children(t.popUpSelector).attr("style",function(e,s){return s.replace(/display[^;]+;?/g,"")}),t.$path.removeClass(t.hoverClass+" "+o.bcClass).addClass(t.pathClass),n.find("."+t.hoverClass).removeClass(t.hoverClass),t.onDestroy.call(n),n.removeData("sf-options"),void 0):!1})},init:function(s){return this.each(function(){var n=e(this);if(n.data("sf-options"))return!1;var t=e.extend({},e.fn.superfish.defaults,s),i=n.find(t.popUpSelector).parent("li");t.$path=a(n,t),n.data("sf-options",t),r(n,t),l(i),h(n),u(n,t),i.not("."+o.bcClass).superfish("hide",!0),t.onInit.call(this)})}}}();e.fn.superfish=function(s){return o[s]?o[s].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof s&&s?e.error("Method "+s+" does not exist on jQuery.fn.superfish"):o.init.apply(this,arguments)},e.fn.superfish.defaults={popUpSelector:"ul,.sf-mega",hoverClass:"sfHover",pathClass:"overrideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},animationOut:{opacity:"hide"},speed:"normal",speedOut:"fast",cssArrows:!0,disableHI:!1,onInit:e.noop,onBeforeShow:e.noop,onShow:e.noop,onBeforeHide:e.noop,onHide:e.noop,onIdle:e.noop,onDestroy:e.noop,onHandleTouch:e.noop}})(jQuery,window);

/*
 *  jQuery Wordpress Responsive Menu - v1.0.0
 *
 *  A responsive menu solution for Wordpress.
 *
 *  Made by Sean Kennedy @seank_au
 *  Under MIT License
 */
;(function($, window, document, undefined) {
		
	var pluginName = 'responsiveMenu', defaults = {};

	function Plugin(element, options) {
		this.element = element;
		this.settings = $.extend({}, defaults, options);
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	$.extend(Plugin.prototype, {
	
		init: function() {
			
			this.initDesktop();
			this.initMobile();

		},
		
		initDesktop: function() {
			
			$(this.element).superfish();
			
		},
		
		initMobile: function() {
			
			var body = $('body');
			
			$('.js-body-wrapper').on('click', function(e) {
				body.removeClass('nav-open');
			});
			
			$('.js-nav-trigger').on('click', function(e) {
				e.stopPropagation();
				body.toggleClass('nav-open');
			});
			
			$('.js-mobile-nav .menu-item-has-children > a').append('<div class="sub-menu-trigger"><i class="fa fa-angle-down"></i></div>');
			$('.js-mobile-nav > ul .current-menu-ancestor > .sub-menu').slideToggle(0);
			$('.current-menu-ancestor > a > .sub-menu-trigger').find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
			
			$(document).on('click', '.sub-menu-trigger', function(e){
    			e.preventDefault();
				$(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
				$(this).parent().next('.sub-menu').slideToggle(250);
			});
			
		}

	});

	$.fn[pluginName] = function(options) {
	
		this.each(function() {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
			}
		});
		
		return this;
		
	};
  
})(jQuery, window, document);