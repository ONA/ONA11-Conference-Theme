jQuery(document).ready(function(){
	
	jQuery('select.term-selector').selectList({
		sort: true
	});
	
	jQuery('input.ona11-date-picker').datepicker({
		changeMonth: true,
		changeYear: true,
	});
	
	jQuery('input.ona11-time-picker').timepicker({
		ampm: true,
		hour: 17,
		timeFormat: 'h:mm TT',
		hourGrid: 4,
		minuteGrid: 10,
	});
	
	jQuery('input#ona11-all-day-session').click(function(){
		if ( jQuery(this).attr('checked') ) {
			jQuery('.pick-time').addClass('display-none');
		} else {
			jQuery('.pick-time').removeClass('display-none');
		}
	});
	
});