(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
        $(document).ready(function(){
           function reverseBase64AndParseJson(_val) {
            return  JSON.parse(atob(_val));
        }
        $(".activate-author-posts").click(function(){
         var authorPosts  =   $(this).attr("data-author-posts");
         authorPosts =  reverseBase64AndParseJson(authorPosts);
         var currentAuthor = $(this).attr("data-current-author");
        
          var currentUser = $(this).attr("data-current-user");
          
          //use the author post above to populate the post area
          
         
        });
        
         
        
        $(".activate-category").click(function(){
            var currentUser = $(this).attr("data-current-user");
            var categoryPosts = reverseBase64AndParseJson($(this).attr("data-category-posts"));
            
            //use category post above to populate post area
        });
        
        $(".susbcription-post").click(function(){
           var  susbcriptionMeta = $(this).attr("data-subscription-meta");
           
           //send ajax request to admin withi susbcriptionMeta
        });
 
        });
         
})( jQuery );
