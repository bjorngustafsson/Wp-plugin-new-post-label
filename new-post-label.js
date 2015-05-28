jQuery(document).ready(function($){
	/*move the new post label to direct after its article element*/
   $(".new-post-label").each(function() {
	  $(this).closest("article").prepend(this);
	});
});