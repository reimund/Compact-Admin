var $ = jQuery.noConflict();

$(document).ready(function() {
	// Replace all leading em dashes from the post/page titles with plain whitespace.
	$('table.pages td.page-title a.row-title').each(function() {
		// The post or page title.
		var t = $(this).text();

		// The indent string to replace.
		var r = '— ';

		// Will hold the index of the start of the title.
		var i;

		for (i = 0; i < t.length / r.length; i++) {
			if (t.substr(i * r.length, r.length) != r)
				break;
		}

		var style = 'margin-left: ' + (i * 25) + 'px;';

		$(this).html('<span style="' + style + '">' + t.substr(i * r.length) + '</span>');
	});
});