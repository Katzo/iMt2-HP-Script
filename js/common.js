function asubmit(where,url,success) {
	data = Object();
	$(where+" :input").each(function(){
		name = $(this).attr("name");
		if (name)
			data[name] = $(this).val();
	});
	$.ajax({
	  type: 'POST',
	  url: url,
	  data: data,
	  success: success,
	});
}