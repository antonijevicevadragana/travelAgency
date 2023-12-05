<?php

use App\Models\Blog;
use App\Models\Hotel;
use App\Models\Price;
use App\Models\Comment;
use App\Models\Feedback;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//ruta za lokazlizaciju 
Route::get('/lang/{locale}', function (string $locale) {
    //App::setLocale($locale);
    session(['locale' => $locale]);

    //povratak na prethodnu stranicu
    return redirect()->back();
})->whereIn('locale', ['en', 'sr'])->name('lang');



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//DESTINACIJA
//prikaz svih podataka  svi mogu da vide
Route::get('/destination', [DestinationController::class, 'index'])
    ->name('destination.index');


//prikaz forme za unos
Route::get('/destination/create', [DestinationController::class, 'create'])
    ->name('destination.create')->middleware('auth', 'can:create,App\User');

//validacija podataka i upis novog reda u tabelu
Route::post('/destination', [DestinationController::class, 'store'])
    ->name('destination.store')->middleware('auth', 'can:create,App\User');

//forma za izmenu podatka
Route::get('/destination/{destination}/edit', [DestinationController::class, 'edit'])
    ->name('destination.edit')->middleware('auth', 'can:create,App\User');
//izvmena postojece destinacije
Route::put('/destination/{destination}', [DestinationController::class, 'update'])
    ->name('destination.update')->middleware('auth', 'can:create,App\User');


// //brisanje podatka
Route::delete('/destination{destination}', [DestinationController::class, 'destroy'])
    ->name('destination.destroy')->middleware('auth', 'can:delete,App\User');


//detaljan prikaz podatka
Route::get('/destination/{destination}', [DestinationController::class, 'show'])
    ->name('destination.show');

//HOTELI

//prikaz svih podataka
Route::get('/hotel', [HotelController::class, 'index'])
    ->name('hotel.index')->middleware('auth', 'can:view,App\User');

//prikaz forme za unos
Route::get('/hotel/create', [HotelController::class, 'create'])
    ->name('hotel.create')->middleware('auth', 'can:create,App\User');

//validacija podataka i upis novog reda u tabelu
Route::post('/hotel', [HotelController::class, 'store'])
    ->name('hotel.store')->middleware('auth', 'can:create,App\User');

//forma za izmenu podatka
Route::get('/hotel/{hotel}/edit', [HotelController::class, 'edit'])
    ->name('hotel.edit')->middleware('auth', 'can:create,App\User');
//izvmena postojece destinacije
Route::put('/hotel/{hotel}', [HotelController::class, 'update'])
    ->name('hotel.update')->middleware('auth', 'can:create,App\User');


// //brisanje podatka
Route::delete('/hotel{hotel}', [HotelController::class, 'destroy'])
    ->name('hotel.destroy')->middleware('auth', 'can:delete,App\User');

//detaljan prikaz podatka
Route::get('/hotel/{hotel}', [HotelController::class, 'show'])
    ->name('hotel.show');



//REZERVACIJE

//prikaz svih podataka
Route::get('/reservation', [ReservationController::class, 'index'])
    ->name('reservation.index')->middleware('auth', 'can:view,App\User');

// //prikaz forme za unos
// Route::get('/reservation/create', [ReservationController::class, 'create'])
// ->name('reservation.create');

Route::get('/reservation/create', [ReservationController::class, 'create'])
    ->name('reservation.create')
    ->middleware('auth'); // Dodatna ruta za rezervaciju

//validacija podataka i upis novog reda u tabelu
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store')->middleware('auth');

//forma za izmenu podatka
Route::get('/reservation/{reservation}/edit', [ReservationController::class, 'edit'])
    ->name('reservation.edit')->middleware('auth', 'can:create,App\User');
//izvmena postojece destinacije
Route::put('/reservation/{reservation}', [ReservationController::class, 'update'])
    ->name('reservation.update');

// //brisanje podatka
Route::delete('/reservation{reservation}', [ReservationController::class, 'destroy'])
    ->name('reservation.destroy')->middleware('auth', 'can:view,App\User');

//detaljan prikaz podatka
Route::get('/reservation/{reservation}', [ReservationController::class, 'show'])
    ->name('reservation.show');


//FIRST MINUTE
Route::get('/first', [DestinationController::class, 'first'])
    ->name('destination.first');

Route::get('/last', [DestinationController::class, 'last'])
    ->name('destination.last');

// zastarela/ cuvaju se da bi se mogla izmeniti slicna putovanja
Route::get('/all', [DestinationController::class, 'all'])
    ->name('all')->middleware('auth', 'can:viewAny,App\User');

//rute za vrste putovanja letovanje, zimovanje, daleke destinacije, izlet
Route::get('/summer-vacation', [DestinationController::class, 'summer'])
    ->name('destination.summer');

