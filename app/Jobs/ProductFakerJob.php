<?php

namespace App\Jobs;

use App\Factories\CacheFactory;
use App\Http\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ProductFakerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cache;

    /**
     * ProductFakerJob constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $factory = new CacheFactory();
        $this->cache = $factory->createCache();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            factory(Product::class, 1000)->create();
            DB::commit();
            $this->cache->remove('chart-product');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
