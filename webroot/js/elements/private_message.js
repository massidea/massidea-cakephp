function updateTips(t) {
	tips.text(t).addClass("ui-state-highlight");
	setTimeout(function() {
		tips.removeClass("ui-state-highlight", 1500);
	}, 500 );
}


function checkLength(o, n, min, max) {
	if (o.val().length > max || o.val().length < min) {
		o.addClass("ui-state-error");
		updateTips("Length of " + n + " must be between " +
			min + " and " + max + ".");
		return false;
	} else {
		return true;
	}
}


function initSendPrivateMessageDialog() {
	var name = $("#name");
	var allFields = $( [] ).add( name );
	var tips = $(".validateTips");

	
	$("#send_private_message").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Create an account": function() {
				var bValid = true;
				
				allFields.removeClass("ui-state-error");
				bValid = bValid && checkLength( name, "username", 1, 16 );

				if (bValid) {
					name.val(); 
					$(this).dialog("close");
				}
			},
			Cancel: function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			allFields.val("").removeClass("ui-state-error");
		}
	});

}

$(document).ready(function(){
	initSendPrivateMessageDialog();
	
	$(".send-message").click(function() {
		console.debug(this.id);
		$("#send_private_message").dialog("open");
	});
	
});