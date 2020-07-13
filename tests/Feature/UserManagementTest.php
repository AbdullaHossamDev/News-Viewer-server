<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;


class UserManagementTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function user_can_register()
	{
		// $this->withoutExceptionHandling();

		$response = $this->post('/api/user/register', $this->register_data());

		$response->assertStatus(200);
		$user = User::all();
		$this->assertCount(1, $user);
	}

	/** @test */
	public function name_is_required_in_registeration()
	{
		// $this->withoutExceptionHandling();

		$response = $this->post('/api/user/register', array_merge($this->register_data(), ['name' => '']));

		$response->assertStatus(400);
		$user = User::all();
		$this->assertCount(0, $user);
	}

	/** @test */
	public function email_is_required_in_registeration()
	{
		// $this->withoutExceptionHandling();

		$response = $this->post('/api/user/register', array_merge($this->register_data(), ['email' => '']));

		$response->assertStatus(400);
		$user = User::all();
		$this->assertCount(0, $user);
	}

	/** @test */
	public function birthDate_is_required_in_registeration()
	{
		// $this->withoutExceptionHandling();

		$response = $this->post('/api/user/register', array_merge($this->register_data(), ['birthDate' => '']));

		$response->assertStatus(400);
		$user = User::all();
		$this->assertCount(0, $user);
	}

	/** @test */
	public function email_is_unique_in_registeration()
	{
		// $this->withoutExceptionHandling();

		$response = $this->post('/api/user/register', $this->register_data());
		$response = $this->post('/api/user/register', $this->register_data());

		$response->assertStatus(409);
		$user = User::all();
		$this->assertCount(1, $user);
	}

	/** @test */
	public function email_is_required_in_login()
	{
		// $this->withoutExceptionHandling();
		$response = $this->post('/api/user/login', array_merge($this->login_data(), ['email' => '']));
		$response->assertStatus(401);
	}

	/** @test */
	public function password_is_required_in_login()
	{
		// $this->withoutExceptionHandling();
		$response = $this->post('/api/user/login', array_merge($this->login_data(), ['password' => '']));
		$response->assertStatus(401);
	}

	/** @test */
	public function user_can_logout()
	{
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['logout']
		);
		// dd('' . $user);
		$response = $this->post('/api/user/logout');
		$response->assertStatus(200);
	}

	private function register_data()
	{
		return [
			'name' => 'Mohamed',
			'email' => 'mohamed@gmail.com',
			'birthDate' => 'Mon Jul 13 2020 11:48:18 GMT+0200'
		];
	}
	private function login_data()
	{
		return [
			'email' => 'mohamed@gmail.com',
			'password' => 'password'
		];
	}
}
