
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
	
	
	
	
	
	
	jQuery("#myFormlogin").validationEngine('attach', { 
	
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
	
	
			jQuery("#myFormForgot").validationEngine('attach', { 
			
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
	
	
	
			jQuery("#myFormReset").validationEngine('attach', { 
	
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
	
	
	
	
	jQuery("#add_detail").validationEngine('attach', { 
	
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
	
		jQuery("#myFormContact").validationEngine('attach', { 
	
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
	
	jQuery("#myFormChangepass").validationEngine('attach', { 
	
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
	
	jQuery("#myFormchangeemail").validationEngine('attach', { 
	
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
	jQuery("#myFormchangmobile").validationEngine('attach', { 
	
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
				
			$("#msginfo").click(function () { 
			   $("#msginfo").fadeOut(1000);
			  });
			 setTimeout(function(){  $('#msginfo').fadeOut(1000); }, 5000);
});