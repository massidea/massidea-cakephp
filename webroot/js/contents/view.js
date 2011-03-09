function expandCollapse(type) {
	var target = $("#related-"+type+" > div");
	var expandButton = $("#related-"+type+" > h2:first");
	$(expandButton).unbind('click');
	$(target).slideToggle('fast', function() {
		saveToCookie('contentsView', 'expandStatus', type, $(target).is(':hidden') ? 'none' : 'block');
		$(expandButton).bind('click', function () { expandCollapse(type); }); 
		setImage(type);
	});
}

function setImage(type) {
	var target = $("#related-"+type+" > div");
	var expandButton = $("#related-"+type+" > h2:first > .icon_plusminus");
	if ($(target).is(':hidden')){
		$(expandButton).attr("src", jsMeta.baseUrl+"/img/icon_plus_tiny.png");
	} else {
		$(expandButton).attr("src", jsMeta.baseUrl+"/img/icon_minus_tiny.png");
	}
}

$(document).ready(function(){
	
	var types = ['author','content','campaigns'];
	$.each(types,function(index,type){
		var expandButton = $("#related-"+type+" > h2:first");
		$(expandButton).bind('click', function (){ expandCollapse(type); }); 
	});
	
});

