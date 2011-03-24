function expandCollapse(name,launcher,target) {
	$(launcher).unbind('click');
	$(target).slideToggle('fast', function() {
		saveToCookie('contentsView', 'expandStatus', name, $(target).is(':hidden') ? 'none' : 'block');
		$(launcher).bind('click', function () { expandCollapse(name,launcher,target); }); 
		setImage(launcher,target);
	});
}

function setImage(launcher,target) {
	var expandButton = $(launcher).children(".icon");
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
		url: jsMeta.baseUrl+"/linked_contents/contentlinksearch/",
		success: function(data) {
			sendDataToLinkList(data);
			return true;
		}
	});
	return false;
}

function searchFromData(searchquery,data) {
	var returns = [];
	var options = $("#LinkSearchOptionsViewForm > input:checkbox");
	$.each(data,function(){
		if(this.title.indexOf(searchquery) > -1 || searchquery.length == 0){
			if(this['class'] == 'challenge' && options[0].checked) {
				returns.push(this);
			} else if(this['class'] == 'idea' && options[1].checked) {
				returns.push(this);
			} else if(this['class'] == 'vision' && options[2].checked) {
				returns.push(this);
			}
		}
	});
	return returns;
}

function getLinkedOutput(data) {
	var results = searchFromData($("#ContentsLinkForm > div.input > input").val(),data);
	var thisContentId = $("#ContentsLinkForm > #ContentId").val();
	if(results.length === 0) {
		output = '<li>No contents found</li>';
	} else {
		var output = renderResults(thisContentId,results);
	}
	return output;
}

function sendDataToLinkList(data) {
	
	var ul = $("#add_new_link > .add_new_link_list > ul");
	var output = '';
	
	$("#ContentsLinkForm > div.input > input, #LinkSearchOptionsViewForm > input:checkbox").live('keyup change', function(){
		output = getLinkedOutput(data);
		$(ul).html(output);
	});
	
	if(data.length === 0) {
		output = '<li>No contents found</li>';
		$(ul).html(output);
	} else {
		output = getLinkedOutput(data);	
		$(ul).html(output);
	}
}

function addContentToList(data) {
	
}

function linkContents(formData) {

	$.ajax({ 
		type: 'POST',
		data: formData,
		url: jsMeta.baseUrl+"/linked_contents/link/",
		success: function(data) {
			if(data) {
				resetFlash();
				setFlash("Contents linked together successfully",'successfull');
				showFlash();
				$("#ContentsLinkForm").submit();
				addContentToList(data);
				return true;
			} else {
				return false;
			}
		}
	});
}

function flagContent(formData) {
	$.ajax({ 
		type: 'POST',
		data: formData,
		url: jsMeta.baseUrl+"/flags/add/",
		success: function(data) {
			if(data == "1") {
				resetFlash();
				setFlash("Content was flagged successfully",'successfull');
				showFlash();
				return true;
			} else {
				return false;
			}
		}
	});
}

function renderResults(contentId,data) {
	var output = '';
	$.each(data,function(){
		output = output+ '\
		<li class="border-'+this['class']+' shrinkFontMore">\
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

$(document).ready(function(){
		
	$("#linked-container > h3").click(function(){
		expandCollapse('linked',$(this),$("#linked-container > ul"));
	});
	
	
	$("#add_new_link").dialog({
		closeOnEscape: true,
		draggable: true,
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
		return false;
	});
	
	
	$("#ContentsLinkForm").submit(function(){
		searchPossibleLinks($(this).serializeArray());
		return false;
	});
	
	$(".add_new_link_list > ul > li > .linked-title").live('click',function(){
		
		var linkData = {from:	$(this).children('.content_id_link_from').val(),
						to:		$(this).children('.content_id_link_to').val()
						};
		
		$("#add_new_link > .add_new_link_list > ul").html(loading);
		linkContents(linkData);
		return false;
	});
	
	
	$("#flagAddForm > a").click(function(){
		$("#flagAddForm").submit();
		return false;
	});
	
	$("#flagAddForm").submit(function(){
		flagContent($(this).serializeArray());
		return false;
	});
	
	$("#related-info").tabs({
		selected: -1,
		collapsible: true

	});

	
});

