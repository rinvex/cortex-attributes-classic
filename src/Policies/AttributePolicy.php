<?php

declare(strict_types=1);

namespace Cortex\Attributable\Policies;

use Cortex\Fort\Models\User;
use Cortex\Attributable\Models\Attribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list attributes.
     *
     * @param string                   $ability
     * @param \Cortex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create attributes.
     *
     * @param string                   $ability
     * @param \Cortex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the attribute.
     *
     * @param string                                $ability
     * @param \Cortex\Fort\Models\User              $user
     * @param \Cortex\Attributable\Models\Attribute $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Attribute $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update attributes
    }

    /**
     * Determine whether the user can delete the attribute.
     *
     * @param string                                $ability
     * @param \Cortex\Fort\Models\User              $user
     * @param \Cortex\Attributable\Models\Attribute $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Attribute $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability)   // User can delete attributes
               && ! $resource->entities()->count();                     // RESOURCE attribute has no entities attached
    }
}
