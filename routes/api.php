<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\EquipmentMappingController;
use App\Http\Controllers\ProteinLogController;

// Jalur untuk mengambil semua FAQ
Route::get('/faqs', [FaqController::class, 'index']);

// Jalur untuk mengambil semua data peralatan
Route::get('/equipments', [EquipmentMappingController::class, 'index']);

// Jalur khusus untuk mencari 1 alat spesifik (misal: dumbbell)
Route::get('/equipments/cari/{nama_alat}', [EquipmentMappingController::class, 'cariAlat']);

// Jalur untuk mengambil semua log protein
Route::apiResource('protein-logs', ProteinLogController::class);

use App\Http\Controllers\EquipmentController;

Route::get('/equipments', [EquipmentController::class, 'index']);

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route untuk Equipment
Route::get('/equipments', [EquipmentController::class, 'index']);
Route::post('/equipments', [EquipmentController::class, 'store']); // <-- Untuk Simpan
Route::delete('/equipments/{id}', [EquipmentController::class, 'destroy']); // <-- Untuk Hapus

Route::put('/equipments/{id}', [EquipmentController::class, 'update']);