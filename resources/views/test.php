Route::group(['prefix' => 'estimates'], function () {

Route::get('/', [EstimatesController::class, 'index'])->name('estimates.estimate.index');
Route::get('/create', [EstimatesController::class, 'create'])->name('estimates.estimate.create');
Route::get('/show/{estimate}', [EstimatesController::class, 'show'])->name('estimates.estimate.show')->where('id', '[0-9]+');
Route::get('/share/{estimate}', [EstimatesController::class, 'share'])->name('estimates.estimate.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
Route::get('/send/{estimate}', [EstimatesController::class, 'send'])->name('estimates.estimate.send')->where('id', '[0-9]+');
Route::get('/{estimate}/edit', [EstimatesController::class, 'edit'])->name('estimates.estimate.edit')->where('id', '[0-9]+');
Route::post('/', [EstimatesController::class, 'store'])->name('estimates.estimate.store');
Route::post('/send/{estimate}', [EstimatesController::class, 'sendestimateMail'])->name('estimates.estimate.send_estimate_mail');
Route::put('estimate/{estimate}', [EstimatesController::class, 'update'])->name('estimates.estimate.update')->where('id', '[0-9]+');
Route::delete('/estimate/{estimate}', [EstimatesController::class, 'destroy'])->name('estimates.estimate.destroy')->where('id', '[0-9]+');

});
