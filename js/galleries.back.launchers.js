$('#ajaxFrame').on('click', '#manageGalleriesButton', function(){
	var promise = genericRequest({
			app_token: getToken(), 
			content: 'galleries_manager',
			exw_action: 'Galleries::getGalleriesManager',
			active: 1
		}, 'galleries_manager');
	promise.success(function(data) {
		$('#ajaxFrame').html(data);
		setHistoryAndMenu('galleries_manager');
		$('meta[name=app_current_page]').trigger('change');
	});
});
$('#ajaxFrame').on('click', '#manageArchivedGalleriesButton', function(){
	var promise = genericRequest({
			app_token: getToken(), 
			content: 'galleries_manager',
			exw_action: 'Galleries::getGalleriesManager',
			active: 0
		}, 'galleries_manager');
	promise.success(function(data) {
		$('#ajaxFrame').html(data);
		setHistoryAndMenu('galleries_manager');
		$('meta[name=app_current_page]').trigger('change');
	});
});
$('#ajaxFrame').on('click', '.manageGalleryButton', function(){
	var promise = genericRequest({
			app_token: getToken(), 
			content: 'gallery_manager',
			exw_action: 'Galleries::getGalleryManager',
			gallery_id: $(this).prev().val()
		}, 'gallery_manager');
	promise.success(function(data) {
		$('#ajaxFrame').html(data);
		setHistoryAndMenu('gallery_manager');
		$('meta[name=app_current_page]').trigger('change');
	});
});
$('#ajaxFrame').on('click', '.archiveGalleryButton', function(){
	var galleryId = $(this).prev().prev().val();
	var msg = $('input#archiveGalleryConfirmText').val();
	bootbox.confirm(msg, function(result){
		if(result) {
			var promise = genericRequest({
					app_token: getToken(), 
					content: 'galleries_manager',
					exw_action: 'Galleries::archiveGallery',
					gallery_id: galleryId
				});
			promise.success(function(data) {
				$('#ajaxFrame').html(data);
				$('meta[name=app_current_page]').trigger('change');
			});
		}
	});
});
$('#ajaxFrame').on('click', '.restoreGalleryButton', function(){
	var promise = genericRequest({
			app_token: getToken(), 
			content: 'galleries_manager',
			exw_action: 'Galleries::restoreGallery',
			gallery_id: $(this).prev().prev().val()
		});
	promise.success(function(data) {
		$('#ajaxFrame').html(data);
		$('meta[name=app_current_page]').trigger('change');
	});
});
$('#ajaxFrame').on('click', '.deleteGalleryButton', function(){
	var galleryId = $(this).prev().prev().prev().val();
	var msg = $('input#deleteGalleryConfirmText').val();
	bootbox.confirm(msg, function(result){
		if(result) {
			var promise = genericRequest({
					app_token: getToken(), 
					content: 'galleries_manager',
					exw_action: 'Galleries::deleteGallery',
					gallery_id: galleryId
				});
			promise.success(function(data) {
				$('#ajaxFrame').html(data);
				$('meta[name=app_current_page]').trigger('change');
			});
		}
	});
});
$('#ajaxFrame').on('click', '#addMedia2GalleryButton', function(){
	var promise = genericRequest({
			app_token: getToken(), 
			content: 'gallery_manager',
			exw_action: 'Galleries::addMedia',
			media_id: $('input[name=media_id]').val(),
			gallery_id: $('input[name=gallery_id]').val()
		});
	promise.success(function(data) {
		$('#ajaxFrame').html(data);
		$('meta[name=app_current_page]').trigger('change');
	});
});
$('#ajaxFrame').on('click', '.removeMediaButton', function(){
	var mediaId = $(this).prev().prev().val();
	var msg = $('input#removeMediaConfirmText').val();
	bootbox.confirm(msg, function(result){
		if(result) {
			var promise = genericRequest({
					app_token: getToken(), 
					content: 'galleries_manager',
					exw_action: 'Galleries::removeMedia',
					gallery_id: $('input[name=gallery_id]').val(),
					media_id: mediaId
				});
			promise.success(function(data) {
				$('#ajaxFrame').html(data);
				$('meta[name=app_current_page]').trigger('change');
			});
		}
	});
});
$('#ajaxFrame').on('click', '.deleteMediaButton', function(){
	var mediaId = $(this).prev().prev().prev().val();
	var msg = $('input#deleteMediaConfirmText').val();
	bootbox.confirm(msg, function(result){
		if(result) {
			var promise = genericRequest({
					app_token: getToken(), 
					content: 'galleries_manager',
					exw_action: 'Galleries::deleteMedia',
					gallery_id: $('input[name=gallery_id]').val(),
					media_id: mediaId
				});
			promise.success(function(data) {
				$('#ajaxFrame').html(data);
				$('meta[name=app_current_page]').trigger('change');
			});
		}
	});
});