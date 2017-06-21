<?php

namespace Thant\DataTable\DataProvider;
use Thant\DataTable\IDataProvider;
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 3:32 PM
 */
class ArrayList implements IDataProvider
{

	protected $columns = array();

	protected $records = array();

	public function __construct(array $columns, array $records)
	{
		$this->columns = $columns;
		$this->records = $records;
	}

	public function getColumnByIndex($index)
	{
		return array_key_exists($index, $this->columns) ? $this->columns[$index] : null;
	}

	public function fetchData($offset = 0, $length = 20, $sort_column = null, $sort_dir = self::SORT_ASC, $search_value, $wild_card = false)
	{

		$records = $this->records;

		if(!empty($search_value))
		{
			$records = array_filter($this->records, function($record) use($search_value){
				return stripos($record[0], $search_value) !== false || 	stripos($record[1], $search_value) !== false;
			});
		}

		if(!empty($sort_column))
		{
			$sort_index = array_search($sort_column, $this->columns);
			usort($records, function($a, $b) use($sort_index, $sort_dir){
				if($a[$sort_index] == $b[$sort_index])
				{
					return 0;
				}

				$result = strcasecmp($a[$sort_index], $b[$sort_index]);
				if($sort_dir == self::SORT_DESC)
				{
					$result = $result * -1;
				}

				return $result;
			});
		}

		$total_filtered = count($records);

		$records = array_slice($records, $offset, $length);

		return array(
			$records,
			count($this->records),
			$total_filtered
		);
	}
}