<?php
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\LinkController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserAddressController;
use App\Http\Controllers\Backend\PaymentMethodController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BlingController;
use App\Http\Controllers\Backend\MercadoLivreController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\ScheduleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('forgot_password');
});

Route::group(['middleware' => ['roles']], function () {
    Route::get('/', [BackendController::class, 'index'])->name('index');
    Route::get('/account-settings', [AdminAuthController::class, 'accountSetting'])->name('account_setting');
    Route::patch('/account-settings', [AdminAuthController::class, 'updateAccount'])->name('account_setting.update');
    Route::get('/categories/{category}/remove-image', [CategoryController::class, 'removeImage'])->name('categories.remove_image');
    Route::resource('categories', CategoryController::class);
    Route::post('/products/remove-image', [ProductController::class, 'removeImage'])->name('products.remove_image');
    Route::post('/banner/remove-banner', [BannerController::class, 'removeImage'])->name('banner.remove_image');
    Route::resource('products', ProductController::class);
    Route::resource('tags', TagController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class);
    Route::get('/supervisors/{supervisor}/remove-image', [SupervisorController::class, 'removeImage'])->name('supervisors.remove_image');
    Route::resource('supervisors', SupervisorController::class);
    Route::resource('countries', CountryController::class);
    Route::get('/states/get-states', [StateController::class, 'get_states'])->name('states.get_states');
    Route::resource('states', StateController::class);
    Route::get('/cities/get-cities', [CityController::class, 'get_cities'])->name('cities.get_cities');
    Route::resource('cities', CityController::class);
    Route::get('users/get-users', [UserController::class, 'get_users'])->name('users.get_users');
    Route::resource('users', UserController::class);
    Route::resource('user_addresses', UserAddressController::class);
    Route::resource('payment_methods', PaymentMethodController::class);
    Route::resource('orders', OrderController::class)->except('create', 'edit');
    Route::resource('settings', SettingController::class)->only('index', 'update');
    Route::resource('contacts', ContactController::class)->except('create', 'edit', 'update');
    Route::resource('links', LinkController::class)->except('show');
    Route::resource('pages', PageController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('mercadoLivre', MercadoLivreController::class);
    Route::resource('posts', PostController::class);

    Route::prefix('/mercadolibre')->controller(MercadoLivreController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/auth', 'handleAuth')->name('admin.mercado-livre.auth');
        Route::get('/callback', 'handleMercadoLibreCallback');
        Route::get('/getCategories', 'getCategories')->name('mlCategories');
        Route::get('/getMLData', 'getMLData')->name('getMLData');
        Route::get('/getPermaLink/{id}', 'getPermaLink');
        Route::get('/getLinksML/{id}', 'getLinksML')->name('getLinksML');
        Route::post('/deleteContaML', 'deleteContaML')->name('deleteContaML');
        Route::get('/imprimirEtiqueta/{order}', [MercadoLivreController::class, 'imprimirEtiqueta'])->name('mercadolivre.imprimirEtiqueta');
    });

    Route::prefix('/servicos')->controller(ServicesController::class)->group(function () {
        Route::get('/', 'index')->name('services.index');
    });

    Route::prefix('/bling')->controller(BlingController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/auth', 'handleAuth');
        Route::get('/subToken', 'subToken');
        Route::get('/teste', 'criarNota');
    });

    Route::prefix('/etiqueta')->controller(OrderController::class)->group(function () {
        Route::get('/{id}', 'imprimir');
    }); 

    Route::prefix('/agenda')->controller(ScheduleController::class)->group(function () {
        Route::get('/', 'index')->name('schedule.index');
    }); 
    
});

