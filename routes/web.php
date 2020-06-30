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
*/

Route::get('/', 'MainController@index')->name('main');

Auth::routes();

Route::post('/photo-upload', 'HomeController@photoUpload')->name('photo.upload');
Route::post('/video-upload', 'HomeController@videoUpload')->name('video.upload');
Route::post('/document-upload', 'HomeController@documentUpload')->name('document.upload');
Route::post('/sound-upload', 'HomeController@soundUpload')->name('sound.upload');
Route::post('/audio-upload', 'HomeController@audioUpload')->name('audio.upload');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/bot/{id}', 'BotController@index')->name('index');
Route::post('/bot/{id}', 'BotController@index')->name('post');

Route::get('/edit/bot/{id}','HomeController@editBot')->name('edit.bot');
Route::get('/ajax/edit/bot/{id}','HomeController@editBotAjax')->name('edit.bot.ajax');
Route::post('/ajax/save/bot','HomeController@saveBotAjax')->name('save.bot.ajax');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@store')->name('store');

Route::get('/settings', 'HomeController@settings')->name('settings');
Route::get('/settings/notifications', 'HomeController@settingsNotifications')->name('settings.notifications');
Route::get('/settings/integration', 'HomeController@settingsIntegration')->name('settings.integration');
Route::get('/settings/politics', 'HomeController@settingsPolitics')->name('settings.politics');
Route::get('/settings/additional', 'HomeController@settingsAdditional')->name('settings.additional');

Route::get('/chat', 'HomeController@settings')->name('chat');

Route::get('/autofunnels', 'HomeController@autofunnels')->name('autofunnels');
Route::get('/autofunnels/list', 'HomeController@autofunnelsList')->name('autofunnels.list');

Route::get('/list', 'HomeController@list')->name('list');
Route::get('/list/constants', 'HomeController@listConstants')->name('list.constants');

Route::get('/statistics', 'HomeController@statistics')->name('statistics');
Route::get('/statistics/devices', 'HomeController@statisticsDevices')->name('statistics.devices');
Route::get('/statistics/phrases', 'HomeController@statisticsPhrases')->name('statistics.phrases');
Route::get('/statistics/popular', 'HomeController@statisticsPopular')->name('statistics.popular');
Route::get('/statistics/links', 'HomeController@statisticsLinks')->name('statistics.links');

Route::get('/analyze', 'HomeController@analyze')->name('analyze');
Route::get('/vue/analyze/{page}', 'ApiController@analyze')->name('analyze.api');
