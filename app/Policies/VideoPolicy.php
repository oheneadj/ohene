<?php

declare(strict_types=1);

namespace App\Policies;

/**
 * Authorization policy for videos. Standard single-admin access.
 */
class VideoPolicy extends AdminPolicy {}
