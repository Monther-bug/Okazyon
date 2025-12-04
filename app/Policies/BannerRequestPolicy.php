<?php

namespace App\Policies;

use App\Models\BannerRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BannerRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->type === 'admin' || $user->type === 'seller';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BannerRequest $bannerRequest): bool
    {
        return $user->type === 'admin' || $user->id === $bannerRequest->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->type === 'seller';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BannerRequest $bannerRequest): bool
    {
        return $user->type === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BannerRequest $bannerRequest): bool
    {
        return $user->type === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BannerRequest $bannerRequest): bool
    {
        return $user->type === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BannerRequest $bannerRequest): bool
    {
        return $user->type === 'admin';
    }
}
