<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=Feedback::latest()->get();
        return view('feedback.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user=Auth::user();
        $userId=$user->id;
        $destination = Destination::all();
        // $reservation = Reservation::all();
        $reservation = Reservation::where('user_id',  $userId)->get();
        return view('feedback.create', compact('reservation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $userId=$user->id;
           $reservation = Reservation::where('user_id',  $userId)->get();
        $form = $request->validate([
            'destination_id' => [
                'required',
                Rule::in($reservation->pluck('destination_id')->toArray()), // provjera da li se nalazi među opcijama izvuceno iz reservation i vuce id destinacije
            ],
            'feedback' => 'required',
            'star' => 'required|in:1,2,3,4,5',
        ]);
        
        //ako korisnik vec ima ostavljenu recenziju za odredjenu destinaciju ne moze ponovo da ostavi
        $userRole = $user->roles->first(); //preuzima se rola za korisnika
        $destinationId = $form['destination_id'];  //destinacija ID je iz forme
        if ($userRole && $userRole->type !== 1) {
            $existingReservation = $user->feedbacks->where('destination_id', $destinationId)->first();

            if ($existingReservation) {
                // ima destinaciju vec rezervisanu, obavestavamo ga i preusmeravamo na aboutUs stranicu
                session()->flash('alertType', 'danger');
                session()->flash('alertMsg', 'Vec imate ostavljenu recenziju za ovo putovanje');
                return redirect()->route('aboutUs');
            }
        }

        if ($userRole && $userRole->type === 1 ) {
             // admin ne moze da ostavlja recenzije
             session()->flash('alertType', 'danger');
             session()->flash('alertMsg', 'Admin ne moze da ostavlja recenzije');
             return redirect()->route('aboutUs');
        }
        $form['user_id'] = $userId=$user->id;
    //  dd($form);
        $feedback = Feedback::create($form);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno kreirana recenzija!');

        return redirect()->route('destination.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
        $feedback->delete();
        return redirect()->route('feedback.index');
    }

    public function aboutUs() {
        if (auth()->check()) {
            $CurrentUser = Auth::user();
            $userId = $CurrentUser->id;
            $Checkreservation = Reservation::where('user_id', $userId)->get();
        } else {
            $Checkreservation = [];
        }

        // data je feddback sa profilima i reservacijama preko userima i tu je uradjena paginacija. Ne moze load zbog paginacije
        $data = Feedback::with('user.profile', 'user.reservations')->latest()->paginate(5);
    
        return view('feedback.aboutUs', [
            'data' => $data,
            'CurrentUser' => $CurrentUser ?? null,
            'Checkreservation' => $Checkreservation
        ]);
    }

    //moji feedbackovi
    public function myfeedbacks() {
        return view('feedback.myfeedbacks', ['feedback'=> auth()->user()->feedbacks()->get()]);

        //feedbacks() je iz modela user realtionship
    }
    
}
