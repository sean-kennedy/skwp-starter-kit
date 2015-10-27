(function() {
	
	// SmoothState.js
    var $body = $('html, body'),
    	$page = $('#main'),
    	smoothStateOptions = {
	        prefetch: true,
	        blacklist: '.no-smoothState, .gform_button',
	        cacheLength: 10,
	        forms: 'form',
	        debug: true,
	        onStart: {
	            duration: 400,
	            render: function ($container) {
		            
	                // Add your CSS animation reversing class
					$container.addClass('is-exiting');
	
					// Restart your animation
					smoothState.restartCSSAnimations();
					
	            }
	        },
			onReady: {
				duration: 0,
				render: function ($container, $newContent) {
					
					// Remove your CSS animation reversing class
					$container.removeClass('is-exiting');
	
					// Inject the new content
					$container.html($newContent);
					
					// Trigger document.ready and window.load
					$(document).ready();
	                $(window).trigger('load');
					
	    		}	
	    	},
	        onAfter: function(url, $container, $content) {
		        
		        // Trigger Google Analytics pageview
				if (typeof window.ga !== 'undefined') {
					ga('send', 'pageview', {
					  'page': smoothState.href.replace(location.protocol + '//' + location.hostname, ''),
					  'title': document.title
					});
				}
	 
	        }
	    },
	    smoothState = $page.smoothState(smoothStateOptions).data('smoothState');

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