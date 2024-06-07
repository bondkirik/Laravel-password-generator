<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Mockery;
use App\Contracts\PasswordGeneratorInterface;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $passwordGeneratorMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->passwordGeneratorMock = Mockery::mock(PasswordGeneratorInterface::class);
        $this->app->instance(PasswordGeneratorInterface::class, $this->passwordGeneratorMock);

        $this->sessionMock = Mockery::mock('alias:Illuminate\Support\Facades\Session');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_generates_a_password()
    {
        $this->passwordGeneratorMock
            ->shouldReceive('generate')
            ->once()
            ->with(10, true, true, true)
            ->andReturn('TestPassword123');

        $this->sessionMock->shouldReceive('get')
            ->with('generated_passwords', [])
            ->andReturn([]);

        $this->sessionMock->shouldReceive('put')
            ->with('generated_passwords', ['TestPassword123'])
            ->once();

        $response = $this->get('/generate-password?length=10&useDigits=true&useUppercase=true&useLowercase=true');

        $response->assertStatus(200);
        $response->assertJson(['password' => 'TestPassword123']);
    }

}
