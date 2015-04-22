<?php namespace Monokakure\CSV;

use SplFileObject;

class CSV {

	const BOM_UTF8 = "\xEF\xBB\xBF";
	const BOM_UTF16LE = "\xFF\xFE";

	protected $header;
	protected $lines;
	protected $_csv = '';

	protected $delimiter = ',';
	protected $encodeFrom;
	protected $encodeTo;
	protected $bom = '';
	

	public function __construct($opts)
	{
		$this->header 	   = $opts['header'] 	  ? $opts['header'] 	 : null;
		$this->lines 	   = $opts['lines']  	  ? $opts['lines']  	 : null;
		$this->encodeFrom  = $opts['encodeFrom']  ? $opts['encodeFrom']  : null;
		$this->encodeTo    = $opts['encodeTo']    ? $opts['encodeTo']    : null;
	}

	public function hasHeader()
	{
		return !is_null($this->header);
	}

	public function header()
	{
		return $this->header;
	}

	public function lines()
	{
		return $this->lines;
	}

	public function build()
	{
		if (!$this->lines) { return; }
		
		$this->tocsv();
		$this->encode();

		return $this->bom.$this->_csv;
	}

	protected function tocsv()
	{
		$sfo = new SplFileObject('php://output', 'r+');
		ob_start();
		if ($this->hasHeader())
		{
			$sfo->fputcsv( $this->header, $this->delimiter );	
		}
		
		foreach( $this->lines as $l )
		{
			$sfo->fputcsv( $l, $this->delimiter );	
		}
		$this->_csv = ob_get_clean();
	}

	protected function encode()
	{
		if (!$this->_csv) 	  { return; }
		if (!$this->encodeTo) { return; }
		
		$this->_csv = mb_convert_encoding($this->_csv, $this->encodeTo, $this->encodeFrom);
	}

	public function render($filename='download.csv')
	{
		return \Response::make($this->build(), 200, $this->getResponseHeader($filename));
	}

	protected function getResponseHeader($filename='download.csv')
	{
		return array(
			'Content-Type' 		  => 'text/csv',
			'Content-Disposition' => 'attachment; filename="'.$filename.'"'
		);
	}

	public function setDelimiter($delimiter)
	{
		$this->delimiter = $delimiter;
		return $this;
	}

	public function setBOM_UTF8()
	{
		$this->bom = self::BOM_UTF8;
		return $this;
	}

	public function setBOM_UTF16LE()
	{
		$this->bom = self::BOM_UTF16LE;
		return $this;
	}

}