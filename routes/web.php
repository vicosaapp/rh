Route::middleware(['auth'])->group(function () {
    Route::middleware(['checkstatus'])->group(function () {
        Route::middleware(['admin'])->group(function () {
            Route::resource('people', PeopleController::class);
            
            Route::post('admin/employee/store', [EmployeeController::class, 'store']);
        });
    });
}); 