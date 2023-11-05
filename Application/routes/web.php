<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
 */

Route::group([
    'middleware' => 'notInstalled',
    'prefix' => 'admin',
    'namespace' => 'Backend'
], function () {
    Route::name('admin.')->namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@redirectToLogin')->name('index');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login.store');
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.reset.change');
        Route::post('logout', 'LoginController@logout')->name('logout');
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::name('admin.')
            ->middleware('demo')
            ->group(function () {
                Route::prefix('dashboard')->group(function () {
                    Route::get('/', 'DashboardController@index')->name('dashboard');
                    Route::get('charts/users', 'DashboardController@usersChartData')->middleware('ajax.only');
                    Route::get('charts/uploads', 'DashboardController@uploadsChartData')->middleware('ajax.only');
                    Route::get('charts/earnings', 'DashboardController@earningsChartData')->middleware(['saas', 'ajax.only']);
                    Route::get('charts/logs', 'DashboardController@logsChartData')->middleware('ajax.only');
                });

                Route::name('users.')
                    ->prefix('users')
                    ->group(function () {
                        Route::post('{id}/edit/change/avatar', 'UserController@changeAvatar');
                        Route::delete('{id}/edit/delete/avatar', 'UserController@deleteAvatar')->name('deleteAvatar');
                        Route::get('{id}/edit/logs', 'UserController@logs')->name('logs');
                        Route::get('{id}/edit/logs/get/{log_id}', 'UserController@getLogs')->middleware('ajax.only');
                        Route::post('{id}/edit/sentmail', 'UserController@sendMail')->name('sendmail');
                        Route::get('logs/{ip}', 'UserController@logsByIp')->name('logsbyip');
                    });

                Route::resource('users', 'UserController');

                Route::middleware('saas')->group(function () {
                    Route::resource('subscriptions', 'SubscriptionController');
                    Route::resource('transactions', 'TransactionController');
                    Route::resource('plans', 'PlanController');
                    Route::resource('coupons', 'CouponController');
                });
            });

        Route::group(['prefix' => 'settings', 'namespace' => 'Settings', 'middleware' => 'demo'], function () {
            Route::name('admin.settings.')->group(function () {
                Route::get('general', 'GeneralController@index')->name('general');
                Route::post('general/update', 'GeneralController@update')->name('general.update');

                Route::get('smtp', 'SmtpController@index')->name('smtp');
                Route::post('smtp/update', 'SmtpController@update')->name('smtp.update');
                Route::post('smtp/test', 'SmtpController@test')->name('smtp.test');


                Route::resource('gateways', 'GatewayController', ['only' => ['index', 'edit', 'update']])->middleware('saas');
                Route::resource('taxes', 'TaxController')->middleware('saas');
            });

            Route::resource('admins', 'AdminController');
        });

        Route::name('admin.additional.')
            ->prefix('additional')
            ->namespace('Additional')
            ->middleware('demo')
            ->group(function () {
                Route::get('cache', 'CacheController@index')->name('cache');
                Route::get('custom-css', 'CustomCssController@index')->name('css');
                Route::post('custom-css/update', 'CustomCssController@update')->name('css.update');
                Route::get('popup-notice', 'PopupNoticeController@index')->name('notice');
                Route::post('popup-notice/update', 'PopupNoticeController@update')->name('notice.update');
            });

        Route::name('admin.')
            ->prefix('account')
            ->namespace('Account')
            ->middleware('demo')
            ->group(function () {
                Route::get('details', 'SettingsController@detailsForm')->name('account.details');
                Route::get('security', 'SettingsController@securityForm')->name('account.security');
                Route::post('details/update', 'SettingsController@detailsUpdate')->name('account.details.update');
                Route::post('security/update', 'SettingsController@securityUpdate')->name('account.security.update');
            });
    });
});
































/*
|--------------------------------------------------------------------------
| Frontend Routs With Laravel Localization
|--------------------------------------------------------------------------
 */

