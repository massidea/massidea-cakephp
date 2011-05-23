function validateField(obj) {
	var dataArray = {};
	dataArray[obj.name] = $(obj).val();
	
	$.ajax({ 
		type: 'POST',
		dataType: 'json',
		data: dataArray,
		url: jsMeta.baseUrl+"/users/ajaxValidateField/",

		success: function(data) {
			appendData(obj, data);
			return true;
		}
	});
	
}

function appendData(obj, data) {
	var parentElement = $(obj).parent();
	var messageBox = $(parentElement).children('.error-message');
	var indicatorBox = $(parentElement).children('.ajax-indicator');
	
	/* If no error-message box exist, create one */
	if(!$(indicatorBox).length) {
		indicatorBox = $('<div class="ajax-indicator"></div>').appendTo($(parentElement));
	}
	if(!$(messageBox).length) {
		messageBox = $('<div class="error-message" style="display: none"></div>').appendTo($(parentElement));
	}
	
	/* If data contains an error message */
	if(data != 1) {
		$(indicatorBox).html('<img src="'+jsMeta.baseUrl+'/img/icon_red_cross.png" />');
		/* If messagebox's contents differ from data */
		if($(messageBox).html() != data) {
			$(messageBox).hide();
			$(messageBox).html(data);
		}
		$(messageBox).fadeIn('slow');
	} else { /* If data is valid */
		$(indicatorBox).html('<img src="'+jsMeta.baseUrl+'/img/icon_green_check.png" />');
		$(messageBox).slideUp();
	}
}

function comparePasswords(obj, obj2) {
	var passwd = $(obj2).val();
	var passwdConfirm = $(obj).val();
	var result = 'Passwords do not match';
	
	if(passwd == passwdConfirm) {
		result = 1;
	}
	
	appendData(obj, result);
}


$(document).ready(function(){
	/* Assing tabindex values to each input textfield */
	
	var inputIndex = 1;
	$('#UserSignupForm').find(':input[type="text"],:input[type="password"]').each(function(e){
		$(this).attr('tabindex', inputIndex++);
		
		if(this.id == 'UserPasswordConfirm') {
			$(this).blur(function(){
				comparePasswords(this, $('#UserPassword'));
			});
		} else {
			$(this).blur(function(){
				validateField(this);
			});
		}
		
	});
	
});
