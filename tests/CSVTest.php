<?php namespace Monokakure\CSV;

use Way\Tests\Assert;
use Way\Tests\Should;

class CSVTest extends \PHPUnit_Framework_TestCase
{
	public function testParse()
	{
		$csv = new CSVManipulator();
		$result = $csv->parse('./tests/read.csv');

		Should::equal($result->lines()[0][0], 'samplename1');
		Should::equal($result->lines()[0][1], '1');
		Should::equal($result->lines()[1][0], 'samplename2');
		Should::equal($result->lines()[1][1], '2');
	}

	public function testParseWithHeder()
	{
		$csv = new CSVManipulator();
		$result = $csv->parse('./tests/header.csv', true);

		Should::equal($result->hasHeader(), true);
		Should::equal($result->header()[0], 'name');
		Should::equal($result->header()[1], 'number');

		Should::equal($result->lines()[0][0], 'samplename1');
		Should::equal($result->lines()[0][1], '1');
		Should::equal($result->lines()[1][0], 'samplename2');
		Should::equal($result->lines()[1][1], '2');
	}

	public function testFromArray()
	{
		$csv = new CSVManipulator();
		$arr = array(
			'name' => 'samplename1',
			'number' => 1
		);
		$result = $csv->make($arr)->build();
		Should::equal($result, 'samplename1,1'."\n");
	}

	public function testFromArrayWithHeader()
	{
		$csv = new CSVManipulator();
		$arr = array(
			'name' => 'samplename1',
			'number' => 1
		);
		$header = array(
			'name', 'number'
		);
		$result = $csv->make($arr, $header)->build();
		Should::equal($result, 'name,number'."\n".'samplename1,1'."\n");
	}

	public function testFromArrayWithEncode()
	{
		$csv = new CSVManipulator();
		$arr = array(
			'name' => 'テスト',
			'number' => 1
		);
		$result = $csv->setEncode('SJIS-win', 'UTF-8')
					  ->make($arr)->build();

		Should::equal(mb_detect_encoding($result, 'SJIS-win'), 'SJIS-win');
	}

}