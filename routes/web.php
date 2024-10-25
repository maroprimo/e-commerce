<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoursEuroController;
use App\Http\Controllers\ArticleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// EXPLICATION
/*Route::get('/', 'WelcomeController@home');

Route::get('/services', 'WelcomeController@services');

Route::get('/apropos', function () {
    //return '<h1>Mon nom est ' . $noms. ' id est '.$id.' </h1>'; 

    return view('pages.apropos');
});

Route::get('salut/{slug}-{id}', ['as' =>'salut', function ($slug, $id) {
    return "Lien : " .route ('salut', ['slug'=>'$slug', 'id'=>'$id']); 

}])->where('slug', '[a-z0-9\-]+')->where('id', '[0-9]+') ;

// utilisation prefixe

Route::group(['prefix' =>'admin', 'middleware' => 'Ip'], function(){
    
    Route::get('salut', function(){
        return 'salut les gens';
    });
});
*/
/* NOUVEAU
Route::get('/', 'WelcomeController@home');

Route::get('/apropos', 'PagesController@apropos');

Route::get('/services', 'PagesController@services');

Route::get('/detail/{id}', 'PagesController@detail');

Route::get('/create', 'PagesController@create');

Route::post('/sauverproduit', 'PagesController@sauverproduit');

Route::get('/edit/{id}', 'PagesController@edit');

Route::post('modifier', 'PagesController@modifier');

Route::get('/supprimer/{id}', 'PagesController@supprimer');

Route::resource('/products', 'ProductController'); // pas besoin d'appeler la methode car c'est un ressource
*/

Route::get('/', 'ClientController@home');
Route::get('/shop', 'ClientController@shop');
Route::get('/carte', 'ClientController@panier');
Route::get('/client_login', 'ClientController@client_login');
Route::get('/singup', 'ClientController@singup');
Route::get('/checkout', 'ClientController@paiement');
Route::get('select_par_cat/{name}', 'ClientController@select_par_cat');
Route::get('ajouter_au_panier/{id}', 'ClientController@ajouter_au_panier');
Route::post('modifier_qty/{id}', 'ClientController@modifier_qty')->name('modifier_qty');
Route::get('retirer_produit/{id}', 'ClientController@retirer_produit');
//Route::get('/checkout', 'ClientController@checkout');
Route::post('/payer', 'ClientController@payer'); 
Route::post('/creer_compte', 'ClientController@creer_compte');
Route::post('/acceder_compte', 'ClientController@acceder_compte');
Route::get('/logout', 'ClientController@logout');
Route::get('detail/{id}', 'ClientController@detail')->name('product.detail');
Route::get('/post/{id}', 'ClientController@post');
Route::get('/blog', 'ClientController@blog');




Route::get('/generatePdf/{id}', 'PdfController@generatePdf');
Route::get('/generatePdf', 'PdfController@generateSimplePdf');

Route::get('/admin', 'AdminController@dashboard');
Route::get('/commandes', 'AdminController@commandes');
// createion article de blog
//explication un bonne fois pour toutes
// admin/articles/create = quand je tape cette adresse ca va aller dans class create et affiche ce qui est indiqué làba
Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
Route::post('admin/articles/store', [ArticleController::class, 'store'])->name('admin.articles.store');
Route::get('/admin/articles/liste', [ArticleController::class, 'liste'])->name('articles.index');
Route::get('/editarticle/{id}', [ArticleController::class, 'editarticle'])->name('admin.articles.editarticle');
Route::post('/modifarticle', [ArticleController::class, 'modif'])->name('admin.articles.modif');
Route::get('/supprimerarticle/{id}', [ArticleController::class, 'supprimer'])->name('admin.articles.supprimer');


Route::get('/ajoutcatblog', 'CategoryarticleController@ajoutercategorie');
Route::post('/sauvercategorie', 'CategoryarticleController@sauvercategorie');
Route::get('/categories', 'CategoryarticleController@categories');
Route::get('/edit_categorie/{id}', 'CategoryarticleController@edit_categorie');
Route::post('modifiercategorie','CategoryarticleController@modifiercategorie');
Route::get('/supprimercategorie/{id}', 'CategoryarticleController@supprimercategorie');


//suppression commandes dans admin
Route::delete('admin/commandes/{id}', 'AdminController@deleteOrder')->name('admin.deleteOrder');


Route::get('/ajoutercategorie', 'CategoryController@ajoutercategorie');
Route::post('/sauvercategorie', 'CategoryController@sauvercategorie');
Route::get('/categories', 'CategoryController@categories');
Route::get('/edit_categorie/{id}', 'CategoryController@edit_categorie');
Route::post('modifiercategorie','CategoryController@modifiercategorie');
Route::get('/supprimercategorie/{id}', 'CategoryController@supprimercategorie');

