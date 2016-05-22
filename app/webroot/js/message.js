function message(msg){
	var msg = msg.split(',');
	var result = $.confirm({
		'title'		: msg[0],
		'message'	: msg[1],
		'buttons'	: {
			'Close'	: {
				'class'	: 'close',
				'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
			}
		}
	});
	if(!result)		
	return false;
}