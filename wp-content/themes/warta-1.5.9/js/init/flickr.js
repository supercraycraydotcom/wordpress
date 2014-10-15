/*
 * Flickr
 * ======
 */
+function($) { 'use strict';
        $('.flickr-feed').each(function() {
                var $this = $(this);

                new $.FlickrFeed({
                        element : $this, // Your element id to place the photos.
                        items   : $this.data('count'), // How many items do you want to show.
                        id      : $this.data('id'), // A single user ID. This specifies a user to fetch for. eg: '685365@N25'.
                        ids     : $this.data('ids'), // A comma delimited list of user IDs. This specifies a list of users to fetch for.
                        tags    : $this.data('tags'), // A comma delimited list of tags to filter the feed by.
                        tagmode : $this.data('tagmode')  // Control whether items must have ALL the tags (tagmode=all), or ANY (tagmode=any) of the tags. Default is ALL.
                });
        });
}(jQuery);