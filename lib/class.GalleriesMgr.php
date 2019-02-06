<?php
final class GalleriesMgr {
	
	private $oGalleriesModel					= NULL;
	private $oMediasModel					= NULL;
	private $sGalleriesCoverTplName			= 'galleries.cover.tpl';
	private $sGalleryCoverTplName			= 'gallery.cover.tpl';
	private $sArchivedGalleriesCoverTplName	= 'archivedGalleries.cover.tpl';
	private $sGalleryContentsItemTplName		= 'galleries.contents.item.tpl';
	private $sGalleriesCoverTpl				= '';
	private $sGalleryCoverTpl				= '';
	private $sArchivedGalleriesCoverTpl		= '';
	private $sGalleryContentsItemTpl		= '';
	public static $sModuleName				= 'Galleries';
	
	public function __construct() {
		$sTplSrc = ADMIN ? 'backPartsTpl' : 'frontPartsTpl';
		$this->sGalleriesCoverTpl = file_get_contents(
										ModulesMgr::getFilePath(self::$sModuleName, $sTplSrc).
										$this->sGalleriesCoverTplName
									);
		$sGalleryCoverTplName = ADMIN ? $this->sGalleryCoverTplName : $this->sGalleriesCoverTplName;
		$this->sGalleryCoverTpl = file_get_contents(
									ModulesMgr::getFilePath(self::$sModuleName, $sTplSrc).
									$sGalleryCoverTplName
								);
		$this->sArchivedGalleriesCoverTpl = file_get_contents(
									ModulesMgr::getFilePath(self::$sModuleName, 'backPartsTpl').
									$this->sArchivedGalleriesCoverTplName
								);
		
		$this->sGalleryContentsItemTpl = file_get_contents(
											ModulesMgr::getFilePath(self::$sModuleName, $sTplSrc).
											$this->sGalleryContentsItemTplName
										);
		$this->oGalleriesModel = new GalleriesModel();
		$this->oMediasModel = new MediasModel();
	}
	
	public function getAblumIds() {
		return $this->oGalleriesModel->getAblumIds();
	}
	
	private function getMediaProps(array $aMediaIds) {
		$aMedias = $this->oMediasModel->getMediasByIds($aMediaIds);
		$aReturn = array();
		// un seul média
		if(isset($aMedias['elmts'])) {
			foreach($aMedias['elmts'] as $aElmt) {
				$aReturn['media_id'] = $aElmt['media_id'];
				if($aElmt['media_elmt_type_name'] === 'media_description') {
					$aReturn['media_desc'] = $aElmt['media_description_FR'];
				} elseif($aElmt['media_elmt_type_name'] === 'src') {
					$aReturn['media_src'] = $aElmt['src'];
				} else {
					continue;
				}
			}
		// plusieurs médias
		} else {
			foreach($aMedias as $aMedia) {
				foreach($aMedia['elmts'] as $aElmt) {
					if(!isset($aReturn[$aElmt['media_id']])) {
						$aReturn[$aElmt['media_id']] = array('media_id'=>$aElmt['media_id']);
					}
					if($aElmt['media_elmt_type_name'] === 'media_description') {
						$aReturn[$aElmt['media_id']]['media_desc'] = $aElmt['media_description_FR'];
					} elseif($aElmt['media_elmt_type_name'] === 'src') {
						$aReturn[$aElmt['media_id']]['media_src'] = $aElmt['src'];
					} else {
						continue;
					}
				}
			}
		}
		return $aReturn;
	}
	
	public function getGalleryInfos($iGalleryId) {
		$aGallery = $this->oGalleriesModel->getGalleryCover($iGalleryId);
		$aMedia = $this->getMediaProps(array($aGallery[0]['gallery_cover']));
		return array_merge($aGallery[0], $aMedia);
	}
	
	public function getGalleryCover($iGalleryId) {
		$aGallery = $this->oGalleriesModel->getGalleryCover($iGalleryId);
		$aMedia = $this->getMediaProps(array($aGallery[0]['gallery_cover']));
		return str_replace(
						array(
							'{__GALLERY_ID__}',
							'{__GALLERY_COVER__}',
							'{__COVER_ALT__}',
							'{__GALLERY_TITLE__}',
							'{__GALLERY_SIZE__}',
							'{__GALLERY_DESCRIPTION__}'
						), 
						array(
							$aGallery[0]['gallery_id'],
							$aMedia['media_src'],
							$aMedia['media_desc'],
							$aGallery[0]['gallery_title'],
							$this->oGalleriesModel->getGallerySize($iGalleryId),
							$aGallery[0]['gallery_desc']
						), 
						ADMIN ? $this->sGalleryCoverTpl : $this->sGalleriesCoverTpl
					);
	}
	
