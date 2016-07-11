$(function() {
	$("#search").click(runSearch);
	$('#searchPanel input').keypress(function (e) {
		if (e.which == 13) {
			runSearch();
			return false;
		}
	});
});

function runSearch() {
	$url = "?action=search&includes=" + $("#includes").val() + "&excludes=" + $("#excludes").val() + "&itemType=" + $("input[type='radio'][name='itemType']:checked").val();
	
	$.get($url, function( data ) {
		$("#searchResults").toggle();
		$("#searchForm").toggle();
	
		$("#searchResults").html( data );

		//register the event magic
		$("#allImagesBottom").click(function() { toggleCheckboxes(this.checked) });
		$("#allImagesTop").click(function() { toggleCheckboxes(this.checked) });
		$("#tagItems").click(tagItems);
		$(".cancelSearch").click(displaySearch);
	});
	
	return false;
}

function tagItems() {
	var selectedItems = [];
	$(".imageOption").each(function( index ) {
		if (this.checked) {
			selectedItems.push(this.value);
		}
	});
	
	if (selectedItems.length == 0) {
		alert("Select an item to tag!");
		return false;
	}
	
	var data = { 
		itemIds: selectedItems,
		itemType: $("#itemType").val(),
		tagId: $("#tags").val(),
	};
	
	var request = $.ajax({
		type: "POST",
		url: "#",
		data: data,
	});
	
	request.done(function() {
		$("#actionMessage").html( '<h2 class="messagebox">Tagging of ' + selectedItems.length + ' items successful!</h2>' );
	});
	request.fail(function() {
		$("#actionMessage").html( '<h2 class="errorbox">Tagging of ' + selectedItems.length + ' items FAILED!</h2>' );
	});
	request.always(function() {
		displaySearch();
	});

	return false;
}

function displaySearch() {
	$("#searchResults").toggle();
	$("#searchForm").toggle();
}

function toggleCheckboxes(selectAll) {
	$(".imageCheckbox").each(function( index ) {
		this.checked = selectAll;
	});
}