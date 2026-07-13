<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

/**
 * Renders the public work / case-study pages.
 */
class WorkController extends Controller
{
    /**
     * List all case studies, paginated once the count grows (FR2).
     */
    public function index(): View
    {
        return view('pages.work.index', [
            'projects' => Project::query()->ordered()->paginate(9),
        ]);
    }

    /**
     * Show a single case study with prev/next navigation across the ordered set.
     */
    public function show(Project $project): View
    {
        $ordered = Project::query()->ordered()->get();
        $index = $ordered->search(fn (Project $item): bool => $item->is($project));

        // Surface any approved testimonials tied to this project (MR4).
        $project->load(['testimonials' => fn ($query) => $query->approved()->latest()]);

        return view('pages.work.show', [
            'project' => $project,
            'testimonials' => $project->testimonials,
            'previous' => $index > 0 ? $ordered->get($index - 1) : null,
            'next' => $ordered->get($index + 1),
        ]);
    }
}
