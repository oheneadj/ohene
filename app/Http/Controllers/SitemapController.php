<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

/**
 * Builds sitemap.xml on the fly so it's always current (FR11) — every published
 * post and project is included with its last-modified date.
 */
class SitemapController extends Controller
{
    /**
     * Render the full sitemap.
     */
    public function __invoke(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setPriority(1.0))
            ->add(Url::create(route('work.index')))
            ->add(Url::create(route('blog.index')))
            ->add(Url::create(route('about')))
            ->add(Url::create(route('videos')))
            ->add(Url::create(route('contact')));

        Project::query()->ordered()->get()->each(function (Project $project) use ($sitemap): void {
            $sitemap->add(
                Url::create(route('work.show', $project))->setLastModificationDate($project->updated_at)
            );
        });

        Post::query()->published()->get()->each(function (Post $post) use ($sitemap): void {
            $sitemap->add(
                Url::create(route('blog.show', $post))->setLastModificationDate($post->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }
}
