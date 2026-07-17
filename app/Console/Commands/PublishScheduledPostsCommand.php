<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('posts:publish-scheduled')]
#[Description('Publish posts that are scheduled and whose time has arrived')]
class PublishScheduledPostsCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $posts = \App\Models\Post::query()
            ->where('status', \App\Enums\PostStatus::Scheduled)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->info('No scheduled posts to publish.');
            return;
        }

        $users = \App\Models\User::all();

        foreach ($posts as $post) {
            // Need to update using updateQuietly or update to bypass validation if needed
            $post->update(['status' => \App\Enums\PostStatus::Published]);

            \Filament\Notifications\Notification::make()
                ->title('Scheduled Post Published')
                ->body("The post '{$post->title}' is now live on the blog.")
                ->success()
                ->sendToDatabase($users);

            $this->info("Published scheduled post: {$post->title}");
        }
    }
}
