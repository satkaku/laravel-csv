<?php namespace Monokakure\CSV;

use SplFileObject;

class CSVManipulator {

	private $encodeFrom;
	private $encodeTo;

	private $csv;

	public function setEncode($to, $from)
	{
		$this->encodeTo = $to;
		$this->encodeFrom = $from;

		return $this;
	}

	public function make($arr, $header=null)
	{
		return new CSV(array(
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
		return new CSV(array(
			'lines' => $recodes,
			'header'=> $header,
			'encodeTo' => $this->encodeTo,
			'encodeFrom' => $this->encodeFrom,
		));
	}

}