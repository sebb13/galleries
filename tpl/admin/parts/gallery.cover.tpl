<div class="row vertical-align">
	<div class="col-md-3 text-center">
		<img class="img-responsive" src="{##WEB_PATH##}Core/modules/Medias/data/medias/img/{__GALLERY_COVER__}" alt="{__COVER_ALT__}" />
	</div><!--
    -->
	<div class="col-md-9">
		<div>
			<h3>{__GALLERY_TITLE__} ({__GALLERY_SIZE__} photos)</h3>
			<p class="text-justify">{__GALLERY_DESCRIPTION__}</p>
		</div>
	</div>
</div>
<div class="row">
	<form action="#" method="POST">
		<div class="col-md-5">
			<fieldset>
				<legend>{__CONTROLS__}</legend>
				<input type="hidden" name="gallery_id" value="{__GALLERY_ID__}" />
				<input type="button" class="btn btn-default btn-md" id="manageGalleriesButton" value="{__MANAGE_GALLERIES__}" />
				<input type="button" class="btn btn-danger btn-md archiveGalleryButton" value="{__ARCHIVE__}" />
				<input type="button" class="btn btn-warning btn-md" id="manageArchivedGalleriesButton" value="{__MANAGE_ARCHIVED_GALLERIES__}" />
			</fieldset>
		</div>
		<div class="col-md-7">
			<fieldset>
				<legend>
					{__ADD_MEDIA__}
					<a href="#" data-toggle="tooltip" data-placement="right" title="{__ADD_MEDIA_TOOLTIP__}">
						<span class="glyphicon glyphicon-question-sign"></span>
					</a>
				</legend>
				<div class="row">
					<div class="col-md-10 form-group">
						<input type="input" class="form-control" name="media_id" />
					</div>
					<div class="col-md-2 text-center">
						<input type="button" class="btn btn-danger" id="addMedia2GalleryButton" value="{__ADD__}" />
					</div>
				</div>
			</fieldset>
			<input type="hidden" name="removeMediaConfirmText" id="removeMediaConfirmText" value="{__CONFIRM_REMOVE_MEDIA__}" />
			<input type="hidden" name="deleteMediaConfirmText" id="deleteMediaConfirmText" value="{__CONFIRM_DELETE_MEDIA__}" />
			<input type="hidden" name="archiveGalleryConfirmText" id="archiveGalleryConfirmText" value="{__CONFIRM_ARCHIVE_GALLERY__}" />
		</div>
	</form>
</div>