function createBoxElements(obj) {
	var parentElement = $(obj).parent();
	var messageBox = $(parentElement).children('.error-message');
	var indicatorBox = $(parentElement).children('.ajax-indicator');
	
	/* If no error-message box exist, create one */
	if(!$(indicatorBox).length) {
		indicatorBox = $('<div class="ajax-indicator">*</div>').insertAfter($(obj));
	}
	if(!$(messageBox).length) {
		messageBox = $('<div class="error-message" style="display: none"></div>').insertAfter($(indicatorBox));
	}
}

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
	var inputIndex = 1;
	/* Loop through all the input fields in signup form */
	$('#UserSignupForm').find(':input[type!="hidden"]').each(function(e){ 

		/* Bind validation functions to form elements */
		switch(this.id)
		{
			case 'UserUsername':
			case 'UserPassword':
			case 'ProfileHometown':
			case 'UserEmail':
				createBoxElements(this);
				$(this).blur(function(){ validateField(this); });
				break;
			case 'UserPasswordConfirm':
				createBoxElements(this);
				$(this).blur(function(){ comparePasswords(this, $('#UserPassword')); });
				break;
			case 'ProfileStatus':
				createBoxElements(this);
				$(this).change(function(){ validateField(this); });
				break;
		}
		
		/* Assing tabindex values to each input textfield */
		$(this).attr('tabindex', inputIndex++);

	});
	
	/* Bind agreement links to trigger existing links in layout */
	$('#UserSignupForm .terms_link').click(function(event) {
		event.preventDefault();
		$('#terms_link').click();
	});
	$('#UserSignupForm .privacy_link').click(function(event) {
		event.preventDefault();
		$('#privacy_link').click();
	});
});
