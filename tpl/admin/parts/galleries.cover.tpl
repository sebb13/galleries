<div class="row vertical-align">
	<div class="col-md-3 text-center">
		<img class="img-responsive" src="{##WEB_PATH##}Core/modules/Medias/data/medias/img/{__GALLERY_COVER__}" alt="{__COVER_ALT__}" />
	</div><!--
    -->
	<div class="col-md-9">
		<div>
			<h3>{__GALLERY_TITLE__} ({__GALLERY_SIZE__} photos)</h3>
			<p class="text-justify">{__GALLERY_DESCRIPTION__}</p>
			<fieldset>
				<legend>{__CONTROLS__}</legend>
				<input type="hidden" name="gallery_id" id="gallery_{__GALLERY_ID__}" value="{__GALLERY_ID__}" />
				<input type="button" class="btn btn-success btn-sm manageGalleryButton" value="{__MANAGE_GALLERY__}" />
				<input type="button" class="btn btn-danger btn-sm archiveGalleryButton" value="{__ARCHIVE__}" />
			</fieldset>
		</div>
	</div>
</div>