$('ul.first').bsPhotoGallery({
	classes : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
	hasModal : true
});
$('meta[name=app_current_page]').change(function(){
	$('ul.first').bsPhotoGallery({
		classes : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
		hasModal : true
	});
});
$('#ajaxFrame').on('click', '.gallery-link', function(){
	$('body').css({'cursor':'wait'});
	var galleryId = $(this).attr('id').replace('gallery_', '');
	var target = $(this).next('.gallery-contents');
	if($(target).is(':visible')) {
		$(target).slideUp('slow', function(){
			$(target).html('');
		});
		$(target).removeClass('currentGallery');
	} else {
		if($('.currentGallery').is(':visible')) {
			$('.currentGallery').slideUp(1, function(){
				$(target).html('');
				$('.currentGallery').html('');
				var promise = genericRequest({
						app_token: getToken(), 
						content: 'galleries',
						exw_action: 'Galleries::getGalleryContents',
						gallery_id: galleryId
					});
				promise.success(function(data) {
					var aTag = $("a[name='"+ 'gallery_'+galleryId+"']");
					$('html,body').animate({scrollTop: aTag.offset().top-40},'slow', function() {
						$(target).html(data);
						$(target).slideDown('slow');
						$('.currentGallery').removeClass('currentGallery');
						$(target).addClass('currentGallery');
						$('ul.first').bsPhotoGallery({
							classes : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
							hasModal : true
						});
					});
				});
			});
		} else {
			var promise = genericRequest({
					app_token: getToken(), 
					content: 'galleries',
					exw_action: 'Galleries::getGalleryContents',
					gallery_id: galleryId
				});
			promise.success(function(data) {
				var aTag = $("a[name='"+ 'gallery_'+galleryId+"']");
				$('html,body').animate({scrollTop: aTag.offset().top-40},'slow', function() {
					$(target).html(data);
					$(target).slideDown('slow');
					$(target).addClass('currentGallery');
					$('ul.first').bsPhotoGallery({
						classes : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
						hasModal : true
					});
				});
			});
		}
		$('body').css({'cursor':'default'});
	}
});