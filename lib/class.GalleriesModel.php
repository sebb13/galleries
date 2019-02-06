<?php
final class GalleriesModel {

	private $sGalleriesTable		= 't_galleries';
	private $sTjMediaGalleryTable	= 'tj_media_gallery';
	private $oPdo					= NULL;
	
	public function __construct() {
		$this->oPdo = SPDO::getInstance();
	}
	
	public function getGalleriesIds() {
		$sQuery = 'SELECT
						gallery_id
					FROM '.$this->sGalleriesTable.'  
					WHERE gallery_active = 1';
		$oQuery = $this->oPdo->query($sQuery);
		$oQuery->execute();
		return $oQuery->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function getGalleryCover($iAlbumId) {
		$sQuery = 'SELECT
						gallery_id,
						gallery_title,
						gallery_desc,
						gallery_cover
					FROM '.$this->sGalleriesTable.'  
					WHERE gallery_id = :gallery_id';
		$oQuery = $this->oPdo->prepare($sQuery);
		$oQuery->bindParam(':gallery_id', $iAlbumId, PDO::PARAM_INT);
		$oQuery->execute();
		return $oQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getAllGalleriesCovers($iActive=1) {
		$sQuery = 'SELECT
						gallery_id,
						gallery_title,
						gallery_desc,
						gallery_cover
					FROM '.$this->sGalleriesTable.' 
					WHERE gallery_active = :gallery_active 
					ORDER BY gallery_id DESC';
		$oQuery = $this->oPdo->prepare($sQuery);
		$oQuery->bindParam(':gallery_active', $iActive, PDO::PARAM_INT);
		$oQuery->execute();
		return $oQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getGalleryContents($iAlbumId) {
		$sQuery = 'SELECT
						media_id
					FROM '.$this->sTjMediaGalleryTable.'  
					WHERE gallery_id = :gallery_id';
		$oQuery = $this->oPdo->prepare($sQuery);
		$oQuery->bindParam(':gallery_id', $iAlbumId, PDO::PARAM_INT);
		$oQuery->execute();
		return $oQuery->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function getGallerySize($iAlbumId) {
		$sQuery = 'SELECT
						count(media_id) 
					FROM '.$this->sTjMediaGalleryTable.'  
					WHERE gallery_id = :gallery_id';
		$oQuery = $this->oPdo->prepare($sQuery);
		$oQuery->bindParam(':gallery_id', $iAlbumId, PDO::PARAM_INT);
		$oQuery->execute();
		$aReturn = $oQuery->fetchAll(PDO::FETCH_COLUMN);
		return $aReturn[0];
	}
	
	public function getGalleriesCount($iActive=1) {
		$sQuery = 'SELECT
						count(gallery_id) 
					FROM '.$this->sGalleriesTable.'  
					WHERE gallery_active = :gallery_active';
		$oQuery = $this->oPdo->prepare($sQuery);
		$oQuery->bindParam(':gallery_active', $iActive, PDO::PARAM_INT);
		$oQuery->execute();
		$aReturn = $oQuery->fetchAll(PDO::FETCH_COLUMN);
		return $aReturn[0];
	}
	
	public function createGallery($aGalleryProps) {
		
	}
	
	public function addToGallery($iGalleryId, $iMediaId) {
		$sQuery = 'INSERT INTO '.$this->sTjMediaGalleryTable.' (
						gallery_id,
						media_id
					) VALUES (
						:gallery_id,
						:media_id
					)';
		$oQuery = $this->oPdo->prepare($sQuery);
		$oQuery->bindParam(':gallery_id', $iGalleryId, PDO::PARAM_INT);
		$oQuery->bindParam(':media_id', $iMediaId, PDO::PARAM_INT);
		return $oQuery->execute();
	}
	
	public function removeFromGallery($iGalleryId, $iMediaId) {
		try {
			$sQuery = 'DELETE FROM '.$this->sTjMediaGalleryTable.'  
						WHERE gallery_id = :gallery_id 
						AND media_id = :media_id';
			$oQuery = $this->oPdo->prepare($sQuery);
			$oQuery->bindParam(':gallery_id', $iGalleryId, PDO::PARAM_INT);
			$oQuery->bindParam(':media_id', $iMediaId, PDO::PARAM_INT);
			return $oQuery->execute();
		} catch (Exception $e) {
			throw new GenericException($e->getMessage());
		}
	}
	
	public function archiveGallery($iGalleryId, $iActive=0) {
		try {
			$sQuery = 'UPDATE '.$this->sGalleriesTable.' SET 
							gallery_active = :gallery_active
						WHERE gallery_id = :gallery_id';
			$oQuery = $this->oPdo->prepare($sQuery);
			$oQuery->bindParam(':gallery_active', $iActive, PDO::PARAM_INT);
			$oQuery->bindParam(':gallery_id', $iGalleryId, PDO::PARAM_INT);
			return $oQuery->execute();
		} catch (Exception $e) {
			throw new GenericException($e->getMessage());
		}
	}
	
	public function restoreGallery($iGalleryId) {
		return $this->archiveGallery($iGalleryId, 1);
	}
	
	public function deleteGallery($iGalleryId) {
		$this->purgeGallery($iGalleryId);
		try {
			$sQuery = 'DELETE FROM '.$this->sGalleriesTable.'  
						WHERE gallery_id = :gallery_id';
			$oQuery = $this->oPdo->prepare($sQuery);
			$oQuery->bindParam(':gallery_id', $iGalleryId, PDO::PARAM_INT);
			return $oQuery->execute();
		} catch (Exception $e) {
			throw new GenericException($e->getMessage());
		}
	}
	
	public function purgeGallery($iGalleryId) {
		try {
			$sQuery = 'DELETE FROM '.$this->sTjMediaGalleryTable.'  
						WHERE gallery_id = :gallery_id';
			$oQuery = $this->oPdo->prepare($sQuery);
			$oQuery->bindParam(':gallery_id', $iGalleryId, PDO::PARAM_INT);
			return $oQuery->execute();
		} catch (Exception $e) {
			throw new GenericException($e->getMessage());
		}
	}
}