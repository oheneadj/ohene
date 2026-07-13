<?php

declare(strict_types=1);

namespace App\Policies;

/**
 * Authorization policy for blog posts. Standard single-admin access.
 */
class PostPolicy extends AdminPolicy {}
