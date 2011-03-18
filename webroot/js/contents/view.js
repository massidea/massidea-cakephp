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
	var expandButton = $("#related-"+type+" > h2:first > .icon");
	if ($(target).is(':hidden')){
		$(expandButton).attr("src", jsMeta.baseUrl+"/img/icon_plus_tiny.png");
	} else {
		$(expandButton).attr("src", jsMeta.baseUrl+"/img/icon_minus_tiny.png");
	}
}

function searchPossibleLinks(formData) {
	$.ajax({ 
		type: 'POST',
		dataType: 'json',
		data: formData,
		url: jsMeta.baseUrl+"/contents/linksearch/",
		success: function(data) {
			sendDataToLinkList(data);
			return true;
		}
	});
	return false;
}

function renderResults(contentId,data) {
	var output = '';
	$.each(data,function(){
		output = output+ '\
		<li class="border-'+this.class+' shrinkFontMore">\
			<a class="left" href='+jsMeta.baseUrl+'/contents/view/'+this.id+'>\
				<img alt="" src="'+jsMeta.baseUrl+'/img/icon_eye.png">\
			</a>\
			<a class="left linked-title hoverLink" href="#">\
				<input type="hidden" class="content_id_link_from" value="'+contentId+'">\
				<input type="hidden" class="content_id_link_to" value="'+this.id+'">'+this.title+'\
			</a>\
		<div class="clear"></div>\
		</li>';
	});
	return output;
}

function searchFromData(searchquery,data,options) {
	var returns = [];
console.debug(searchquery);
	$.each(data,function(){
		if(this.title.indexOf(searchquery) > -1 || searchquery.length == 0){
			if(this.class == 'challenge' && options[0].checked) {
				returns.push(this);
			} else if(this.class == 'idea' && options[1].checked) {
				returns.push(this);
			} else if(this.class == 'vision' && options[2].checked) {
				returns.push(this);
			}
		}
	});
	return returns;
}

function sendDataToLinkList(data) {
	
	var ul = $("#add_new_link > .add_new_link_list > ul");
	var elements = new Array();
	var thisContentId = $("#ContentsLinkForm > #ContentId").val();
	
	if(data.length === 0) {
		output = '<li>No contents found</li>';
		$(ul).html(output);
	} else {
		$(ul).html(renderResults(thisContentId,data));
	}
	
	$("#ContentsLinkForm > div.input > input, #LinkSearchOptionsViewForm > input:checkbox").live('keyup change', function(){
		var options = $("#LinkSearchOptionsViewForm > input:checkbox");
		var results = searchFromData($("#ContentsLinkForm > div.input > input").val(),data,options);
		
		output = renderResults(thisContentId,results);
		if(results.length === 0) {
			output = '<li>No contents found</li>';
		}
		$(ul).html(output);
	});
	

}

$(document).ready(function(){
	
	var types = ['author','content','campaigns'];
	$.each(types,function(index,type){
		var expandButton = $("#related-"+type+" > h2:first");
		$(expandButton).bind('click', function (){ expandCollapse(type); }); 
	});
	
	$("#add_new_link").dialog({
		closeOnEscape: true,
		draggable: false,
		modal: true,
		resizable: false,
		width: 630,
		title: 'Add new link to content',
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	
	var linkedsFetched = false;
	$("#linked-addnewlink-link").click(function(){
		$("#add_new_link").dialog("open");
		if(!linkedsFetched) {
			$("#ContentsLinkForm").submit();
			linkedsFetched = true;
		}
	});
	
	$("#content-tabs").tabs();
	$("#linked").tabs({
			show: function(event,ui) {
				if(ui.index === 0) {
					$("#linked-all").hide();
					$("#linked-challenges").removeClass("ui-tabs-hide");
					$("#linked-ideas").removeClass("ui-tabs-hide");
					$("#linked-visions").removeClass("ui-tabs-hide");
				}
			},
			select: function(event,ui) {
				if(ui.index === 4) {
					return false;
				}
			}
	});
	
	$("#ContentsLinkForm").submit(function(){
		searchPossibleLinks($(this).serializeArray());
		return false;
	});

	
});

