<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * Thrown when a post is set to published while still missing the fields that
 * the content-quality gate requires (requirements FR17): a slug, a meta
 * description, and alt text for any cover image.
 */
class PostNotPublishableException extends Exception
{
    /**
     * Build the exception from the list of missing requirements.
     *
     * @param  list<string>  $missing
     */
    public static function missing(array $missing): self
    {
        return new self('A post cannot be published until it has: '.implode(', ', $missing).'.');
    }
}
