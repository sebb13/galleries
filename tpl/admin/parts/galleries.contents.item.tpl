<div class="form-group col-md-3 media-item-form">
	<div class="panel panel-default conf-box">
		<div class="panel-heading">
			<div class="caption">
				<p>id: {__MEDIA_ID__}</p>
				<p>{__MEDIA_DESC__}</p>
			</div>
			<div class="panel-body media-item-contents">
				<div class="thumbnail">
					<a href="{##WEB_PATH##}Core/modules/Medias/data/medias/img/{__MEDIA_SRC__}" class="cbox cboxElement" title="{__MEDIA_DESC__}" alt="{__MEDIA_DESC__}">
						<img src="{##WEB_PATH##}Core/modules/Medias/data/medias/img/thumb/200/{__MEDIA_SRC__}" />
					</a>
				</div>
			</div>
			<div class="panel-footer media-footer-box text-center">
				<form action="" method="POST" class="boxForm">
					<input type="hidden" name="media_{__MEDIA_ID__}" value="{__MEDIA_ID__}" />
					<input type="button" class="btn btn-success btn-xs editMedia" value="{__EDIT__}" />
					<input type="button" class="btn btn-danger btn-xs removeMediaButton" value="{__REMOVE__}" />
					<input type="button" class="btn btn-danger btn-xs deleteMediaButton" value="{__DELETE__}" />
				</form>
			</div>
		</div>
	</div>
</div>