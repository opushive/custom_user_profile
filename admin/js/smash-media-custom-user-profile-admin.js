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
     var previousSelecions = [];
      function reverseBase64AndParseJson(_val) {
            return  JSON.parse(atob(_val));
        }
        function evaluateCategoryAuthorString(_authorCategories){
            var list = "";
            $.each(_authorCategories,function(_index){
                if(previousSelecions.indexOf(_authorCategories[_index]) !== -1) {
                    return false;
                }
           var authorCategoryParts = _authorCategories[_index].split("|");
           previousSelecions.push(_authorCategories[_index]);
           list += '<option value="'+_authorCategories[_index]+'" selected>'+authorCategoryParts[2]+'</option>';
         //  $("#selected-categories").ht
        });
        $("#selected-categories").append(list);
        $("#selected-categories").select2({
            tags: true
        })
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
              $("#authors_categories").html("No categories avaialable for selected author");
              return;
          }
          $.each(authorObject.categories,function(_index){
              console.log(authorObject.categories);
                console.log(authorObject.categories[_index]);
                console.log(authorObject.categories[_index]);
                console.log(authorObject.categories[_index].name);
             list += "<input type='checkbox'  value='"+authorObject.author.ID+"|"+ authorObject.categories[_index].cat_ID + "|"+ authorObject.author.data.display_name+"["+
                 authorObject.categories[_index].name +"]'>"+authorObject.author.data.display_name+"["+
                 authorObject.categories[_index].name    
                      +"]&nbsp;&nbsp;&nbsp;"; 
          });
          if(list != ""){
              list += "<button type='button' id='subscribe-btn'>Subscribe to categories selected</button>";
          }
          $("#author-categories-container").removeClass("hidden").fadeIn('slow',function(){
              $("#authors_categories").html(list);  
          });
          
          $(document).on("click","#subscribe-btn",function(e){
               e.preventDefault();
            var allInputs =  $("#author-categories-container input:checked"); 
            var allValues = [];
            $(allInputs).each(function(_index){
               console.log($(allInputs[_index]).val()) ;
               allValues.push($(allInputs[_index]).val());
            });
            
           evaluateCategoryAuthorString(allValues);
           e.stopPropagation();
          });
          
        
           
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
//            $("#appended_evenservice-tokenizert_parameters").html(newDivElement).hide().fadeIn("slow");
           
         });
         
         $(".events").select2({
            tags:true,
            tokenSeparators: [',', ' '],
             placeholder: "",
             allowClear: true
           });
           $(".selected_categories").select2({
            tags:true,
            tokenSeparators: [',', ' '],
             placeholder: "",
             allowClear: true
           });
 });
   


})( jQuery );
