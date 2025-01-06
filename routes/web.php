<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return jsonResponse(true, 'Response berhasil', null, 200);
});

// code 200 
// return response()->json([
//     'success' => true,
//     'message' => 'Response berhasil',
//     'data' => null
// ]);

// code 400
// {
//     "success": false,
//     "message": "Bad Request",
//     "errors": {
//         "field": "This field is required"
//     }
// }

// code 404
// return response()->json([
//     'success' => false,
//     'message' => 'Data tidak ditemukan',
//     'data'    => null
// ], 404); 