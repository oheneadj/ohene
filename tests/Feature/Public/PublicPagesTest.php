<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\Project;
use App\Models\Testimonial;

it('renders the home page with featured work and latest posts', function () {
    $project = Project::factory()->featured()->create(['title' => 'Featured Build']);
    $post = Post::factory()->create(['title' => 'A Fresh Post', 'published_at' => now()->subDay()]);
    Testimonial::factory()->approved()->create(['client_name' => 'Happy Client']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Featured Build')
        ->assertSee('A Fresh Post')
        ->assertSee('Happy Client');
});

it('lists case studies on the work index', function () {
    Project::factory()->create(['title' => 'Listed Project']);

    $this->get(route('work.index'))
        ->assertOk()
        ->assertSee('Listed Project');
});

it('shows a case study by its slug', function () {
    $project = Project::factory()->create(['slug' => 'my-case-study', 'title' => 'My Case Study']);

    $this->get(route('work.show', $project))
        ->assertOk()
        ->assertSee('My Case Study')
        ->assertSee($project->tagline);
});

it('404s for an unknown case study slug', function () {
    $this->get('/work/does-not-exist')->assertNotFound();
});

it('shows a case study\'s approved testimonial but not pending ones (MR4)', function () {
    $project = Project::factory()->create(['slug' => 'with-quote']);

    Testimonial::factory()->approved()->for($project)->create(['quote' => 'Brilliant work, shipped on time.']);
    Testimonial::factory()->for($project)->create(['quote' => 'This one is still pending review.']);

    $this->get(route('work.show', $project))
        ->assertOk()
        ->assertSee('Brilliant work, shipped on time.')
        ->assertDontSee('This one is still pending review.');
});

it('links prev/next between ordered case studies', function () {
    $first = Project::factory()->create(['display_order' => 1, 'title' => 'First Project']);
    $second = Project::factory()->create(['display_order' => 2, 'title' => 'Second Project']);

    $this->get(route('work.show', $first))->assertSee('Second Project');
    $this->get(route('work.show', $second))->assertSee('First Project');
});

it('lists only published posts on the blog index', function () {
    Post::factory()->create(['title' => 'Published Post', 'published_at' => now()->subDay()]);
    Post::factory()->draft()->create(['title' => 'Hidden Draft']);

    $this->get(route('blog.index'))
        ->assertOk()
        ->assertSee('Published Post')
        ->assertDontSee('Hidden Draft');
});

it('shows a published post and its related posts', function () {
    $post = Post::factory()->create(['slug' => 'main-post', 'title' => 'Main Post', 'published_at' => now()->subDay()]);
    Post::factory()->create([
        'category_id' => $post->category_id,
        'title' => 'Related Post',
        'published_at' => now()->subDays(2),
    ]);

    $this->get(route('blog.show', $post))
        ->assertOk()
        ->assertSee('Main Post')
        ->assertSee('Related Post');
});

it('404s when viewing an unpublished post directly', function () {
    $draft = Post::factory()->draft()->create(['slug' => 'secret-draft']);

    $this->get(route('blog.show', $draft))->assertNotFound();
});

it('renders the standalone pages', function (string $route) {
    $this->get(route($route))->assertOk();
})->with(['about', 'videos', 'contact', 'privacy']);

it('renders a styled 404 for unknown urls', function () {
    $this->get('/no-such-page')
        ->assertNotFound()
        ->assertSee('wrong turn');
});
