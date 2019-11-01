<?php

namespace App\Charts;

use App\Http\Contracts\RepositoryInterface;
use App\Http\Services\ProductService;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class ProductChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function generate(
        RepositoryInterface $repository,
        ProductService $service,
        array $columns,
        array $filter
    )
    {
        $charts = [];
        foreach ($columns as $column) {
            $charts[$column] = self::getData($repository, $service, $column, $filter);
        }

        return $charts;
    }

    private static function getData(RepositoryInterface $repository, ProductService $service, $column, $filter)
    {
        $lines = $service->getChatDate($column, $repository, $filter);
        return self::newChart($lines);
    }

    private static function newChart(array $lines)
    {
        $chart = new self();
        $chart->labels($lines['lines']);
        $chart->dataset('max', 'line', $lines['max'])->color("black");
        $chart->dataset('min', 'line', $lines['min'])->color("green");
        $chart->dataset('avg', 'line', $lines['avg'])->color("blue");

        return $chart;
    }
}
