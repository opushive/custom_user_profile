(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
 $(document).ready(function () {
      $("#author_Id").change(function(){
        var authorId =  $(this).val();
        if(!authorId){
          authorId = 0;
        }
        var data = {
			'action': 'get_author_categories',
			'author_Id': authorId
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
                    
                    response = JSON.parse(response);
		if(response.length == 0){
                    $("#category_Id").html("<option>Categories not available</option>");
                    return false;
                }
                var option = "<option>Select Categories</option>";
                    
                $.each(response,function(_index,currValue){
                    option += "<option value='"+currValue.cat_ID+"'>"+currValue.name+"</option>";
                });
                  $("#category_Id").html(option);
                    return false;
		});
      }); 
 });
    


})( jQuery );
