<?php
namespace App\Http\Repositories;

use App\Http\Models\Product;

/**
 * Class ProductRepository
 * @package App\Http\Repositories
 */
class ProductRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * @param $column
     * @param $filter
     * @return mixed
     */
    public function getChartData($column, $filter)
    {
        $model = $this->applyFilter($filter);
        return $this->model->getChartDataByDay($model, $column);
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function count($filter)
    {
        $model = $this->applyFilter($filter);

        return $model->count();
    }

    /**
     * @param $filter
     * @return mixed
     */
    protected function applyFilter($filter)
    {
        $model = $this->model;
        if (! empty($filter['minPrice']) && is_numeric($filter['minPrice'])) {
            $model = $model->where('price', '>=', $filter['minPrice']);
        }

        if (! empty($filter['maxPrice']) && is_numeric($filter['maxPrice'])) {
            $model = $model->where('price', '<=', $filter['maxPrice']);
        }

        if (! empty($filter['minReviews']) && is_numeric($filter['minReviews'])) {
            $model = $model->where('num_reviews', '>=', $filter['minReviews']);
        }

        if (! empty($filter['maxReviews']) && is_numeric($filter['maxReviews'])) {
            $model = $model->where('num_reviews', '<=', $filter['maxReviews']);
        }

        if (! empty($filter['dateFirstListedMin'])) {
            $model = $model->where('amazon_date', '>=', $filter['dateFirstListedMin']);
        }

        if (! empty($filter['dateFirstListedMax'])) {
            $model = $model->where('amazon_date', '<=', $filter['dateFirstListedMax']);
        }

        return $model;
    }
}
