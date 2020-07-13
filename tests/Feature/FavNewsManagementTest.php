<?php

namespace Tests\Feature;

use App\News;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;


class FavNewsManagementTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function logged_in_user_can_get_his_fav_list()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);

		$response = $this->get('/api/new');

		$response->assertStatus(200);
	}

	/** @test */
	public function logged_in_user_can_save_new_to_his_fav_list()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', $this->data($newData));

		$response->assertStatus(200);
		$this->assertCount(1, News::all());

	}

	/** @test */
	public function source_is_required()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['source' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function author_is_required()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['author' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function title_is_required()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['title' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function description_is_required()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['description' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function url_is_required()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['url' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function urlToImage_is_required()
	{
		// $this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['urlToImage' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function publishedAt_is_required()
	{
		$this->withoutExceptionHandling();
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->make(['userId' => $user->id]);

		$response = $this->post('/api/new', array_merge($this->data($newData), ['publishedAt' => '']));

		$response->assertStatus(400);
	}

	/** @test */
	public function logged_in_user_can_delete_new_from_his_fav_list()
	{
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$newData = factory(News::class)->create(['userId' => $user->id]);
		$this->assertCount(1, News::all());

		$response = $this->delete('/api/new/'.$newData->id);

		$response->assertStatus(200);
		$this->assertCount(0, News::all());
	}

	/** @test */
	public function logged_in_user_cannot_delete_new_not_in_his_fav_list()
	{
		Passport::actingAs(
			$user = factory(User::class)->create(),
			['new']
		);
		$this->assertCount(0, News::all());

		$response = $this->delete('/api/new/1');

		$response->assertStatus(400);
		$this->assertCount(0, News::all());
	}


	private function data($newData)
	{
		return [
			'userId' => $newData->userId,
			'source' => $newData->source,
			'author' => $newData->author,
			'type' => $newData->type,
			'title' => $newData->title,
			'description' => $newData->description,
			'url' => $newData->url,
			'urlToImage' => $newData->urlToImage,
			'publishedAt' => $newData->publishedAt,
		];
	}
}
