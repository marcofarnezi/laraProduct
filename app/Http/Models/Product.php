<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = "products";

    protected $casts = [
        'amazon_date' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'title',
        'price',
        'avg_rating',
        'num_reviews',
        'amazon_date'
    ];

    /**
     * @param $model
     * @param $column
     * @return mixed
     */
    public function getChartDataByDay($model, $column)
    {
        return $model->select(
            DB::raw("DATE(amazon_date) as date"),
            DB::raw("COUNT({$column}) as amount"),
            DB::raw("MAX({$column}) as max"),
            DB::raw("MIN({$column}) as min"),
            DB::raw("AVG({$column}) as avg")
        )
            ->groupBy('date')
            ->get();
    }
}
