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
      function reverseBase64AndParseJson(_val) {
            return  JSON.parse(atob(_val));
        }
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
      
        $("#subscriber_author_Id").change(function(){
           if(!$(this).val()){
               return false;
           };
           
           var authorObject = reverseBase64AndParseJson($("#subscriber_author_Id option:selected").attr("attr"));
           var list = "";
          if(authorObject.categories.length == 0){
              return;
          }
          $.each(authorObject.categories,function(_index){
             list += "<option value='"+authorObject.author.ID+"'>"+authorObject.categories[_index].name+"</option>"; 
          });
          $("#authors categories").html(list);
           
//            $.each(event, function (currIndex) {
//                var newEventObject = {name: eventName, paramObject: event[currIndex], paramName: _.keys(event[currIndex])[0]}; 
//                    eventsParams.push(newEventObject);
//            });
//            var newDivElement = "";
//           _.each(eventsParams,function(_activeEvent){
//             var rowClass = "class" + Math.floor((Math.random() * 1000) + 1);
//              newDivElement += "<div class='row field " + rowClass + "'>";
//            newDivElement += "<div class='col-sm-5'><input class='form-control' value='" + _activeEvent.name + "::" + _activeEvent.paramName + "' readonly></div>";
//            newDivElement += "<div class='col-sm-5'><input class='form-control' name='event_parameters"  + "[" + _activeEvent.name + "::" + _activeEvent.paramName  + "]" + "' value='' ></div>";
//            newDivElement += "<div class='col-sm-2'><button type='button' containerClassName='" + rowClass + "' class='btn field-remove-btn btn-small btn-danger'>&nbsp; - &nbsp;</button></div>";
//            newDivElement += "</div>"; 
//           });
//            $("#appended_event_parameters").html(newDivElement).hide().fadeIn("slow");
           
         });
 });
   


})( jQuery );
