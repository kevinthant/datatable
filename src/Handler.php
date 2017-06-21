<?php
namespace Thant\DataTable;
use Thant\Helpers\InputFilter;
use Thant\DataTable\Exception\InputValidationException;
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 3:26 PM
 */
class Handler
{
	/**
	 * @var \Thant\DataTable\IDataProvider
	 */
	protected $provider;

	/**
	 * @var \Thant\Helpers\InputFilter
	 */
	protected $sanitizer;

	public function __construct(IDataProvider $provider)
	{
		$self = $this;
		$this->provider = $provider;
		$this->sanitizer = new InputFilter();
		$this->sanitizer->setRequired('draw')
									->filter('draw', [
										FILTER_VALIDATE_INT
									])
									->setRequired('order')
									->filter('order', [
										FILTER_CALLBACK => array(
											'options' => function($val) use($self)
											{
												echo '<h1>order check</h1>';
												return $self->validateOrderParam($val);
											}
										)
									])
									->setRequired('start')
									->filter('start', [
										FILTER_VALIDATE_INT
									])
									->setRequired('length'exi)
									->filter('length', [
										FILTER_VALIDATE_INT
									])
									->filter('search', [
										FILTER_CALLBACK => array(
											'options' => function($val) use($self)
											{
												return $self->validateSearchParam($val);
											}
										)
									]);
	}

	public function handle(array $params)
	{
		$this->sanitizer->setInputs($params)
										->sanitize();

		if($this->sanitizer->hasErrors())
		{
			throw new InputValidationException($this->sanitizer->getErrors());
		}

		$input = $this->sanitizer->getClean();
		var_dump($input['order']);
		$sortColumn = $this->provider->getColumnByIndex($input['order']['column_index']);
		$sortDir = $input['order']['dir'];

		$offset = $input['start'];
		$length = $input['length'];
		$search_value = null;
		$wild_card = false;
		if(isset($input['search']['regex']) && !empty($input['search']['regex']))
		{
			$search_value = $input['search']['regex'];
			$wild_card = true;
		}
		elseif(isset($input['search']['value']) && !empty($input['search']['value']))
		{
			$search_value = $input['search']['value'];
		}

		list($rows, $total, $total_filtered) = $this->provider->fetchData($offset, $length, $sortColumn, $sortDir, $search_value, $wild_card);

		return [
			'draw' => $input['draw'],
		  'recordsTotal' => $total,
		  'recordsFiltered' => $total_filtered,
		  'data' => $rows
		];
	}

	protected function validateOrderParam($order)
	{
		if(!is_array($order) || empty($order))
		{
			return false;
		}

		$columnIndex = null;
		$dir = null;
		foreach($order as $detail)
		{
			if(!is_array($detail) || !isset($detail['column']) || !isset($detail['dir']))
			{
				return false;
			}

			$columnIndex = $detail['column'];
			$dir = strtoupper($detail['dir']);
		}

		echo 'in order check';
		exit;
		return array(
			'column_index' => $columnIndex,
			'dir' => $dir
		);
	}

	protected function validateSearchParam($search)
	{
		if(!is_array($search) || empty($search))
		{
			return false;
		}

		if(!isset($search['value']) || !isset($search['regex']))
		{
			return false;
		}

		return $search;
	}
}