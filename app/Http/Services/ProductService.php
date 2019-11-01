<?php
namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;

/**
 * Class ProductService
 * @package App\Http\Services
 */
class ProductService
{
    /**
     * @param $column
     * @param ProductRepository $repository
     * @param $filter
     * @return array
     */
    public function getChatDate($column, ProductRepository $repository, $filter)
    {
        $data = $repository->getChartData($column, $filter);
        return [
            'lines' => $this->getDataLines($data, 'date'),
            'amount' => $this->getDataLines($data, 'amount'),
            'max' => $this->getDataLines($data, 'max'),
            'min' => $this->getDataLines($data, 'min'),
            'avg' => $this->getDataLines($data, 'avg'),
        ];
    }

    /**
     * @param $data
     * @param $column
     * @return array
     */
    private function getDataLines($data, $column)
    {
        $line = [];
        foreach ($data as $item)
        {
            $line[] = $item->{$column};
        }

        return $line;
    }

}
