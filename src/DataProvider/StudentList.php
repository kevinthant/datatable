<?php

namespace Thant\DataTable\DataProvider;
use Thant\DataTable\IDataProvider;
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 3:32 PM
 */
class StudentList implements IDataProvider
{

	protected $columns = array(
		'Name',
		'Email',
		'Date'
	);

	protected $records = array(
		[
			'Kevin Thant',
		  'kevinthant@vonage.com',
			'2017-06-20'
		],
		[
			'Jame Demo',
			'jamedemo@vonage.com',
			'2017-06-20'
		]
	);

	public function __construct()
	{

	}

	public function getColumnByIndex($index)
	{
		return array_key_exists($index, $this->columns) ? $this->columns[$index] : null;
	}

	public function fetchData($offset = 0, $length = 20, $sort_column = null, $sort_dir = self::SORT_ASC, $search_value, $wild_card = false)
	{
		return array(
			$this->records,
			count($this->records),
			count($this->records)
		);
	}
}