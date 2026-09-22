<?php

namespace App\Http\Controllers;

use App\Models\ProteinLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProteinLogController extends Controller
{
    public function index()
    {
        $data = ProteinLog::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'        => 'required|integer',
            'jumlah_protein' => 'required|integer',
            'sumber_makanan' => 'required|string',
            'tanggal'        => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $protein = ProteinLog::create($request->all());
        return response()->json(['success' => true, 'message' => 'Berhasil disimpan', 'data' => $protein], 201);
    }

    // 4. MENGUBAH data (PUT/PATCH) - Ini fitur barunya!
    public function update(Request $request, $id)
    {
        $protein = ProteinLog::find($id);

        if (!$protein) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
        }

        $protein->update($request->all());

        return response()->json(['success' => true, 'message' => 'Data berhasil diubah!', 'data' => $protein]);
    }

    public function destroy($id)
    {
        $protein = ProteinLog::find($id);

        if (!$protein) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!'], 404);
        }

        $protein->delete();

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }
}