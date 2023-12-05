<?php

namespace App\Policies;


use App\Models\User;
use App\Models\Reservation;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return  $user->role_id === 2;
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        //
        $roleType2 = $user->roles->firstWhere('type', 2);

        return $roleType2 !== null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $roleType2 = $user->roles->firstWhere('type', 2);

        return $roleType2 !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    // public function update(User $user, Reservation $reservation): bool
    // {
    //     // Proveri da li je korisnik ima ulogu tipa 2 ili je vlasnik rezervacije
    // $roleType2 = $user->roles->firstWhere('type', 2);

    // // Proveri da li je korisnik vlasnik rezervacije koju pokušava da menja
    // $isOwner = $user->id === $reservation->user_id;

    // // Dozvoli ažuriranje ako korisnik ima ulogu tipa 2 ili je vlasnik rezervacije
    // return $roleType2 !== null || $isOwner;
    // }

    /**
     * Determine whether the user can delete the model.
     */
    // public function delete(User $user, Reservation $reservation): bool
    // {
    //      // Proveri da li je korisnik ima ulogu tipa 2 ili je vlasnik rezervacije
    // $roleType2 = $user->roles->firstWhere('type', 2);

    // // Proveri da li je korisnik vlasnik rezervacije koju pokušava da brise
    // $isOwner = $user->id === $reservation->user_id;

    // // Dozvoli brisanje ako korisnik ima ulogu tipa 2 ili je vlasnik rezervacije
    // return $roleType2 !== null || $isOwner;
    // }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Reservation $reservation): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Reservation $reservation): bool
    // {
    //     //
    // }
}
