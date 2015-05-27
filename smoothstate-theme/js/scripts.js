(function() {
	
	// SmoothState.js
    var $body = $('html, body'),
    	relativeUrl;
    	$page = $('#main'),
    smoothState = $page.smoothState({
        prefetch: true,
        pageCacheSize: 10,
        // blacklist anything you dont want targeted
        blacklist : '',
        development : false,
        // Runs when a link has been activated
        onStart: {
            duration: 0, // Duration of our animation
            render: function (url, $container) {
	            
                // Add your CSS animation reversing class
				$page.addClass('is-exiting');

				// Restart your animation
				smoothState.restartCSSAnimations();
            }
        },
        onEnd: {
            duration: 0, // Duration of the animations, if any.
            render: function (url, $container, $content) {
	            
				$body.css('cursor', 'auto');
                $body.find('a').css('cursor', 'auto');
	            
                $page.removeClass('is-exiting');
                
                $container.html($content);
                
                // Trigger document.ready and window.load
                $(document).ready();
                $(window).trigger('load');
            }
        },
        callback: function(url, $container, $content) {
	        
	        relativeUrl = url.replace(location.protocol + '//' + location.hostname, '');
	        
	        // Trigger Google Analytics pageview
			if (typeof window.ga !== 'undefined') {
				ga('send', 'pageview', {
				  'page': relativeUrl,
				  'title': document.title
				});
			}
 
        }
    }).data('smoothState');
	
	// Responsive Menu
	$('.js-nav-list').responsiveMenu();
	
	// iCheck
	$('input').iCheck();
	
	// Heapbox
	$('select').heapbox();

})();

// Capture jquery.ready for plugins that require
(function($, undefined) {
    var isFired = false;
    var oldReady = jQuery.fn.ready;
    $(function() {
        isFired = true;
        $(document).ready();
    });
    jQuery.fn.ready = function(fn) {
        if(fn === undefined) {
            $(document).trigger('_is_ready');
            return;
        }
        if(isFired) {
            window.setTimeout(fn, 1);
        }
        $(document).bind('_is_ready', fn);
    };
})(jQuery);