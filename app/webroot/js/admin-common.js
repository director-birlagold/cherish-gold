// JavaScript Document
//Uniform js apply input,textbox,selectbox and button
$(function(){
	$("input, textarea, select, button").uniform();
});

//Jquery validataion engine
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#myForm").validationEngine('attach', { 
	
		autoHidePrompt:true,
		autoHideDelay:3000,
		onValidationComplete: function(form, status){
			if (status == true) {           
				jQuery('.helpfade').show();
				jQuery('.helptips').show();
				var id = $('.ckeditor').attr('id');
				if(typeof id !='undefined'){
					var editorcontent = CKEDITOR.instances[id].getData().replace(/<[^>]*>/gi, '');
					if (editorcontent.length<=10){
						jQuery('.helpfade').hide();
						jQuery('.helptips').hide();
						message("This field is required, Please give minimum 10 characters in the field of "+id);
						return false;
					}
				}
				form.validationEngine('detach');
				form.submit();
			}
		}
	});
	jQuery("#myForm_static").validationEngine('attach', { 	
		autoHidePrompt:true,
		autoHideDelay:3000,
		onValidationComplete: function(form, status){
			if (status == true) {           
				jQuery('.helpfade').show();
				jQuery('.helptips').show();
				var id = $('.ckeditor').attr('id');
				if(typeof id !='undefined'){
					var editorcontent = CKEDITOR.instances[id].getData().replace(/<[^>]*>/gi, '');
					/*if (editorcontent.length<=10){
						jQuery('.helpfade').hide();
						jQuery('.helptips').hide();
						message("This field is required, Please give minimum 10 characters in the field of "+id);
						return false;
					}*/
				}
				form.validationEngine('detach');
				form.submit();
			}
		}
	});
	jQuery("#myForm1").validationEngine('attach', { 
	
		autoHidePrompt:true,
		autoHideDelay:3000,
		onValidationComplete: function(form, status){
			if (status == true) {           
				jQuery('.helpfade').show();
				jQuery('.helptips').show();
				var id = $('.ckeditor').attr('id');
				if(typeof id !='undefined'){
					var editorcontent = CKEDITOR.instances[id].getData().replace(/<[^>]*>/gi, '');
					if (editorcontent.length<=10){
						jQuery('.helpfade').hide();
						jQuery('.helptips').hide();
						message("This field is required, Please give minimum 10 characters in the field of "+id);
						return false;
					}
				}
				form.validationEngine('detach');
				form.submit();
			}
		}
	});
	
	$('#checkAllAuto').live('click',function(evt){
		if($(this).is(':checked')){
			$('input[type=checkbox]').attr('checked', 'checked');
			$('.checker span').attr('class','checked');
			$('.gtable tbody tr').find('td').attr('class','extra');
		}
		else{
			$('input[type=checkbox]').removeAttr('checked');
			$('.checker span').removeAttr('class');
			$('.gtable tbody tr').find('td').removeAttr('class');
		}
	});	
	
	$("#msginfo").click(function () {	
		$("#msginfo").fadeOut(1000);
	});
	setTimeout(function(){  $('#msginfo').fadeOut(1000); }, 5000); 
	
	$(".editfancyboxes").fancybox({	
		'width'				: '6',
		'height'			: '4',
		'autoScale'			: false,
		'transitionIn'		: 'fade',
		'transitionOut'		: 'fade',
		'changeFade'		: 'slow',
		'type'				: 'iframe',
		'speedIn'           : 1000,
		'speedOut'          : 1000, 
		'centerOnScroll'	: true
	});
	$('#action_btn').click(function(){
		var mg = $('#button').val();
		
		if($("input[rel=action]:checked").length>0){	
			var result = $.confirm({
				'title'		: 'Confirmation',
				'message'	: 'You are about to Delete this item! Continue?',
				'buttons'	: {
					'Yes'	: {
						'class'	: 'blue',
						'action': function(){
							$('#myForm').submit();
						}
					},
					'No'	: {
						'class'	: 'gray',
						'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
					}
				}
			});
			if(!result)		
			return false;
		}
	});
	
	
	$('.confirdel').click(function(evt){
		var action = $(this).parents('a').attr('href');
		
		var result = $.confirm({
			'title'		: 'Delete Confirmation',
			'message'	: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'blue',
					'action': function(){
						window.location = action;
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
		if(!result)		
		return false;
	});
	
	$('.confirdel1').click(function(evt){
		var rel= $(this).attr('rel');
		var action = $(this).attr('href');
		var result = $.confirm({
			'title'		: rel+' Confirmation',
			'message'	: 'You are about to '+rel+' this item.  Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'blue',
					'action': function(){
						window.location = action;
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
		if(!result)		
		return false;
	});
});

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

function intnumbers(myfield, e, dec)
{
 var key;
 var keychar;
 
 if (window.event)
    key = window.event.keyCode;
 else if (e)
    key = e.which;
 else
    return true;
 keychar = String.fromCharCode(key);
 
 // control keys
 if ((key==null) || (key==0) || (key==8) || 
  (key==9) || (key==13) || (key==27) )
    return true;
 
 // numbers
 else if ((("0123456789").indexOf(keychar) > -1))
    return true;
 else
    return false;
}
function floatnumbers(myfield, e, dec)
{
 var key;
 var keychar;
 
 if (window.event)
    key = window.event.keyCode;
 else if (e)
    key = e.which;
 else
    return true;
 keychar = String.fromCharCode(key);
 
 // control keys
 if ((key==null) || (key==0) || (key==8) || 
  (key==9) || (key==13) || (key==27) || key ==46 )
    return true;
 
 // numbers
 else if ((("0123456789").indexOf(keychar) > -1))
    return true;
 else
    return false;
}