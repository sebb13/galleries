<?php
final class Galleries extends CoreCommon {
	
	private $oGalleriesMgr = NULL;
	
	public function __construct() {
		parent::__construct();
		$this->oGalleriesMgr = new GalleriesMgr();
	}
	
	public function getDashboard() {
		return $this->oTplMgr->buildSimpleCacheTpl(
												Dashboard::getDashboard('{__GALLERIES__}', $this->oGalleriesMgr->getGalleriesStats()), 
												ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'galleries.xml'
											);
	}
	
	public function getHomePage() {
		$sTplPath = ModulesMgr::getFilePath(__CLASS__, 'backContentsTpl').'home.tpl';
		$oConfig = new Config(__CLASS__);
		$sConfInterface = $oConfig->getConfInterface(__CLASS__, __METHOD__);
		unset($oConfig);
		$sContent = str_replace(
						array(
							'{__SEARCH_GALLERIES_FORM__}',
							'{__GALLERIES_STATS__}',
							'{__CONFIG__}'
						), 
						array(
							'',
							$this->oGalleriesMgr->getGalleriesStats(),
							$sConfInterface
						), 
						file_get_contents($sTplPath)
					);
		return array(
				'content' => $this->oTplMgr->buildSimpleCacheTpl(
															$sContent, 
															ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'galleries.xml'
														),
				'sPage'	=> 'galleries_home'
			);
	}
	
	public function getGalleriesManager() {
		if(UserRequest::getParams('active') === false) {
			UserRequest::setParams('active', 1);
		}
		$sContents = str_replace(
							array(
								'{__PAGE_TITLE__}',
								'{__GALLERIES__}'
							),
							array(
								'Galeries',
								$this->oGalleriesMgr->getAllGalleriesCovers((int)UserRequest::getParams('active')), 
							),
							file_get_contents(ModulesMgr::getFilePath(__CLASS__, 'backContentsTpl').'galleries.tpl')
						);
		return array(
			'content' => $this->oTplMgr->buildSimpleCacheTpl(
														$sContents, 
														ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'galleries.xml'
													),
			'sPage'	=> 'galleries_manager'
		);
	}
	
	public function getGalleryManager() {
		if(UserRequest::getParams('gallery_id') === false) {
			UserRequest::setParams('gallery_id', SessionNav::get('gallery_id'));
		} else {
			SessionNav::set('gallery_id', UserRequest::getParams('gallery_id'));
		}
		$sContents = str_replace(
							array(
								'{__COVER__}',
								'{__GALLERY__}'
							),
							array(
								$this->oGalleriesMgr->getGalleryCover(UserRequest::getParams('gallery_id')), 
								$this->oGalleriesMgr->getGalleryContents(UserRequest::getParams('gallery_id'))
							),
							file_get_contents(ModulesMgr::getFilePath(__CLASS__, 'backContentsTpl').'manager.tpl')
						);
		return array(
			'content' => $this->oTplMgr->buildSimpleCacheTpl(
														$sContents, 
														ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'galleries.xml'
													),
			'sPage'	=> 'gallery_manager'
		);
	}
	
	public function getFrontPage() {
		$this->updateGalleries();
		$sContents = str_replace(
							array(
								'{__PAGE_TITLE__}',
								'{__GALLERIES__}'
							),
							array(
								'Galeries',
								$this->oGalleriesMgr->getAllGalleriesCovers(1), 
							),
							file_get_contents(ModulesMgr::getFilePath(__CLASS__, 'frontContentsTpl').'galleries.tpl')
						);
		return array(
			'content' => $this->oTplMgr->buildSimpleCacheTpl(
														$sContents, 
														ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'mediaGalleries.xml'
													),
			'sPage'	=> 'galleries'
		);
	}
	
	public function getGalleryPage() {
		if(UserRequest::getRequest('gallery_id') !== false) {
			UserRequest::setParams('gallery_id', UserRequest::getRequest('gallery_id'));
		}
		if(UserRequest::getParams('gallery_id') === false) {
			UserRequest::setParams('gallery_id', 1);
		}
		$sContents = str_replace(
								array(
									'{__PAGE_TITLE__}',
									'{__GALLERIES__}'
								),
								array(
									'',
									$this->oGalleriesMgr->getGalleryCover(UserRequest::getParams('gallery_id')),
								),
								file_get_contents(ModulesMgr::getFilePath(__CLASS__, 'frontContentsTpl').'galleries.tpl')
							);
		$sContents .= str_replace(
							'{__CONTENTS__}', 
							$this->oGalleriesMgr->getGalleryContents(UserRequest::getParams('gallery_id')), 
							file_get_contents(ModulesMgr::getFilePath(__CLASS__, 'frontPartsTpl').'galleries.contents.tpl')
						);
		UserRequest::setRequest(array('sPage'=>'galleries', 'sLang'=>UserRequest::getLang()));
		return array(
			'content' => $this->oTplMgr->buildSimpleCacheTpl(
														$sContents, 
														ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'Galleries.xml'
													),
			'sPage'	=> 'galleries'
		);
	}
	
