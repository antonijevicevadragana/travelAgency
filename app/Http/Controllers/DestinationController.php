<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination = Destination::when($search, function ($query) use ($search) {
                $query->where('state', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('transportation', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('startDate', 'like', '%' . $search . '%');
            })->latest()->get();
        } else {
            $destination = Destination::latest()->get();
        }


        return view('destination.index', compact('destination'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('destination.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validacija podataka
        $formFilds = $request->validate([
            'state' => 'required|regex:/^[\pL\s]+$/u',
            'city' => 'required|regex:/^[\pL\s]+$/u',
            'coverImage' => 'required|image|between:1,5000',
            'startDate' => 'required',
            'endDate' => 'required',
            'startCity' => 'required',
            'startCity' => 'required',
            'number' => 'nullable',
            'transportation' => 'required|in:autobus,avion',
            'type' => 'required|in:letovanje,zimovanje,izlet,cityBreak',
            'descriptionSrb' => 'required',
            'descriptionEng' => 'required',
            'priceTrip' => 'nullable',
            'stateEng' => 'required|regex:/^[\pL\s]+$/u',
            'cityEng'=>'required'

        ]);

        if ($request->hasFile('coverImage')) {
            $formFilds['coverImage'] = $request->file('coverImage')->store('ImageDestination', 'public'); //ako ima slike da se cuva u ImageDestination u public folderu(store)
        }

        //dd($formFilds);
        //kreiranje
        Destination::create($formFilds);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno krirana destinacija!');
        return redirect()->route('destination.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        $destinationId = $destination->id;
        $hotels = Hotel::where('destination_id', $destinationId)->get();
        $totalNum = $hotels->sum('number');
        $today = Carbon::now();
        $auth = Auth::user(); //trenutni user


        $e = '€';
        $currentPrices = [];  //prazan array za trenutne cene $currentPrices
        $price = [];
        $start = $destination->startDate; //$start je morala da se definise prvo izvan foreacha iz razloga da bi i destinacije za koje jos nije popunjen hotel imale show prikaz bez gresaka. Tako je i $price =[] i $currentPrice=[];


        foreach ($hotels as $hotel) {  //prolazimo kroz svaki hotel
            if ($hotel->prices) { //ako ima vezu sa cenama
                foreach ($hotel->prices as $priceModel) { //prolazimo kroz svaku cenu hotela
                    $Standardprice = $priceModel->price;
                    $firstPrice = $priceModel->firstMin;
                    $lastPrice = $priceModel->lasteMin;
                    $ConditionFirstPrice = $priceModel->firstOnly;
                    $ConditionLastPrice = $priceModel->lastOnly;
                    $created = $priceModel->created_at;

                    $carbonFirstMinDate = Carbon::parse($created); //kreiran oglas za putpvanje
                    $ReservationFrstMin = $carbonFirstMinDate->addDays($ConditionFirstPrice);



                    $start = $destination->startDate; //datum polaska na putovanje
                    $carbonStart = Carbon::parse($start);
                    $startLastMin = $carbonStart->subDays($ConditionLastPrice);
                    if ($startLastMin->lessThanOrEqualTo($today)) {
                        $currentPrices[$hotel->id] = $lastPrice . $e .  ' Last Minute'; //$currentPrices po id hotela stavljamo cene
                    } elseif ($today->lessThanOrEqualTo($ReservationFrstMin)) {
                        $currentPrices[$hotel->id] = $firstPrice . $e .  ' First Minute';
                    } else {
                        $currentPrices[$hotel->id] = "";
                    }

                    $price[$hotel->id] = $Standardprice . $e; //osnovna cena

                }
            }
        }

        return view('destination.show', [
            'destination' => $destination, 'hotels' => $hotels, 'destinationId' => $destinationId, 'totalNum' => $totalNum, 'currentPrices' => $currentPrices, 'price' => $price, 'auth' => $auth, 'start' => $start,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        //
        return view('destination.edit', [
            'destination' => $destination
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        //
        $formFilds = $request->validate([
            'state' => 'required|regex:/^[\pL\s]+$/u',
            'city' => 'required|regex:/^[\pL\s]+$/u',
            'coverImage' => 'image|between:1,5000',
            'startDate' => 'required',
            'endDate' => 'required',
            'startCity' => 'required',
            'type' => 'in:letovanje,zimovanje,izlet,cityBreak',
            'number' => 'nullable',
            'transportation' => 'required|in:autobus,avion',
            'descriptionSrb' => 'required',
            'descriptionEng' => 'required',
            'priceTrip' => 'nullable',
            'stateEng' => 'required',
            'cityEng'=>'required'

        ]);
        if ($request->hasFile('coverImage')) {
            $formFilds['coverImage'] = $request->file('coverImage')->store('ImageDestination', 'public'); //ako ima slike da se cuva u ImageDestination u public folderu(store)
        }

        //dd($formFilds);
        $destination->update($formFilds);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno izmenjena destinacija!');
        return redirect()->route('all');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        //Destinacija moze da se brise samo ako sa njom nije povezan neki hotel ili rezervacija
        // Provera da li postoji povezani hotel ili rezervacija
        $hotelCount = Hotel::where('destination_id', $destination->id)->count();
        $reservationCount = Reservation::where('destination_id', $destination->id)->count();

        if ($hotelCount > 0 || $reservationCount > 0) {
            // Ako postoji povezani hotel ili rezervacija redirektuj i  prikaži odgovarajuću poruku
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Podatak ne moze biti obrisan. Postoji hotel ili rezervacija povezani sa istim.');
            return redirect()->route('all');
        } else {
            $destination->delete();
            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Uspesno obrisano.');
            return redirect()->route('destination.index');
        }
    }

    public function last()
    {
        $dest = []; // Niz za destinacije sa last minute ponudama
        $hotelName = []; //prazan arrray za nazive hotela

        // Prolazimo kroz sve destinacije
        $hotel = Hotel::all();
        $destinations = Destination::all();
        foreach ($destinations as $destination) {
            $hasLastMinute = false; // Postavljamo na false za svaku destinaciju

            // Prolazimo kroz sve hotele povezane sa destinacijom
            $hotels = Hotel::where('destination_id', $destination->id)->get();
            foreach ($hotels as $hotel) {
                $name = $hotel->name;
                if ($hotel->prices) {
                    foreach ($hotel->prices as $priceModel) {
                        $ConditionLastPrice = $priceModel->lastOnly;
                        $today = now();
                        $carbonStart = Carbon::parse($destination->startDate);
                        $startLastMin = $carbonStart->subDays($ConditionLastPrice);

                        if ($startLastMin->lessThanOrEqualTo($today)) {
                            // Kada je pronađena destinacija sa LastMinute cenom, postavljamo $hasLastMinute da je tačno
                            $hasLastMinute = true;

                            // Ako smo našli LastMinute ponudu, dodajemo hotel u niz i NASTAVLJAMO petlju za hotele
                            $hotelName[] = $hotel;
                        }
                    }
                }
                if ($hasLastMinute) {
                    // Ako smo našli LastMinute ponudu, dodajemo destinaciju u niz
                    $dest[] = $destination;
                }
            }
        }

        return view('destination.last', ['dest' => $dest,  'hotelName' => $hotelName]);
    }



    public function first()
    {
        $dest = []; // Niz za destinacije sa first minute ponudama
        $hotelName = []; //prazan arrray za nazive hotela

        // Prolazimo kroz sve destinacije
        $hotel = Hotel::all();
        $destinations = Destination::all();
        foreach ($destinations as $destination) {
            $hasFirstMinute = false; // Postavljamo na false za svaku destinaciju

            // Prolazimo kroz sve hotele povezane sa destinacijom
            $hotels = Hotel::where('destination_id', $destination->id)->get();
            foreach ($hotels as $hotel) {
                $name = $hotel->name;
                if ($hotel->prices) {
                    foreach ($hotel->prices as $priceModel) {
                        $ConditionLastPrice = $priceModel->firstOnly;
                        $today = now();
                        $start = $priceModel->created_at;
                        $carbonStart = Carbon::parse($priceModel->created_at);  // Datum kreiranja
                        $startFirstMin =  $carbonStart->addDays($ConditionLastPrice);

                        if ($today->lessThanOrEqualTo($startFirstMin)) {
                            // Kada je pronađena destinacija sa firstMinute cenom, postavljamo $hasFirstMinute da je tačno
                            $hasFirstMinute = true;

                            // Ako smo našli FirstMinute ponudu, dodajemo hotel u niz i NASTAVLJAMO petlju za hotele
                            $hotelName[] = $hotel;
                        }
                    }
                }
                if ($hasFirstMinute) {
                    // Ako smo našli FirstMinute ponudu, dodajemo destinaciju u niz
                    $dest[] = $destination;
                }
            }
        }

        return view('destination.first', ['dest' => $dest,  'hotelName' => $hotelName, 'carbonStart' => $carbonStart, 'start' => $start]);
    }

    //Zimovanje
    public function winter(Request $request)
    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination = Destination::when($search, function ($query) use ($search) {
                $query->where('state', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('transportation', 'like', '%' . $search . '%')
                    ->orWhere('startDate', 'like', '%' . $search . '%');
            })->where('type', 'zimovanje')->latest()->get();  
        } else {
            $destination = Destination::where('type', 'zimovanje')->latest()->get();
        }


        return view('destination.winter', compact('destination'));
        //u view ce se uraditi prikaz samo gde je type zimovanje.
    }

    //Letovanje
    public function summer(Request $request)

    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination = Destination::when($search, function ($query) use ($search) {
                $query->where('state', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('transportation', 'like', '%' . $search . '%')
                    ->orWhere('startDate', 'like', '%' . $search . '%');
            })->where('type', 'letovanje')->latest()->get();
        } else {
            $destination = Destination::where('type', 'letovanje')->latest()->get();
        }


        return view('destination.summer', compact('destination'));
        //u view ce se uraditi prikaz samo gde je type letovanje.
    }
    //citybreak
    public function citybreak(Request $request)
    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination = Destination::when($search, function ($query) use ($search) {
                $query->where('state', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('transportation', 'like', '%' . $search . '%')
                    ->orWhere('startDate', 'like', '%' . $search . '%');
            })->where('type', 'cityBreak')->latest()->get();
        } else {
            $destination = Destination::where('type', 'cityBreak')->latest()->get();
        }


        return view('destination.cityBreak', compact('destination'));
      
    }

    //izleti
    public function fieldTrip(Request $request)
    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination = Destination::when($search, function ($query) use ($search) {
                $query->where('state', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('transportation', 'like', '%' . $search . '%')
                    ->orWhere('startDate', 'like', '%' . $search . '%');
            })->where('type', 'izlet')->latest()->get();
        } else {
            $destination = Destination::where('type', 'izlet')->latest()->get();
        }


        return view('destination.trip', compact('destination'));
    }

    public function all(Request $request)
    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination = Destination::when($search, function ($query) use ($search) {
                $query->where('state', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('transportation', 'like', '%' . $search . '%')
                    ->orWhere('startDate', 'like', '%' . $search . '%');
            })->latest()->paginate(6); 
        } else {
            $destination = Destination::latest()->paginate(6); 
        }

        return view('destination.all', compact('destination'));
    }
}
