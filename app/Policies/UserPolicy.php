<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {     
        // dd($user->roles);
        //
        //dd($user);
        //dd('Policy executed');
        // if (auth()->check()) {
        //     dd($user->roles);
        // }
        $roleType1 = $user->roles->firstWhere('type', 1);

        return $roleType1 !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool


    {
        // dd($user->roles);

        $roleType1 = $user->roles->firstWhere('type', 1);
    
        return $roleType1 !== null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
       // dd($user->roles);
        $roleType1 = $user->roles->firstWhere('type', 1);

        return $roleType1 !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        //
        //return $user->role_id === 1;
        $roleType1 = $user->roles->firstWhere('type', 1);

        return $roleType1 !== null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
  // Proveri da li korisnik ima ulogu tipa 1
  return $user->roles->firstWhere('type', 1) !== null;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, User $model): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, User $model): bool
    // {
    //     //
    // }
}
