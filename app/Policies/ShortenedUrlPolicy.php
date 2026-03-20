<?php

namespace App\Policies;

use App\Models\ShortenedUrl;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class ShortenedUrlPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShortenedUrl $shortenedUrl): bool
    {
        //echo 'inside policy view';
        return $user->id === $shortenedUrl->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShortenedUrl $shortenedUrl): bool
    {
        return $user->id === $shortenedUrl->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShortenedUrl $shortenedUrl): bool
    {
        return $user->id === $shortenedUrl->user_id;
    }


}
