<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Base authorization policy for the single-admin CMS (requirements FR6).
 *
 * Panel access is already gated by User::canAccessPanel(), so any user who
 * reaches a resource is the vetted admin and may manage content. Per-model
 * policies extend this and override only where a resource needs to differ
 * (e.g. leads are read-only). This keeps the "every resource is policy-backed"
 * rule (CLAUDE.md Section 18) without duplicating identical logic six times.
 */
abstract class AdminPolicy
{
    /**
     * Can the admin see the resource listing?
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Can the admin view a single record?
     */
    public function view(User $user, Model $model): bool
    {
        return true;
    }

    /**
     * Can the admin create records?
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Can the admin update a record?
     */
    public function update(User $user, Model $model): bool
    {
        return true;
    }

    /**
     * Can the admin delete a record?
     */
    public function delete(User $user, Model $model): bool
    {
        return true;
    }

    /**
     * Can the admin bulk-delete records?
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }
}
