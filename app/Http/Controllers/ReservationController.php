<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\Price;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        //
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $Datareservation = Reservation::when($search, function ($query) use ($search) {
                $query->where('confirmationCode', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('surname', 'like', '%' . $search . '%')
                    ->orWhere('phoneNumber', 'like', '%' . $search . '%');
            })->latest()->paginate(6);
        } else {
            $reservation = Reservation::latest()->paginate(6);
        }

        return view('reservation.index', compact('Datareservation'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Dohvatanje ID-ja hotela iz URL-a

        $hotelId = $request->input('hotel');
        if($hotelId) {
        $destinationId = $request->input('destination');

        // Dohvatanje hotela na osnovu ID-ja
        $resHotel = Hotel::find($hotelId);


        // Provera da li je hotel pronađen
        if (!$resHotel) {
            //greska da hotel nije pronadjen
            return redirect()->route('error')->with('message', 'Hotel nije pronađen.');
        }
        //dohvatanje podataka iz tabele PRICES preko odredjenog hotela
        $prices = $resHotel->prices;
        //dohvatanje podataka iz tabele Destinations preko odredjenog hotela
        $destination = $resHotel->destination;

        // Sada je  $resHotel sa svim podacima o hotelu na osnovu ID-ja
        //sada se racuna cena koja se prikazuje u zavisnosti od datuma rezervacije!!
        if ($prices->isNotEmpty()) {
            $Standardprice = $prices->first()->price;
            $firstPrice = $prices->first()->firstMin;
            $lastPrice = $prices->first()->lasteMin;
            $ConditionFirstPrice = $prices->first()->firstOnly; //uslova u broju dana od momenta kriranja
            $ConditionLastPrice = $prices->first()->lastOnly; //uslov u broju dana do realizacije
            $created = $prices->first()->created_at;
            $carbonFirstMinDate = Carbon::parse($created); //momenat kreiranja
            $ReservationFrstMin = $carbonFirstMinDate->addDays($ConditionFirstPrice); //za kreiranje do ovog datuma je firstminute
        }

        if ($destination) {
            $start = $destination->startDate;
            $carbonStart = Carbon::parse($start);
            $startLastMin = $carbonStart->subDays($ConditionLastPrice);
        }

        $today = Carbon::now(); // Dohvatanje trenutnog datuma

        if ($startLastMin->lessThanOrEqualTo($today)) {  //ako je start datum manji ili isti kao danasnji LastMinute
            $p = $lastPrice;
        } elseif ($today->lessThanOrEqualTo($ReservationFrstMin)) {
            $p = $firstPrice;
        } else {
            $p = $Standardprice;
        }

        return view('reservation.create', [
            'hotelId' => $hotelId, 'resHotel' => $resHotel, 'prices' => $prices, 'destination' => $destination, 'p' => $p,
            'Standardprice' => $Standardprice,
            'firstPrice' => $firstPrice, 'lastPrice' => $lastPrice, 'destinationId' => $destinationId
        ]);
    }

        else {
            $destinationId = $request->input('destination');
            $destination = Destination::find($destinationId);
            $prices=$destination->priceTrip;
            $hotelId=null;
            $resHotel=null;
           

            return view('reservation.create', [
                 'prices' => $prices, 'destination' => $destination, 
               
                 'destinationId' => $destinationId, 'hotelId'=>$hotelId, 'resHotel'=>$resHotel
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    private function generateUniqueCode()
    {
        //return $uniqueCode;
        return Reservation::max('confirmationCode') + 1; //generise cod za kopiju
    }
    public function store(Request $request)
    {
        //
        //validacija podataka
        $formFilds = $request->validate([
            'name' => 'required',
            'surname' => 'required|regex:/^[\pL\s\-]+$/u', //omogućava unos slova (pomoću \pL), razmaka (pomoću \s), i znaka "-" (poznatog i kao "minus") u prezimenu. 
            'phoneNumber' => 'required|regex:/^[0-9\+]+$/', //ograničava unos samo na brojeve (0-9) i plus znak (+) ako je neko van zemlje da unese +pozivni broj
            'passingerNumbers' => 'required|in:1,2,3,4,5',

        ]);

      //proveravamo ko je user, u zavisnosti da li je admin ili ne dalje sledi kod
        $user = Auth::user();
    //provera koja je rola korisnik
        $userRole = $user->roles->first();
        $destinationId = $request->input('destination_id');

        // Ako korisnik nije admin (admin je  id 1) 
        // if ($user->id !== 1) {
            if ($userRole && $userRole->type !== 1) {
            $existingReservation = $user->reservations->where('destination_id', $destinationId)->first();

            if ($existingReservation) {
                // ima destinaciju vec rezervisanu, obavestavamo ga i preusmeravamo na spisak ponuda
                session()->flash('alertType', 'danger');
                session()->flash('alertMsg', 'Već imate rezervisano ovo putovanje');
                return redirect()->route('destination.index');
            }
        }

        ////////////////

        //unos koda potvrde ako je prazna tabela ond je unos 100. svaki sledeci ima unos +1 u odnosu na prethodni
        $tableReservation = DB::table('reservations')->get();
        if ($tableReservation->isEmpty()) {
            $formFilds['confirmationCode'] = 100;
        } else {
            $formFilds['confirmationCode'] = $this->generateUniqueCode();
        }

        $formFilds['hotel_id'] = $request->input('hotel_id'); // hotel Id poslat preko forme kroz sakriven input 
        $formFilds['destination_id'] = $request->input('destination_id');

        $hotelId = $formFilds['hotel_id'];
        // $destinationId=$formFilds['destination_id'];


        //samo kad je izlet u pitanju tad je hotelID== null
        if ($hotelId === null) {
            $destinationId = $request->input('destination_id');
            $destination = Destination::where('id', $destinationId)->first();
            $formFilds['reservationPrice']=$destination->priceTrip;
            $formFilds['dateReservation'] = now();
            $formFilds['user_id'] = Auth::user()->id;
         }
         //kada su sva druga putovanja u pitanju
         else {
        // Dohvatanje hotela na osnovu ID-ja
        $resHotel = Hotel::find($hotelId);


        // Provera da li je hotel pronađen
        if (!$resHotel) {
            //greska da hotel nije pronadjen

        }

        
        
        //dohvatanje podataka iz tabele PRICES preko odredjenog hotela
        $prices = $resHotel->prices;
        //dohvatanje podataka iz tabele Destinations preko odredjenog hotela
        $destination = $resHotel->destination;

        // Sada je  $resHotel sa svim podacima o hotelu na osnovu ID-ja
        //sada se racuna cena koja se prikazuje u zavisnosti od datuma rezervacije!!
        if ($prices->isNotEmpty()) {
            $Standardprice = $prices->first()->price;
            $firstPrice = $prices->first()->firstMin;
            $lastPrice = $prices->first()->lasteMin;
            $ConditionFirstPrice = $prices->first()->firstOnly; //uslova u broju dana od momenta kriranja
            $ConditionLastPrice = $prices->first()->lastOnly; //uslov u broju dana do realizacije
            $created = $prices->first()->created_at;
            $carbonFirstMinDate = Carbon::parse($created); //momenat kreiranja
            $ReservationFrstMin = $carbonFirstMinDate->addDays($ConditionFirstPrice); //za kreiranje do ovog datuma je firstminute
        }

        if ($destination) {
            $start = $destination->startDate;
            $carbonStart = Carbon::parse($start);
            $startLastMin = $carbonStart->subDays($ConditionLastPrice);
        }

        $today = Carbon::now(); // Dohvatanje trenutnog datuma

        if ($startLastMin->lessThanOrEqualTo($today)) {  //ako je start datum manji ili isti kao danasnji LastMinute
            $p = $lastPrice;
        } elseif ($today->lessThanOrEqualTo($ReservationFrstMin)) {
            $p = $firstPrice;
        } else {
            $p = $Standardprice;
        }
        $formFilds['reservationPrice'] = $p;

        //upis datuma za rezervaciju
        $formFilds['dateReservation'] = now();

        //upis hotel_id u db
        // $formFilds['hotel_id']=  $hotelId; //nparvljena je var hotelId da bi se moglo raditi sa njom prilikom upisa cene
        //upis user id
        $formFilds['user_id'] = Auth::user()->id;


        //passingerNumbers
        $reservation = Reservation::all();
        $hotels = Hotel::all();
        $hotel = $hotels->where('id', $hotelId)->first(); //od svih hotela hotel je samo naj ciji id je isti kao id iz urla
        // Dohvatite broj slobodnih mesta u hotelu
        $ukupnoMesta = $hotel->number;

        // Dohvatite ukupan broj zauzetih mesta u svim rezervacijama za taj hotel
        $zauzeto = Reservation::where('hotel_id', $hotelId)->sum('passingerNumbers');

        // Izračunajte broj slobodnih mesta
        $slobodno = $ukupnoMesta - $zauzeto;

        // Postavljanje broja putnika na minimum između broja putnika koje je korisnik uneo i dostupnih slobodnih mesta
        $formFilds['passingerNumbers'] = min($formFilds['passingerNumbers'], $slobodno);

    }

        //dd($formFilds);
        //kreiranje
        Reservation::create($formFilds);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno ste rezervisali putovanje');

        return redirect()->route('destination.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
       
      

        return view('reservation.show', [
            'reservation'=>$reservation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
        // return view('reservation.edit', [
        //     'reservation' => $reservation
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
        $reservation->delete();
        return redirect()->route('reservation.index');
    }
}