Route::get('/ajouterproduit', 'ProductsController@ajouterproduit');
Route::post('sauverproduit', 'ProductsController@sauverproduit');
Route::get('/produits', 'ProductsController@produits');
Route::get('editproduit/{id}', 'ProductsController@editproduit');
Route::post('/modifierproduit', 'ProductsController@modifierproduit');
Route::get('/supprimerproduit/{id}', 'ProductsController@supprimerproduit');
Route::get('/activer_produit/{id}', 'ProductsController@activer_produit');
Route::get('/desactiver_produit/{id}', 'ProductsController@desactiver_produit');

Route::get('/ajouterslider', 'SliderController@ajouterslider');
Route::post('/sauverslider', 'SliderController@sauverslider');
Route::get('/sliders', 'SliderController@sliders');
Route::get('/editerslider/{id}', 'SliderController@editerslider');
Route::post('/modifierslider', 'SliderController@modifierslider');
Route::get('/supprimerslider/{id}', 'SliderController@supprimerslider');
Route::get('/activerslider/{id}', 'SliderController@activerslider');
Route::get('/desactiverslider/{id}', 'SliderController@desactiverslider');



// cours euros


Route::get('/cours-euro', [CoursEuroController::class, 'showForm'])->name('admin.form');

Route::post('/update-taux', [CoursEuroController::class, 'updateTaux'])->name('update.taux');



Route::get('/admin/shipping/create', 'ShippingController@create')->name('shipping.create');
Route::post('/admin/shipping/store', 'ShippingController@store')->name('shipping.store');
Route::get('/admin/shipping', 'ShippingController@index')->name('shipping.index');
Route::get('/admin/shipping/createpays', 'ShippingController@ajouterpays')->name('shipping.ajouterpays');
Route::post('admin/shipping/sauvepays', 'ShippingController@sauvepays')->name('shipping.sauvepays');

Route::post('/order/store', [OrderController::class, 'storeOrder'])->name('order.store');
// Dans routes/web.php
Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');


Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Route pour mettre à jour le pays dans la session
Route::post('/update-country', 'ClientController@updateCountry')->name('updateCountry');




/*Route::middleware('auth:admin')->group(function () {
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard'); // Créez cette vue
    })->name('admin.dashboard');
});*/

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/generatePdf/{id}', 'PdfController@generatePdf');

    Route::get('/commandes', 'AdminController@commandes')->name('admin.commandes');

    Route::get('/admin/shipping/create', 'ShippingController@create')->name('shipping.create');
    Route::post('/admin/shipping/store', 'ShippingController@store')->name('shipping.store');
    Route::get('/admin/shipping', 'ShippingController@index')->name('shipping.index');
    Route::get('/admin/shipping/createpays', 'ShippingController@ajouterpays')->name('shipping.ajouterpays');
    Route::post('admin/shipping/sauvepays', 'ShippingController@sauvepays')->name('shipping.sauvepays');


    Route::get('/ajoutercategorie', 'CategoryController@ajoutercategorie')->name('admin.ajoutercategories');
    Route::post('/sauvercategorie', 'CategoryController@sauvercategorie')->name('admin.sauvercategorie');
    Route::get('/categories', 'CategoryController@categories')->name('admin.categories');
    Route::get('/edit_categorie/{id}', 'CategoryController@edit_categorie')->name('admin.editcategorie');
    Route::post('modifiercategorie','CategoryController@modifiercategorie');
    Route::get('/supprimercategorie/{id}', 'CategoryController@supprimercategorie');

    Route::get('/ajouterproduit', 'ProductsController@ajouterproduit');
    Route::post('sauverproduit', 'ProductsController@sauverproduit');
    Route::get('/produits', 'ProductsController@produits');
    Route::get('editproduit/{id}', 'ProductsController@editproduit');
    Route::post('/modifierproduit', 'ProductsController@modifierproduit');
    Route::get('/supprimerproduit/{id}', 'ProductsController@supprimerproduit');
    Route::get('/activer_produit/{id}', 'ProductsController@activer_produit');
    Route::get('/desactiver_produit/{id}', 'ProductsController@desactiver_produit');

    Route::get('/ajouterslider', 'SliderController@ajouterslider');
    Route::post('/sauverslider', 'SliderController@sauverslider');
    Route::get('/sliders', 'SliderController@sliders');
    Route::get('/editerslider/{id}', 'SliderController@editerslider');
    Route::post('/modifierslider', 'SliderController@modifierslider');
    Route::get('/supprimerslider/{id}', 'SliderController@supprimerslider');
    Route::get('/activerslider/{id}', 'SliderController@activerslider');
    Route::get('/desactiverslider/{id}', 'SliderController@desactiverslider');

    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    Route::post('admin/articles/store', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/articles/liste', [ArticleController::class, 'liste'])->name('articles.index');
    Route::get('/editarticle/{id}', [ArticleController::class, 'editarticle'])->name('admin.articles.editarticle');
    Route::post('/modifarticle', [ArticleController::class, 'modif'])->name('admin.articles.modif');
    Route::get('/supprimerarticle/{id}', [ArticleController::class, 'supprimer'])->name('admin.articles.supprimer');


});