	public function getGalleryContents() {
		if(UserRequest::getParams('gallery_id') === false) {
			UserRequest::setParams('gallery_id', 1);
		}
		$sContents = $this->oTplMgr->buildSimpleCacheTpl(
													str_replace(
														'{__CONTENTS__}', 
														$this->oGalleriesMgr->getGalleryContents(UserRequest::getParams('gallery_id')), 
														file_get_contents(ModulesMgr::getFilePath(__CLASS__, 'frontPartsTpl').'galleries.contents.tpl')
													), 
													ModulesMgr::getFilePath(__CLASS__, 'backLocales', $this->oLang->LOCALE).'Galleries.xml'
												);
		die($sContents);
	}
	
	public function createGallery() {
		
	}
	
	public function archiveGallery() {
		$this->oGalleriesMgr->archiveGallery(UserRequest::getParams('gallery_id'));
		return $this->getGalleriesManager();
	}
	
	public function restoreGallery() {
		$this->oGalleriesMgr->restoreGallery(UserRequest::getParams('gallery_id'));
		return $this->getGalleriesManager();
	}
	
	public function deleteGallery() {
		
	}
	
	public function addMedia() {
		if(UserRequest::getParams('media_id') === false) {
            UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_ADD_MEDIA');
		} else {
			if(strpos(UserRequest::getParams('media_id'), ',')) {
				foreach(explode(',', UserRequest::getParams('media_id')) as $sMediaId) {
					$this->oGalleriesMgr->addToGallery(
											(int)trim(UserRequest::getParams('gallery_id')), 
											(int)trim($sMediaId)
										);
				}
			} else {
				$this->oGalleriesMgr->addToGallery(
										(int)trim(UserRequest::getParams('gallery_id')), 
										(int)trim(UserRequest::getParams('media_id'))
									);
			}
		}
		return $this->getGalleryManager();
	}
	
	public function removeMedia() {
		if(UserRequest::getParams('media_id') === false) {
            UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_ADD_MEDIA');
		} else {
			$this->oGalleriesMgr->removeFromGallery(
											(int)trim(UserRequest::getParams('gallery_id')), 
											(int)trim(UserRequest::getParams('media_id'))
										);
		}
		return $this->getGalleryManager();
	}
	
	public function deleteMedia() {
		if(UserRequest::getParams('media_id') === false) {
            UserRequest::$oAlertBoxMgr->danger = SessionCore::getLangObject()->getMsg('galleries', 'ERROR_ADD_MEDIA');
		} else {
			$this->oGalleriesMgr->removeFromGallery(
											(int)trim(UserRequest::getParams('gallery_id')), 
											(int)trim(UserRequest::getParams('media_id'))
										);
			$oMediaMgr = new MediasMgr();
			$oMediaMgr->deleteMedia((int)trim(UserRequest::getParams('media_id')));
			unset($oMediaMgr);
		}
		return $this->getGalleryManager();
	}
	
