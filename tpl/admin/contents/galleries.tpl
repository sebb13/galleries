<div class="row">
    <div class="col-md-12">
        <form method="POST" action="">
			<fieldset>
				<legend>{__MANAGE_GALLERIES__}</legend>
				<div class="row form-group">
					<div class="col-md-6">
						<input type="button" class="btn btn-default btn-md" id="manageGalleriesButton" value="{__MANAGE_GALLERIES__}" />
					</div>
					<div class="col-md-6">
						<input type="button" class="btn btn-warning btn-md" id="manageArchivedGalleriesButton" value="{__MANAGE_ARCHIVED_GALLERIES__}" />
					</div>
				</div>
			</fieldset>
		</form>
    </div>
</div>
<hr />
<form action="#" method="POST">
	<input type="hidden" name="archiveGalleryConfirmText" id="archiveGalleryConfirmText" value="{__CONFIRM_ARCHIVE_GALLERY__}" />
	<input type="hidden" name="deleteGalleryConfirmText" id="archiveGalleryConfirmText" value="{__CONFIRM_DELETE_GALLERY__}" />
	{__GALLERIES__}
</form>