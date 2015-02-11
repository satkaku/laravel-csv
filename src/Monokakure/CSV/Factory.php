<?php namespace Monokakure\CSV;

use SplFileObject;

class Factory {

	private $encodeFrom;
	private $encodeTo;

	public function setEncode($to, $from)
	{
		$this->encodeTo = $to;
		$this->encodeFrom = $from;

		return $this;
	}

	public function create($arr, $header=null)
	{
		return $this->getCSV(array(
			'lines'  => $arr,
			'header' => $header,
			'encodeTo' => $this->encodeTo,
			'encodeFrom' => $this->encodeFrom,
		));
	}

	public function parse($filepath, $hasHeader=false)
	{
		$file = new SplFileObject($filepath);
		$file->setFlags(SplFileObject::READ_CSV);
		
		$recodes = array();
		$header = null;

		foreach ($file as $index=>$line)
		{
			if ($hasHeader && $index === 0)
			{
				$header = $line;
			}
			else
			{
				$recodes[] = $line;	
			}
		}
		return $this->getCSV(array(
			'lines' => $recodes,
			'header'=> $header,
			'encodeTo' => $this->encodeTo,
			'encodeFrom' => $this->encodeFrom,
		));
	}

	protected function getCSV($opts)
	{
		return new CSV($opts);
	}

}