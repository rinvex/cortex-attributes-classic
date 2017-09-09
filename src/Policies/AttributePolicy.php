<?php

declare(strict_types=1);

namespace Cortex\Attributes\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rinvex\Attributes\Contracts\AttributeContract;

class AttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list attributes.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create attributes.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the attribute.
     *
     * @param string                                           $ability
     * @param \Rinvex\Fort\Contracts\UserContract              $user
     * @param \Rinvex\Attributes\Contracts\AttributeContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, AttributeContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update attributes
    }

    /**
     * Determine whether the user can delete the attribute.
     *
     * @param string                                           $ability
     * @param \Rinvex\Fort\Contracts\UserContract              $user
     * @param \Rinvex\Attributes\Contracts\AttributeContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, AttributeContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability)   // User can delete attributes
               && ! $resource->entities()->count();                     // RESOURCE attribute has no entities attached
    }
}
