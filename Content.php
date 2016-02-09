<?php
class Content{

	public $path = null;
	public $contentBody = null;
	public $contentType = null;
	public $contentSize = null;

	public function __construct($path){
		$this->path = $path;
		$this->readFileInfo();
	}

	public function readFileInfo() {
		if(file_exists($this->path)){
			$this->contentBody = file_get_contents($this->path);
			$this->contentSize = filesize($this->path);
			$this->contentType = $this->getType($this->path);
		}else{
			throw new Exception("File $this->path doesn't exist.");
			return false;
		}
	}

	public function getType($path) {
		$contentType = '';
		$filename = basename($path);
		$fileArray = explode('.', $filename);
		$filenameExtension = array_pop($fileArray);

		switch ($filenameExtension) {
		    case 'css':
		        $contentType =  'text/css';
		        break;
		    case 'js':
		        $contentType = 'application/javascript';
		        break;
		    default:
		        $contentType = 'text/html';
		        break;
		}

		return $contentType;
	}
}