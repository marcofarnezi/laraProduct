<?php
namespace App\Http\Controllers;

use App\Charts\ProductChart;
use App\Factories\CacheFactory;
use App\Http\Repositories\ProductRepository;
use App\Http\Services\ProductService;

class ChartController extends Controller
{
    private $productRepository;
    private $productService;
    private $cache;

    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService,
        CacheFactory $cacheFactory
    )
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->cache = $cacheFactory->createCache();
    }

    public function index(
        $minPrice = null,
        $maxPrice = null,
        $minReviews = null,
        $maxReviews = null,
        $dateFirstListedMin = null,
        $dateFirstListedMax = null
    )
    {
        $filter = compact(
            'minPrice',
            'maxPrice',
            'minReviews',
            'maxReviews',
            'dateFirstListedMin',
            'dateFirstListedMax'
        );

        $amount = $this->productRepository->count($filter);

        if (! $this->cache->hasKeyInCache('chart-product') || ! empty($filter)) {
            $columns = [
                'price',
                'num_reviews',
                'avg_rating'
            ];
            $charts = ProductChart::generate(
                $this->productRepository,
                $this->productService,
                $columns,
                $filter
            );
            if (! $filter) {
                $this->cache->save('chart-product', serialize($charts), 86400);
            }
        }

        $charts = empty($filter) ? unserialize($this->cache->get('chart-product')) : $charts;

        return view('chart', compact('charts', 'amount') );
    }
}
