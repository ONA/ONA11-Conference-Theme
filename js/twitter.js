function ona11_load_tweets( ona11_twitter_url, ona_twitter_more_text ) {
	
	jQuery.getJSON(ona11_twitter_url, function(data){
		jQuery.each(data.results, function(i, item) {
			jQuery("#ttweets").append('<div class="tweet"><img width="48px" height="48px" class="float-left" src="' + item["profile_image_url"] + '" /><strong>@<a href="http://twitter.com/' + item["from_user"] + '">' + item["from_user"] + "</a></strong>: " + item.text.replace(/(http\:\/\/[A-Za-z0-9\/\.\?\=\-]*)/g,'<a href="$1">$1</a>').replace(/@([A-Za-z0-9\/_]*)/g,'<a href="http://twitter.com/$1">@$1</a>').replace(/#([A-Za-z0-9\/\.]*)/g,'<a href="http://twitter.com/search?q=$1">#$1</a>') + "<div class='timestamp'><em>" + relative_time(item.created_at) + "</em></div></div>");
			jQuery("p#tmore").html( ona_twitter_more_text );
		});
    });

}
	
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