	/*
	private function populate() {
		return true;
		$oPdo = SPDO::getInstance();
		
		//albums
		$sQuery = 'SELECT * FROM album';
		$oQuery = $oPdo->prepare($sQuery);
		$oQuery->execute();
		$aAlbums = $oQuery->fetchAll(PDO::FETCH_ASSOC);
		foreach($aAlbums as $aAlbum) {
			$sQuery = 'INSERT INTO t_media_albums (
						album_title,
						album_desc,
						album_cover,
						album_date
					) VALUES (
						:album_title,
						:album_desc,
						:album_cover,
						:album_date
					)';
			$oQuery = $oPdo->prepare($sQuery);
			$oQuery->bindParam(':album_title', $aAlbum['nom_album'], PDO::PARAM_STR);
			$oQuery->bindParam(':album_desc', $aAlbum['com_album'], PDO::PARAM_STR);
			$oQuery->bindParam(':album_cover', $aAlbum['couv_album'], PDO::PARAM_STR);
			$oQuery->bindParam(':album_date', $aAlbum['date_album'], PDO::PARAM_STR);
			$oQuery->execute();
		
		}
		
		$sQuery = 'SELECT * FROM photos';
		$oQuery = $oPdo->prepare($sQuery);
		$oQuery->execute();
		$aMedias = $oQuery->fetchAll(PDO::FETCH_ASSOC);
		
		
		foreach($aMedias as $aMedia) {
		
			//ajout du média
			$aMediaProps = array('media_type_id'=>1, 'media_download_allowed'=>0);
			$sQuery = 'INSERT INTO t_medias (
						media_type_id,
						media_download_allowed
					) VALUES (
						:media_type_id, 
						:media_download_allowed
					)';
			$oQuery = $oPdo->prepare($sQuery);
			$oQuery->bindParam(':media_type_id', $aMediaProps['media_type_id'], PDO::PARAM_INT);
			$oQuery->bindParam(':media_download_allowed', $aMediaProps['media_download_allowed'], PDO::PARAM_STR);
			$oQuery->execute();
			$iMediaId = $oPdo->lastInsertId();
			
			//ajout des éléments
			$sQuery = 'INSERT INTO t_media_elmts (
						media_id,
						media_elmt_type_id,
						media_elmt_add_data,
						media_elmt
					) VALUES (
						:media_id,
						:media_elmt_type_id,
						:media_elmt_add_data,
						:media_elmt
					)';
			$aElmtInfos = array(
							0 => array(
									'media_id'=>$iMediaId,
									'media_elmt_type_id'=>11,
									'media_elmt_add_data'=>'FR',
									'media_elmt'=>$aMedia['com_photo'],
								),
							1 => array(
									'media_id'=>$iMediaId,
									'media_elmt_type_id'=>6,
									'media_elmt_add_data'=>'',
									'media_elmt'=>$aMedia['file_photo'],
								),
						);
			foreach($aElmtInfos as $aElmtInfo) {
				$oQuery = $oPdo->prepare($sQuery);
				$oQuery->bindParam(':media_id', $aElmtInfo['media_id'], PDO::PARAM_INT);
				$oQuery->bindParam(':media_elmt_type_id', $aElmtInfo['media_elmt_type_id'], PDO::PARAM_INT);
				$oQuery->bindParam(':media_elmt_add_data', $aElmtInfo['media_elmt_add_data'], PDO::PARAM_STR);
				$oQuery->bindParam(':media_elmt', $aElmtInfo['media_elmt'], PDO::PARAM_STR);
				$oQuery->execute();
			}
			//ajout du média dans la table de jointure des albums
			$sQuery = 'INSERT INTO tj_media_albums (
						album_id,
						media_id
					) VALUES (
						:album_id,
						:media_id
					)';
			$oQuery = $oPdo->prepare($sQuery);
			$oQuery->bindParam(':album_id', $aMedia['id_album_photo'], PDO::PARAM_INT);
			$oQuery->bindParam(':media_id', $iMediaId, PDO::PARAM_INT);
			$oQuery->execute();
		}
	}
	
	 */
	private function updateGalleries() {
		$aGalleries = array(
						10 => "Cette année les Hors Limites, aidés d'une équipe formidable de bénévoles, ont assuré une organisation nickel. "
			. "Bravo à tous !<br />"
			. "De plus nous avons eu un soleil radieux tout le week-end ! Bravo aux ingés son de tilala.net pour s'être dépatouillés des \"câbles en bois\".<br /> "
			. "Merci aux clubs présents et à tous nos fidèles amis d'être au rendez-vous annuel gardannais (on regrette juste que beaucoup de clubs manquaient à l'appel).<br />"
			. "Malgré tout, la fête fut belle, dans une ambiance chaleureuse et familiale.<br />"
			. "2019 sera notre 20ème rassemblement, on va tâcher de frapper fort.<br />"
			. "Soyez au rendez-vous, vous ne le regretterez pas.<br />"
			. "À l'année prochaine donc, et bonne route à tous !",
						
		);
		$aGalleriesTitles = array(
						10 => "19ème rassemblement",
		);
		$oPdo = SPDO::getInstance();
		foreach($aGalleriesTitles as $iKey=>$sValue) {
			$sQuery = 'update t_galleries'
				. ' set gallery_title = :gallery_title where gallery_id = :gallery_id';
			$oQuery = $oPdo->prepare($sQuery);
			$oQuery->bindParam(':gallery_title', $sValue, PDO::PARAM_STR);
			$oQuery->bindParam(':gallery_id', $iKey, PDO::PARAM_INT);
			$oQuery->execute();
		}
		foreach($aGalleries as $iKey=>$sValue) {
			$sQuery = 'update t_galleries'
				. ' set gallery_desc = :gallery_desc where gallery_id = :gallery_id';
			$oQuery = $oPdo->prepare($sQuery);
			$oQuery->bindParam(':gallery_desc', $sValue, PDO::PARAM_STR);
			$oQuery->bindParam(':gallery_id', $iKey, PDO::PARAM_INT);
			$oQuery->execute();
		}
	}
}