<?php

namespace Tests\Unit;

use App\Contracts\PasswordGeneratorInterface;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\TestCase;
use Mockery;

class PasswordServiceTest extends TestCase
{
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sessionMock = Mockery::mock('alias:Illuminate\Support\Facades\Session');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_generates_a_password_with_specified_length()
    {
        $generatorMock = Mockery::mock(PasswordGeneratorInterface::class);
        $generatorMock->shouldReceive('generate')
            ->andReturn('TestPass');

        $this->sessionMock->shouldReceive('get')
            ->with('generated_passwords', [])
            ->andReturn([]);

        $this->sessionMock->shouldReceive('put')
            ->with('generated_passwords', ['TestPass'])
            ->once();

        $service = new PasswordService($generatorMock);

        $password = $service->generateUniquePassword(8, true, true, true);
        $this->assertEquals(8, strlen($password));
    }

    /** @test */
    public function it_generates_a_password_with_digits()
    {
        $generatorMock = Mockery::mock(PasswordGeneratorInterface::class);
        $generatorMock->shouldReceive('generate')
            ->andReturn('12345678');

        $this->sessionMock->shouldReceive('get')
            ->with('generated_passwords', [])
            ->andReturn([]);

        $this->sessionMock->shouldReceive('put')
            ->with('generated_passwords', ['12345678'])
            ->once();

        $service = new PasswordService($generatorMock);

        $password = $service->generateUniquePassword(8, true, false, false);
        $this->assertMatchesRegularExpression('/\d/', $password);
    }

    /** @test */
    public function it_generates_a_password_with_uppercase()
    {
        $generatorMock = Mockery::mock(PasswordGeneratorInterface::class);
        $generatorMock->shouldReceive('generate')
            ->andReturn('ABCDEFGH');

        $this->sessionMock->shouldReceive('get')
            ->with('generated_passwords', [])
            ->andReturn([]);

        $this->sessionMock->shouldReceive('put')
            ->with('generated_passwords', ['ABCDEFGH'])
            ->once();

        $service = new PasswordService($generatorMock);

        $password = $service->generateUniquePassword(8, false, true, false);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
    }

    /** @test */
    public function it_generates_a_password_with_lowercase()
    {
        $generatorMock = Mockery::mock(PasswordGeneratorInterface::class);
        $generatorMock->shouldReceive('generate')
            ->andReturn('abcdefgh');

        $this->sessionMock->shouldReceive('get')
            ->with('generated_passwords', [])
            ->andReturn([]);

        $this->sessionMock->shouldReceive('put')
            ->with('generated_passwords', ['abcdefgh'])
            ->once();

        $service = new PasswordService($generatorMock);

        $password = $service->generateUniquePassword(8, false, false, true);
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
    }
}
