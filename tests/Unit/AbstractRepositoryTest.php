<?php
namespace Tests\Unit;

use App\Http\Contracts\RepositoryInterface;
use App\Http\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class AbstractRepositoryTest extends TestCase
{
    public function test_if_implements_repositoryinterface()
    {
        $mock = \Mockery::mock(AbstractRepository::class);
        $this->assertInstanceOf(RepositoryInterface::class, $mock);
    }

    public function test_should_return_all_without_argument()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';
        $mockStd->avg_rating = 3.0;

        $mockRepository->shouldReceive('all')
            ->andReturn([$mockStd, $mockStd, $mockStd]);
        $result = $mockRepository->all();
        $this->assertCount(3, $result);
        $this->assertInstanceOf(\stdClass::class,  $result[0]);
    }

    public function test_should_return_all_with_argument()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';

        $mockRepository->shouldReceive('all')
            ->with(['id', 'title'])
            ->andReturn([$mockStd, $mockStd, $mockStd]);

        $result = $mockRepository->all(['id', 'title']);

        $this->assertCount(3,$result );
        $this->assertInstanceOf(\stdClass::class,  $result[0]);
    }

    public function test_should_return_create()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';

        $mockRepository->shouldReceive('create')
            ->with(['title' => 'strClassName'])
            ->andReturn($mockStd);

        $result = $mockRepository->create(['title' => 'strClassName']);

        $this->assertEquals(1, $result->id);

        $this->assertInstanceOf(
            \stdClass::class,
            $result
        );
    }

    public function test_should_return_update_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';

        $mockRepository->shouldReceive('update')
            ->with(['title' => 'strClassName'], 1)
            ->andReturn($mockStd);

        $result = $mockRepository->update(['title' => 'strClassName'], 1);

        $this->assertEquals(1, $result->id);

        $this->assertInstanceOf(
            \stdClass::class,
            $result
        );
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_should_return_update_fail()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mockRepository->shouldReceive('update')
            ->with(['title' => 'strClassName'], 0)
            ->andThrow($throw);

        $mockRepository->update(['title' => 'strClassName'], 0);
    }

    public function test_should_return_delete_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $mockRepository->shouldReceive('delete')
            ->with(1)
            ->andReturn(true);

        $result = $mockRepository->delete(1);

        $this->assertEquals(true, $result);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_should_return_delete_fail()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mockRepository->shouldReceive('delete')
            ->with(0)
            ->andThrow($throw);

        $mockRepository->delete(0);
    }

    public function test_should_return_find_without_columns_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';
        $mockStd->avg_rating = 3.0;

        $mockRepository->shouldReceive('find')
            ->with(1)
            ->andReturn($mockStd);

        $result = $mockRepository->find(1);

        $this->assertInstanceOf(\stdClass::class,  $result);
    }

    public function test_should_return_find_with_columns_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';

        $mockRepository->shouldReceive('find')
            ->with(1, ['id', 'title'])
            ->andReturn($mockStd);

        $result = $mockRepository->find(1, ['id', 'title']);

        $this->assertInstanceOf(\stdClass::class,  $result);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_should_return_find_fail()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);

        $throw = new ModelNotFoundException();
        $throw->setModel(\stdClass::class);

        $mockRepository->shouldReceive('find')
            ->with(0)
            ->andThrow($throw);

        $mockRepository->find(0);
    }

    public function test_should_return_findby_with_columns_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';

        $mockRepository->shouldReceive('findBy')
            ->with('title', 'my-data', ['id', 'title'])
            ->andReturn([$mockStd, $mockStd, $mockStd]);

        $result = $mockRepository->findBy('title', 'my-data', ['id', 'title']);

        $this->assertCount(3, $result);
        $this->assertInstanceOf(\stdClass::class,  $result[0]);
    }

    public function test_should_return_findby_empty_success()
    {
        $mockRepository = \Mockery::mock(AbstractRepository::class);
        $mockStd = \Mockery::mock(\stdClass::class);

        $mockStd->id = 1;
        $mockStd->title = 'title';

        $mockRepository->shouldReceive('findBy')
            ->with('title', '', ['id', 'title'])
            ->andReturn([]);

        $result = $mockRepository->findBy('title', '', ['id', 'title']);

        $this->assertCount(0, $result);
    }
}