Route::get('/winter-vacation', [DestinationController::class, 'winter'])
    ->name('destination.winter');

Route::get('/citybreak', [DestinationController::class, 'citybreak'])
    ->name('destination.citybreak');

Route::get('/field trip', [DestinationController::class, 'fieldTrip'])
    ->name('destination.trip');


//////////////////
//blog

//svi mogu da vide blog i da komentarisu, ali samo ulogovani mogu da ga kriraju
//Korisnik moze samo svoj blog da menja i brise, a admin ima pravo svaki blog da obrise ili izmeni
//prikaz svih podataka
Route::get('/blog', [BlogController::class, 'index'])
    ->name('blog.index');



//kreiranje
Route::get('/blog/create', [BlogController::class, 'create'])
    ->name('blog.create')
    ->middleware('auth'); 

//validacija podataka i upis novog reda u tabelu
Route::post('/blog', [BlogController::class, 'store'])->name('blog.store')->middleware('auth');

// //izvmena postojecg bloga

Route::get('/blog/{blog}/edit', [BlogController::class, 'edit'])
    ->name('blog.edit')
    ->middleware('auth');


//izvmena postojecg bloga
Route::put('/blog/{blog}', [BlogController::class, 'update'])
    ->name('blog.update');
    // ->middleware('auth', 'can:update,App\Blog');
    // ->middleware('auth');
    

// //brisanje podatka
Route::delete('/blog{blog}', [BlogController::class, 'destroy'])
    ->name('blog.destroy')
    ->middleware('auth');

//detaljan prikaz podatka
Route::get('/blog/{blog}', [BlogController::class, 'show'])
    ->name('blog.show');

//myblogs
Route::get('/myBlog', [BlogController::class, 'myBlog'])
->name('myBlog');
//svi blogovi
Route::get('/allBlog', [BlogController::class, 'allBlog'])
    ->name('blog.allBlog')->middleware('auth', 'can:delete,App\User');;

//comment
//kreiranje
Route::get('/comment/create', [CommentController::class, 'create'])
    ->name('comment.create');


//validacija podataka i upis novog reda u tabelu
Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');

//forma za izmenu podatka
Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])
->name('comment.edit');
//izvmena postojece destinacije
Route::put('/comment/{comment}', [CommentController::class, 'update'])
->name('comment.update');

// //brisanje podatka
// Route::delete('/comment{comment}', [CommentController::class, 'destroy'])
//     ->name('comment.destroy');
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');



//RUTE ZA PROFIL

//prikaz svih podataka
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index')->middleware('auth', 'can:view,App\User');

//kreiranje
Route::get('/profile/create', [ProfileController::class, 'create'])
    ->name('profile.create')
    ->middleware('auth'); // Dodatna ruta za rezervaciju

//validacija podataka i upis novog reda u tabelu
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

//forma za izmenu podatka
Route::get('/profile/{profile}/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit');

//izmena postojece destinacije
Route::put('/profile/{profile}', [ProfileController::class, 'update'])
    ->name('profile.update');

// //brisanje podatka
Route::delete('/profile{profile}', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

//detaljan prikaz podatka
Route::get('/profile/{profile}', [ProfileController::class, 'show'])
    ->name('profile.show');

//myProfile
Route::get('/myProfile', [ProfileController::class, 'myProfile'])
    ->name('myProfile');


//user - korisnici
Route::get('/users', [UserController::class, 'index'])
    ->name('user.index')->middleware('auth', 'can:create,App\User');
    //forma za izmenu podatka
Route::get('/user/{user}/edit', [UserController::class, 'edit'])
->name('user.edit')->middleware('auth', 'can:create,App\User');

//izmena postojeceg podatka
Route::put('/user/{user}', [UserController::class, 'update'])
->name('user.update')->middleware('auth', 'can:create,App\User');


//feedbacks
Route::get('/feedback', [FeedbackController::class, 'index'])
    ->name('feedback.index')->middleware('auth', 'can:view,App\User');
//kreiranje
Route::get('/feedback/create', [FeedbackController::class, 'create'])
    ->name('feedback.create');

//validacija podataka i upis novog reda u tabelu
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
//moji feedbackovi
Route::get('/myfeedbacks', [FeedbackController::class, 'myfeedbacks'])
->name('myfeedbacks');



// //brisanje podatka
Route::delete('/feedback{feedback}', [FeedbackController::class, 'destroy'])
    ->name('feedback.destroy');

//o nama //starnica na kojoj ce se prikazivati nesto o preduzecu i feedbacks
Route::get('/aboutUs', [FeedbackController::class, 'aboutUs'])->name('aboutUs');