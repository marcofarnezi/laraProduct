<?php
namespace Tests\Acceptance;

use App\Http\Models\Product;
use App\Http\Repositories\ProductRepository;
use App\Http\Services\ProductService;
use Carbon\Carbon;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    /**
     * @var ProductRepository
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->repository = new ProductRepository();
        $this->createProducts();
    }

    private function createProducts()
    {
        Product::create(
            [
                'title' => 'title 1',
                'price' => 100,
                'num_reviews' => 5,
                'avg_rating' => 3.0,
                'amazon_date' => Carbon::now()
            ]
        );

        Product::create(
            [
                'title' => 'title 2',
                'price' => 100,
                'num_reviews' => 5,
                'avg_rating' => 3.0,
                'amazon_date' => Carbon::now()
            ]
        );

        Product::create(
            [
                'title' => 'title 3',
                'price' => 100,
                'num_reviews' => 5,
                'avg_rating' => 3.0,
                'amazon_date' => Carbon::now()
            ]
        );
    }

    public function test_can_model()
    {
        $this->assertEquals(Product::class, $this->repository->model());
    }

    public function test_can_make_model()
    {
        $result = $this->repository->makeModel();
        $this->assertInstanceOf(Product::class, $result);

        $reflectionClass = new \ReflectionClass($this->repository);
        $reflectionProperty = $reflectionClass->getProperty('model');
        $reflectionProperty->setAccessible(true);

        $result = $reflectionProperty->getValue($this->repository);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_can_make_model_in_constructor()
    {
        $reflectionClass = new \ReflectionClass($this->repository);
        $reflectionProperty = $reflectionClass->getProperty('model');
        $reflectionProperty->setAccessible(true);

        $result = $reflectionProperty->getValue($this->repository);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_can_list_all_products()
    {
        $result = $this->repository->all();

        $this->assertCount(3, $result);
        $this->assertNotNull($result[0]->avg_rating);

        $result = $this->repository->all(['title']);

        $this->assertNull($result[0]->avg_rating);
    }

    public function test_can_create_product()
    {
        $result = $this->repository->create(
            [
                'title' => 'title 4',
                'price' => 100,
                'num_reviews' => 5,
                'avg_rating' => 4.0,
                'amazon_date' => Carbon::now()
            ]
        );

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals('title 4', $result->title);
        $this->assertEquals(4.0, $result->avg_rating);

        $result = Product::find(4);
        $this->assertEquals('title 4', $result->title);
        $this->assertEquals(4.0, $result->avg_rating);
    }

    public function test_can_update_product()
    {
        $result = $this->repository->update(
            [
                'title' => 'title updated',
                'avg_rating' => 5.0
            ],
            1
        );

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals('title updated', $result->title);
        $this->assertEquals(5.0, $result->avg_rating);

        $result = Product::find(1);
        $this->assertEquals('title updated', $result->title);
        $this->assertEquals(5.0, $result->avg_rating);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_can_update_product_fail()
    {
        $this->repository->update(
            [
                'title' => 'title updated',
                'avg_rating' => 5.0
            ],
            10
        );
    }

    public function test_can_delete_product()
    {
        $result = $this->repository->delete(1);
        $products = Product::all();

        $this->assertCount(2, $products);
        $this->assertEquals(true, $result);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_can_delete_product_fail()
    {
        $this->repository->delete(10);
    }

    public function test_can_find_product()
    {
        $result = $this->repository->find(1);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_can_find_product_with_columns()
    {
        $result = $this->repository->find(1, ['title']);
        $this->assertInstanceOf(Product::class, $result);
        $this->assertNull($result->avg_rating);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_can_find_product_fail()
    {
        $this->repository->find(10);
    }

    public function test_can_find_products()
    {
        $result = $this->repository->findBy('title', 'title 1');
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Product::class, $result[0]);
        $this->assertEquals('title 1', $result[0]->title);

        $result = $this->repository->findBy('title', 'title 10');
        $this->assertCount(0, $result);

        $result = $this->repository->findBy('title', 'title 1', ['title']);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Product::class, $result[0]);
        $this->assertEquals('title 1', $result[0]->title);
        $this->assertNull($result[0]->avg_rating);
    }

    public function test_create_products_faker()
    {
        $products = factory(Product::class, 1000)->create();
        $this->assertCount(1000, $products);
    }
}
