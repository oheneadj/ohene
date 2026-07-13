<?php

declare(strict_types=1);

namespace App\Policies;

/**
 * Authorization policy for blog categories. Standard single-admin access.
 */
class CategoryPolicy extends AdminPolicy {}