// Define a named route for accessing a secure file by ID
Route::get('secure/file/{id}', 'Frontend\File\SecureController@index')->name('secure.file');
Route::group(localizeOptions(), function () {
    Route::namespace('Frontend\Gateways')->prefix('ipn')->name('ipn.')->group(function () {
        Route::get('paypal_express', 'PaypalExpressController@ipn')->name('paypal_express');
        Route::get('stripe_checkout', 'StripeCheckoutController@ipn')->name('stripe_checkout');
        Route::get('mollie', 'MollieController@ipn')->name('mollie');
        Route::post('razorpay', 'RazorpayController@ipn')->name('razorpay');
    });
    Auth::routes(['verify' => true]);

    Route::group(['namespace' => 'Frontend\User\Auth'], function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('login/{provider}', 'LoginController@redirectToProvider')->name('provider.login');
        Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback')->name('provider.callback');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::middleware(['disable.registration'])->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register')->middleware('check.registration');
            Route::get('register/complete/{token}', 'RegisterController@showCompleteForm')->name('complete.registration');
            Route::post('register/complete/{token}', 'RegisterController@complete')->middleware('check.registration');
        });
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'ConfirmPasswordController@confirm');
        Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
        Route::post('email/verify/email/change', 'VerificationController@changeEmail')->name('change.email');
        Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
        Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
    });
    Route::group(['namespace' => 'Frontend\User\Auth', 'middleware' => ['auth', 'verified']], function () {
        Route::get('checkpoint/2fa/verify', 'CheckpointController@show2FaVerifyForm')->name('2fa.verify');
        Route::post('checkpoint/2fa/verify', 'CheckpointController@verify2fa');
    });
    Route::group(['prefix' => 'user', 'namespace' => 'Frontend\User', 'middleware' => ['auth', 'verified', '2fa.verify']], function () {

        Route::get('/', function () {
            return redirect()->route('user.subscription');

        })->name('user');
        Route::name('user.')->group(function () {

            Route::middleware('saas')->group(function () {
                Route::get('plans', 'PlanController@index')->name('plans');
                Route::get('checkout/{checkout_id}', 'CheckoutController@index')->name('checkout.index');
                Route::post('checkout/{checkout_id}/coupon/apply', 'CheckoutController@applyCoupon')->name('checkout.coupon.apply');
                Route::post('checkout/{checkout_id}/coupon/remove', 'CheckoutController@removeCoupon')->name('checkout.coupon.remove');
                Route::post('checkout/{checkout_id}/proccess', 'CheckoutController@proccess')->name('checkout.proccess');
            });

            Route::middleware('isSubscribed')->group(function () {

                Route::middleware('saas')->group(function () {
                    Route::get('subscription', 'SubscriptionController@index')->name('subscription');
                    Route::get('subscription/transaction/{transaction_id}', 'SubscriptionController@transaction')->name('transaction');
                });

                Route::prefix('settings')->group(function () {
                    Route::get('/', 'SettingsController@index')->name('settings');
                    Route::post('details/update', 'SettingsController@detailsUpdate')->name('settings.details.update');
                    Route::post('details/mobile/update', 'SettingsController@mobileUpdate')->name('settings.details.mobile.update');
                    Route::get('password', 'SettingsController@password')->name('settings.password');
                    Route::post('password/update', 'SettingsController@passwordUpdate')->name('settings.password.update');
                    Route::get('2fa', 'SettingsController@towFactor')->name('settings.2fa');
                    Route::post('2fa/enable', 'SettingsController@towFactorEnable')->name('settings.2fa.enable');
                    Route::post('2fa/disabled', 'SettingsController@towFactorDisable')->name('settings.2fa.disable');
                });

            });
        });
    });

    Route::group(['namespace' => 'Frontend', 'middleware' => ['verified', '2fa.verify']], function () {
        Route::post('plan/{id}/{type}', 'SubscribeController@subscribe')->name('subscribe')->middleware('saas');

        Route::middleware('isSubscribed')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('page/{slug}', 'PageController@pages')->name('page');
            Route::get('courses','HomeController@courses')->name('courses')->middleware('PackageSubscriptionVerifier');


        });
    });

    Route::get('cookie/accept', 'Frontend\ExtraController@cookie')->middleware('ajax.only');
    Route::get('popup/close', 'Frontend\ExtraController@popup')->middleware('ajax.only');
    if (config('vironeer.install.complete') && !settings('website_language_type')) {
        Route::get('{lang}', 'Frontend\LocalizationController@localize')->name('localize');
    }
});
