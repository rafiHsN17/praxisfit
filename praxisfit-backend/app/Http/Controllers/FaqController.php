<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data FAQ dari database
        $faqs = Faq::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $faqs
        ]);
    }
}