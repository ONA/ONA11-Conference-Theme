jQuery(document).ready( function() {
	
		var url = "http://twitter.com/status/user_timeline/ONAConf.json?count=3&callback=?";
		jQuery.getJSON(url,
        function(data){
			jQuery.each(data, function(i, item) {
				jQuery("img#tprofile").attr("src", item.user["profile_image_url"]);
				jQuery("h2#tname").html('<a href="http://twitter.com/' + item.user["screen_name"] + '">@' + item.user["screen_name"]);
				jQuery("h3#tname").text(item.user["name"]);
				jQuery("#ttweets").append('<p><strong>@' + item.user["screen_name"] + "</strong>: " + item.text.replace(/(http\:\/\/[A-Za-z0-9\/\.\?\=\-]*)/g,'<a href="$1">$1</a>').replace(/@([A-Za-z0-9\/_]*)/g,'<a href="http://twitter.com/$1">@$1</a>').replace(/#([A-Za-z0-9\/\.]*)/g,'<a href="http://twitter.com/search?q=$1">#$1</a>') + "<br><i>" + relative_time(item.created_at) + "</i></p>");
				jQuery("p#tmore").html('<a href="http://twitter.com/' + item.user["screen_name"] + '"><strong>More Twitter messages &#0187;</strong></a>');
			});
        });
	});
 
 
  function relative_time(time_value) {
	  var values = time_value.split(" ");
	  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	  var parsed_date = Date.parse(time_value);
	  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	  delta = delta + (relative_to.getTimezoneOffset() * 60);
	  
	  var r = '';
	  if (delta < 60) {
	    r = 'a minute ago';
	  } else if(delta < 120) {
	    r = 'a couple of minutes ago';
	  } else if(delta < (45*60)) {
	    r = (parseInt(delta / 60)).toString() + ' minutes ago';
	  } else if(delta < (90*60)) {
	    r = 'an hour ago';
	  } else if(delta < (24*60*60)) {
	    r = '' + (parseInt(delta / 3600)).toString() + ' hours ago';
	  } else if(delta < (48*60*60)) {
	    r = '1 day ago';
	  } else {
	    r = (parseInt(delta / 86400)).toString() + ' days ago';
	  }
	  
	  return r;
}
function twitter_callback ()
{
	return true;
}