<?php
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 3:28 PM
 */

namespace Thant\DataTable;

interface IDataProvider
{
	const SORT_ASC = 'ASC';
	const SORT_DESC = 'DESC';
	public function fetchData($offset = 0, $length = 20, $sort_column = null, $sort_dir = self::SORT_ASC, $search_value, $wildcard = false);
	public function getColumnByIndex($index);
}