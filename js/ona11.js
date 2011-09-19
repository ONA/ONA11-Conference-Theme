jQuery(document).ready(function(){
	
	jQuery('.clickable-date').click(function(){
		if ( jQuery('.full-date', this).is(':hidden') ) {
			jQuery('.full-date', this).show();
			jQuery('.readable-date', this).hide();			
		} else if ( jQuery('.readable-date', this).is(':hidden') ) {
			jQuery('.readable-date', this).show();
			jQuery('.full-date', this).hide();			
		}
	});
});