<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorization policy for leads.
 *
 * Leads are read-only in the admin (requirements FR7): they're created by the
 * public contact form, never by hand, and are never deleted here — only their
 * follow-up status is updated. So we deny create and delete outright.
 */
class LeadPolicy extends AdminPolicy
{
    /**
     * Leads are never created from the admin — only via the public form.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Leads are a permanent record of inbound interest; no deletion.
     */
    public function delete(User $user, Model $model): bool
    {
        return false;
    }

    /**
     * No bulk deletion of leads either.
     */
    public function deleteAny(User $user): bool
    {
        return false;
    }
}
