//var vue = new Vue({
//            el:'#subcriber_profile',
//            data:{
//              content :{},
//              test:"vue present"
//            },
//            methods:{
//               getContent: function(_data,_type){
//                 alert(this.reverseBase64AndParseJson(_data));  
//               },
//             reverseBase64AndParseJson:  function (_val) {
//            return  JSON.parse(atob(_val));
//        }
//            }
//        });
(function ($) {
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


    $(document).ready(function () {
        window.vex.defaultOptions.className = 'vex-theme-os'
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        function reverseBase64AndParseJson(_val) {
            return  JSON.parse(atob(_val));
        }
        $(".activate-author-posts").click(function (e) {
            var authorPosts = reverseBase64AndParseJson($(this).attr("data-author-posts"));
            var currentAuthor = $(this).attr("data-current-author");
            var currentUser = $(this).attr("data-current-user");
            var thumbnails = reverseBase64AndParseJson($(this).attr("data-thumbnails"));
            if (authorPosts.length == 0) {
                $(".article-area").html("Author does not yet have a post");
            } else {
                var contentAsString = "";
                $.each(authorPosts,function(_index,_value){
                     var thumbnail = thumbnails[_index] ? thumbnails[_index]:"http://manandpaper.com/wp-content/uploads/2015/11/13707054_1317570784938557_1553403587_n.jpg";
                    var thisDate = new Date(_value.post_date);
                    var dateString = months[thisDate.getMonth()] + thisDate.getDay() + "," + thisDate.getFullYear();
                     contentAsString += '<div class="col-md-4"><div class="news-post ' +
                            'video-post"><div class="thumb-wrap"><img width="1080" ' +
                            'height="720" src="'+thumbnail+'" ' +
                            ' class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" ' +
                            'sizes="(max-width: 1080px) 100vw, 1080px" /></div>' +
                            '<div class="hover-box"><h2></h2/><h2><a class="author-subscription" href="#" data-user="'+currentUser+'" data-author="'+currentAuthor+'">Subscribe</a></h2><h2><a class="author-subscription" href="#" data-user="'+currentUser+'" data-author="'+currentAuthor+'">'+_value.post_title+'</a></h2><ul class="post-tags">' +
                            '<li><i class="fa fa-clock-o"></i>' + dateString + '</li></ul></div></div></div>'; 
                });
                $(".article-area").html(contentAsString).hide().fadeIn();
               
            }

            e.preventDefault();

        });
        $(".news-post.activate-category").click(function (e) {
            var activeCategory = $(this).attr("data-active-category");
            var currentUser = $(this).attr("data-current-user");
            var categoryPosts = reverseBase64AndParseJson($(this).attr("data-category-posts"));
            var thumbnails = reverseBase64AndParseJson($(this).attr("data-thumbnails"));
            if (categoryPosts.length === 0) {
                $(".article-area").html("Sorry Category does not yet have associated post");
            } else {
                $(".article-area").html(categoryPosts);
                var contentAsString = "";
                $.each(categoryPosts, function (_index, _value) {
                    var thumbnail = thumbnails[_index] ? thumbnails[_index]:"http://manandpaper.com/wp-content/uploads/2015/11/13707054_1317570784938557_1553403587_n.jpg";
                    var thisDate = new Date(_value.post_date);
                    var dateString = months[thisDate.getMonth()] + thisDate.getDay() + "," + thisDate.getFullYear();
                    contentAsString += '<div class="col-md-4"><div class="news-post ' +
                            'video-post"><div class="thumb-wrap"><img width="1080" ' +
                            'height="720" src="'+thumbnail+'" ' +
                            ' class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" ' +
                            'sizes="(max-width: 1080px) 100vw, 1080px" /></div>' +
                            '<div class="hover-box"><h2><a class="category-subscription" href="#" data-user="'+currentUser+'" data-category="'+activeCategory+'">Subscribe</a></h2><h2><a class="category-subscription" href="#" data-user="'+currentUser+'" data-category="'+activeCategory+'">'+_value.post_title+'</a></h2><ul class="post-tags">' +
                            '<li><i class="fa fa-clock-o"></i>' + dateString + '</li></ul></div></div></div>';
                });
               $(".article-area").html(contentAsString).hide().fadeIn();
            }

            e.preventDefault();
        });
        $("body").on("click",'.category-subscription',function(event){
             var activeCategory = $(this).attr("data-category");
             var currentUser = $(this).attr("data-user");
             var data = {
			'action': 'subscribe_user',
			'user': currentUser,
                        category: activeCategory,
                        author: '0'
		};
           jQuery.post(ajaxurl, data, function(response) {
			if(response.status){
                            var subscriptionsHtml = "";
                            $.each(response.message,function(_index,_value){
                                subscriptionsHtml += '<div class="owl-item" style="width: 285px; margin-right: 0px;"><div class="item news-post standard-post">';
                                subscriptionsHtml += '<div class="post-gallery"><div class="thumb-wrap">';
                                subscriptionsHtml += '<div class="post-gallery"><div class="thumb-wrap">';
                                subscriptionsHtml += '<img width="150"  height="150" src="'+_value["image"] +'" class="attachment-thumbnail size-thumbnail wp-post-image" alt="">';
                               subscriptionsHtml +=  '<a href="#" class="unsubscribe" data-current-user="'+currentUser+'" data-subscription-id="'+ _value['subscription_Id']+'">Unsubscribe</a>';
                               subscriptionsHtml += '</div><a class="category-post sport" href="#">'+_value["tagname"] +'</a></div><div class="post-content">'; 
                            
                            });
                            
                            $("#subscription-container").html(subscriptionsHtml);
                           return  vex.dialog.alert("Subscription Successful");
                        }
                        else{
                              return  vex.dialog.alert(response.message);
                        }
                        
		});
            event.preventDefault();
        });
        $("body").on("click",'.author-subscription',function(event){
             var author = $(this).attr("data-author");
             var currentUser = $(this).attr("data-user");
             var data = {
			'action': 'subscribe_user',
			'user': currentUser,
                        'author': author,
                        'category':'0'
		};
           jQuery.post(ajaxurl, data, function(response) {
		 jQuery.post(ajaxurl, data, function(response) {
			if(response.status){
                            var subscriptionsHtml = "";
                            $.each(response.message,function(_index,_value){
                                subscriptionsHtml += '<div class="owl-item" style="width: 285px; margin-right: 0px;"><div class="item news-post standard-post">';
                                subscriptionsHtml += '<div class="post-gallery"><div class="thumb-wrap">';
                                subscriptionsHtml += '<div class="post-gallery"><div class="thumb-wrap">';
                                subscriptionsHtml += '<img width="150"  height="150" src="'+_value["image"] +'" class="attachment-thumbnail size-thumbnail wp-post-image" alt="">';
                               subscriptionsHtml +=  '<a href="#" class="unsubscribe" data-current-user="'+currentUser+'" data-subscription-id="'+ _value['subscription_Id']+'">Unsubscribe</a>';
                               subscriptionsHtml += '</div><a class="category-post sport" href="#">'+_value["tagname"] +'</a></div><div class="post-content">'; 
                            
                            });
                            
                            $("#subscription-container").html(subscriptionsHtml);
                           return  vex.dialog.alert("Subscription Successful");
                        }
                        else{
                              return  vex.dialog.alert(response.message);
                        }
                        
		});
		});
            event.preventDefault();
        });
      
        $(".article-section-pagination").hide();


    });


})(jQuery);
