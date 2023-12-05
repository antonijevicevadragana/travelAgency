<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Price;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $search = $request->search;
            $destination=Destination::all();
            $dataHotel = Hotel::when($search, function (Builder $query) use ($search) {
                $query->whereHas('destination', function (Builder $query) use ($search) {
                    $query->where('state', 'LIKE', '%' . $search . '%')
                        ->orWhere('stateEng', 'LIKE', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('location', 'LIKE', $search);
                });
            })
            ->latest()
            ->paginate(6);    

        } else {
            $dataHotel = Hotel::latest()->paginate(6);
        }

        return view('hotel.index', compact('dataHotel'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $destination = Destination::all();
        return view('hotel.create', compact('destination'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //validacija podataka
        $formFilds = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required',
            'location' => 'required',
            'descript' => 'required',
            'link' => 'nullable|url',
            'number' => 'required',

            'img.*' => 'image|between:1,2048|max:2048',
            'descriptEng'=> 'required',
            'price' => 'required',
            'firstMin' => 'required',
            'lasteMin' => 'required',
            'firstOnly' => 'nullable',
            'lastOnly' => 'nullable',
        ]);

       
        //upis u hotel
        $hotel = Hotel::create($request->only('destination_id', 'name', 'location', 'descript', 'descriptEng','link', 'number')); //upisuje u tabelu hotela samo ove podatke iz forme

        //upis u tabelu prices
        $price = Price::create([
            'price' => $formFilds['price'],
            'firstMin' => $formFilds['firstMin'],
            'lasteMin' => $formFilds['lasteMin'],
            'lastOnly' => $formFilds['lastOnly'],
            'firstOnly' => $formFilds['firstOnly'],
            'hotel_id' => $hotel->id
        ]);

        //cuvanje slike
        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $image) {
                $path = $image->store('hotel', 'public');
                Image::create([
                    'path' => $path,
                    'hotel_id' => $hotel->id, // Povezana sliku sa hotelom 
                ]);
            }
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno kriran hotel!');

        return redirect()->route('destination.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //

        $hotelId = $hotel->id;
        $images = Image::where('hotel_id',  $hotelId)->get();
        
        $destination = $hotel->destination;
        $prices = Price::where('hotel_id',  $hotelId)->get();

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
        
         return view('hotel.show', [
            'hotel' => $hotel, 'images' => $images, 'p'=>$p, 'Standardprice'=> $Standardprice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)

    {
        $hotelId = $hotel->id;
        $images = Image::where('hotel_id',  $hotelId)->get();

        $destination = Destination::all();
        return view('hotel.edit', compact('hotel', 'destination', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        //

        $formFilds = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required',
            'location' => 'required',
            'descript' => 'required',
            'descriptEng'=> 'required',
            'link' => 'nullable|url',

            // 'img.*' => 'image|between:1,2048',
            'img.*' => 'image|between:1,2048|max:2048',
            'number' => 'required',
            // ovaj deo koda se upisuje u tabeli price
            'price' => 'required',
            'firstMin' => 'required',
            'lasteMin' => 'required',
            'firstOnly' => 'nullable',
            'lastOnly' => 'nullable',
        ]);

       // dd($formFilds);


        //    izmene u tabeli hotels
        $hotel->update($request->only('destination_id', 'name', 'location', 'descript', 'descriptEng','link', 'number'));



        $price = Price::where('hotel_id', $hotel->id)->get();

        //izmene u tabeli cene
        $hotel->prices()->update([
            'price' => $formFilds['price'],
            'firstMin' => $formFilds['firstMin'],
            'lasteMin' => $formFilds['lasteMin'],
            'lastOnly' => $formFilds['lastOnly'],
            'firstOnly' => $formFilds['firstOnly'],
            'hotel_id' => $hotel->id
        ]);

       
        if ($request->has('keep_old_images')) {
            // Ako je korisnik označio opciju "Zadrži stare slike", nema potrebe za brisanjem starih slika.
            if ($request->hasFile('img')) {
                foreach ($request->file('img') as $image) {
                    $path = $image->store('hotel', 'public');
                    Image::create([
                        'path' => $path,
                        'hotel_id' => $hotel->id, // Povežite sliku sa hotelom
                    ]);
                }
            }
        } else {
            // Ako korisnik nije označio opciju "Zadrži stare slike", obrišite sve stare slike.
            $hotel->images()->delete();
            if ($request->hasFile('img')) {
                foreach ($request->file('img') as $image) {
                    $path = $image->store('hotel', 'public');
                    Image::create([
                        'path' => $path,
                        'hotel_id' => $hotel->id, 
                    ]);
                }
            }
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno izmenjen hotel!');
        return redirect()->route('hotel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //hotel ne moze biti obrisan ukoliko postoji rezervacija za isti
        $reservationCount = Reservation::where('hotel_id', $hotel->id)->count();
        if($reservationCount > 0) {
            session()->flash('alertType', 'danger');
            session()->flash('alertMsg', 'Podatak ne moze biti obrisan. Postoji rezervacija povezana sa istim.');
            return redirect()->route('hotel.index');
        }
        else {
            $hotel->delete();
            session()->flash('alertType', 'success');
            session()->flash('alertMsg', 'Uspesno obrisano.');
            return redirect()->route('hotel.index');
        }
       
    }
}
