<?php

declare(strict_types=1);

namespace Cortex\Attributes\Policies;

use Rinvex\Fort\Models\User;
use Rinvex\Attributes\Models\Attribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list attributes.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create attributes.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the attribute.
     *
     * @param string                                         $ability
     * @param \Rinvex\Fort\Models\User            $user
     * @param \Rinvex\Attributes\Models\Attribute $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Attribute $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update attributes
    }

    /**
     * Determine whether the user can delete the attribute.
     *
     * @param string                                         $ability
     * @param \Rinvex\Fort\Models\User            $user
     * @param \Rinvex\Attributes\Models\Attribute $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Attribute $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability)   // User can delete attributes
               && ! $resource->entities()->count();                     // RESOURCE attribute has no entities attached
    }
}