	public function getAllGalleriesCovers($iActive) {
		$aCovers = array();
		foreach($this->oGalleriesModel->getAllGalleriesCovers($iActive) as $aGallery) {
			$aMedia = $this->getMediaProps(array($aGallery['gallery_cover']));
			$aCovers[] = str_replace(
								array(
									'{__GALLERY_ID__}',
									'{__GALLERY_COVER__}',
									'{__COVER_ALT__}',
									'{__GALLERY_TITLE__}',
									'{__GALLERY_SIZE__}',
									'{__GALLERY_DESCRIPTION__}'
								), 
								array(
									$aGallery['gallery_id'],
									$aMedia['media_src'],
									$aMedia['media_desc'],
									$aGallery['gallery_title'],
									$this->oGalleriesModel->getGallerySize($aGallery['gallery_id']),
									$aGallery['gallery_desc']
								), 
								$iActive === 1 ? $this->sGalleriesCoverTpl : $this->sArchivedGalleriesCoverTpl
							);
		}
		return implode('<hr />', $aCovers);
	}
	
	public function getGalleryContents($iGalleryId) {
		$sItems = '';
		$aMediasIds = $this->oGalleriesModel->getGalleryContents($iGalleryId);
		$aMedias = $this->getMediaProps($aMediasIds);
		foreach($aMedias as $aMedia) {
			$sItems .= str_replace(
							array(
								'{__MEDIA_ID__}',
								'{__MEDIA_SRC__}',
								'{__MEDIA_DESC__}'
							), 
							array(
								$aMedia['media_id'],
								$aMedia['media_src'],
								$aMedia['media_desc']
							), 
							$this->sGalleryContentsItemTpl
						);
		}
		return $sItems;
	}
	
	public function getGalleriesStats() {
		$sUrl = WEB_PATH.SessionLang::getLang().'/galleries/home.html';
		$sActiveGalleries = Toolz_Tpl::getA($sUrl, '{__ACTIVE_GALLERIES__}: '.$this->oGalleriesModel->getGalleriesCount(1));
		$sArchivedGalleries = Toolz_Tpl::getA($sUrl, '{__ARCHIVED_GALLERIES__}: '.$this->oGalleriesModel->getGalleriesCount(0));
		return $sActiveGalleries.' - '.$sArchivedGalleries;
	}
	
	public function createGallery($aGalleryProps) {
		
	}
	
	public function addToGallery($iGalleryId, $iMediaId) {
		if($this->oGalleriesModel->addToGallery($iGalleryId, $iMediaId)) {
            UserRequest::$oAlertBoxMgr->success = SessionCore::getLangObject()->getMsg('galleries', 'SUCCESS_ADD_MEDIA').' id: '.$iMediaId;
			return true;
		} else {
            UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_ADD_MEDIA');
			return false;
		}
	}
	
	public function removeFromGallery($iGalleryId, $iMediaId) {
		if($this->oGalleriesModel->removeFromGallery($iGalleryId, $iMediaId)) {
			UserRequest::$oAlertBoxMgr->success = SessionCore::getLangObject()->getMsg('galleries', 'SUCCESS_REMOVE_MEDIA');
			return true;
		} else {
			UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_REMOVE_MEDIA');
			return false;
		}
	}
	
	public function archiveGallery($iGalleryId) {
		if($this->oGalleriesModel->archiveGallery($iGalleryId)) {
			UserRequest::$oAlertBoxMgr->success = SessionCore::getLangObject()->getMsg('galleries', 'SUCCESS_ARCHIVE_GALLERY');
			return true;
		} else {
			UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_ARCHIVE_GALLERY');
			return false;
		}
	}
	
	public function restoreGallery($iGalleryId) {
		if($this->oGalleriesModel->restoreGallery($iGalleryId)) {
			UserRequest::$oAlertBoxMgr->success = SessionCore::getLangObject()->getMsg('galleries', 'SUCCESS_RESTORE_GALLERY');
			return true;
		} else {
			UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_RESTORE_GALLERY');
			return false;
		}
	}
	
	public function deleteGallery($iGalleryId) {
		
	}
}