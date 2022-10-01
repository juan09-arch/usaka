<?php

use App\Http\Controllers\ArchiveDocumentController;
use App\Http\Controllers\CategoryDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentFormatController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Node\Block\Document;

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

Route::get('/search', [HomeController::class, 'index'])->name('search');
// Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
    Route::get('document-detail/{id}', [HomeController::class, 'getDocumentDetail'])->name('document-detail');
});

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view('auth.login');
});


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);



/*
** ROUTE NAMING **
   note: naming use prefix dashboard.
   example : dashboard.user.index
*/
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

     // ROUTE FOR TEAMS
     Route::prefix('team')->name('team.')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('index');
        Route::get("/create", [TeamController::class, 'create'])->name('create');
        Route::post("/store", [TeamController::class, 'store'])->name('store');
        Route::get("/edit/{id}", [TeamController::class, 'edit'])->name('edit');
        Route::put("/update/{id}", [TeamController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [TeamController::class, 'destroy'])->name('destroy');

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('team-datatable', [TeamController::class, 'getTeamDatatable'])->name('team-datatable');
        });
    });

    // ROUTE FOR ARCHIVE
    Route::prefix('archive')->name('archive.')->group(function () {
        Route::get('/', [ArchiveDocumentController::class, 'index'])->name('index');
        Route::get('/{documentType_id}', [ArchiveDocumentController::class, 'showTypeDocument'])->name('show.document');
        Route::get('/create/{documentType_id}', [ArchiveDocumentController::class, 'create'])->name('create.document');
        Route::post('/storeDocument', [ArchiveDocumentController::class, 'storeDocument'])->name('store.document');
        Route::get('/edit/{documentType_id}', [ArchiveDocumentController::class, 'edit'])->name('edit.document');
        Route::post('/updateDocument', [ArchiveDocumentController::class, 'updateDocument'])->name('update.document');
        Route::delete('/deleteDocument/{documentArchive_id}', [ArchiveDocumentController::class, 'deleteDocument'])->name('delete.document');
        Route::get('/deletePermanentDocument/{documentArchive_id}', [ArchiveDocumentController::class, 'deletePermanentDocument'])->name('deletepermanent.document');
        Route::get('/restoreDocument/{documentArchive_id}', [ArchiveDocumentController::class, 'restoreDocument'])->name('restore.document');

        Route::get('/trash/{documentType_id}', [ArchiveDocumentController::class, 'trashDocument'])->name('trash.document');

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::get('lockers/{room_id}', [ArchiveDocumentController::class, 'getLockersByRoomID'])->name('lockers');
            Route::get('racks/{locker_id}', [ArchiveDocumentController::class, 'getRacksByLockerID'])->name('racks');
            Route::get('boxes/{rack_id}', [ArchiveDocumentController::class, 'getBoxesByRackID'])->name('boxes');
        });
    });

    // ROUTE FOR LOCKER
    Route::prefix('storage')->name('storage.')->group(function () {
        Route::get('/', [StorageController::class, 'index'])->name('index');
        Route::get('/{room_id}', [StorageController::class, 'room'])->name('room');
        Route::post('create-room', [StorageController::class, 'StoreRoom'])->name('create.room');
        Route::get('/room/show/{id}', [StorageController::class, 'showRoom'])->name('show.room');
        Route::put('/room/update/{id}', [StorageController::class, 'updateRoom'])->name('update.room');
        Route::delete('/room/delete/{id}', [StorageController::class, 'destroyRoom'])->name('delete.room');

        Route::post('{room_id}/locker', [StorageController::class, 'StoreLocker'])->name('create.room.locker');
        Route::get('/{room}/{locker}', [StorageController::class, 'locker'])->name('locker');
        Route::get('/locker/show/{id}', [StorageController::class, 'showLocker'])->name('show.locker');
        Route::put('/locker/update/{id}', [StorageController::class, 'updateLocker'])->name('update.locker');
        Route::delete('/locker/delete/{id}', [StorageController::class, 'destroyLocker'])->name('delete.locker');

        Route::post('/locker/rack', [StorageController::class, 'StoreRack'])->name('create.room.locker.rack');
        Route::get('/rack/show/{id}', [StorageController::class, 'showRack'])->name('show.rack');
        Route::put('/rack/update/{id}', [StorageController::class, 'updateRack'])->name('update.rack');
        Route::delete('/rack/delete/{id}', [StorageController::class, 'destroyRack'])->name('delete.rack');

        Route::post('/rack/box', [StorageController::class, 'StoreBox'])->name('create.room.locker.rack.box');
        Route::get('/box/show/{id}', [StorageController::class, 'showBox'])->name('show.box');
        Route::put('/box/update/{id}', [StorageController::class, 'updateBox'])->name('update.box');
        Route::delete('/box/delete/{id}', [StorageController::class, 'destroyBox'])->name('delete.box');
    });

    // ROUTE FOR DOCUMENT CATEGORY
    Route::prefix('document-type')->name('document-type.')->group(function () {
        Route::get("/", [DocumentTypeController::class, 'index'])->name('index');
        Route::get("/create", [DocumentTypeController::class, 'create'])->name('create');
        Route::post("/store", [DocumentTypeController::class, 'store'])->name('store');
        Route::delete("/{documentType}", [DocumentTypeController::class, 'destroy'])->name('destroy');
        Route::get("/{documentType}/edit", [DocumentTypeController::class, 'edit'])->name('edit');
        Route::put("/{documentType}/update", [DocumentTypeController::class, 'update'])->name('update');

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('document-type-datatable', [DocumentTypeController::class, 'getDocumentTypeDatatable'])->name('document-type-datatable');
        });
    });


    // ROUTE FOR USER
    Route::resource('user', UserController::class);

    Route::prefix('user')->name('user.')->group(function () {

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('user-datatable', [UserController::class, 'getUserDatatable'])->name('user-datatable');
        });
    });

    // ROUTE FOR PROJECT
    Route::prefix('project')->name('project.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get("/create", [ProjectController::class, 'create'])->name('create');
        Route::post("/store", [ProjectController::class, 'store'])->name('store');
        Route::get('/show/{id}', [ProjectController::class, 'show'])->name('show');
        Route::get("/edit/{id}", [ProjectController::class, 'edit'])->name('edit');
        Route::put("/update/{id}", [ProjectController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ProjectController::class, 'destroy'])->name('destroy');

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('document-type-datatable', [DocumentTypeController::class, 'getDocumentTypeDatatable'])->name('document-type-datatable');
        });
    });

   
});
