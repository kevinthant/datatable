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
        $this->provider = $provider;
        $this->sanitizer = new InputFilter();
        $this->sanitizer->setRequired('draw')
            ->filter('draw', [
                FILTER_VALIDATE_INT
            ])
            ->setRequired('order[0][column]')
            ->filter('order[0][column]', [
                FILTER_VALIDATE_INT
            ])
            ->setRequired('order[0][dir]')
            ->filter('order[0][dir]', [
                FILTER_SANITIZE_STRING
            ])
            ->setRequired('start')
            ->filter('start', [
                FILTER_VALIDATE_INT
            ])
            ->setRequired('length')
            ->filter('length', [
                FILTER_VALIDATE_INT
            ])
            ->filter('search[value]', [
                FILTER_UNSAFE_RAW
            ])
            ->filter('search[regex]', [
                FILTER_CALLBACK => array(
                    'options' => function ($val) {
                        return is_string($val) && trim($val) == 'false' ? null : $val;
                    }
                )
            ]);
    }

    public function handle(array $params)
    {

        $this->sanitizer->setInputs($params)
            ->sanitize();

        if ($this->sanitizer->hasErrors()) {
            throw new InputValidationException($this->sanitizer->getErrors());
        }

        $input = $this->sanitizer->getClean();
        $sortColumn = $this->provider->getColumnByIndex($input['order'][0]['column']);
        $sortDir = strtoupper($input['order'][0]['dir']);

        $offset = $input['start'];
        $length = $input['length'];
        $search_value = null;
        $wild_card = false;
        if (isset($input['search']['regex']) && !empty($input['search']['regex'])) {
            $search_value = $input['search']['regex'];
            $wild_card = true;
        } elseif (isset($input['search']['value']) && !empty($input['search']['value'])) {
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

}