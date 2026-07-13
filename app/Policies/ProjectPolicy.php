<?php

declare(strict_types=1);

namespace App\Policies;

/**
 * Authorization policy for case-study projects. Standard single-admin access.
 */
class ProjectPolicy extends AdminPolicy {}
