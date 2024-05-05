<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function returnInput(Request $request)
    {
        $request->validate([
            'waktu_panen' => 'required|numeric|min:1|max:12',
            'budget_tahunan' => 'required|numeric|min:1',
            'metode_panen' => 'required',
            'jenis_pakan' => 'required',
            'jenis_ikan' => 'required',
        ]);

        $data = [
            'waktu_panen' => $request->input('waktu_panen'),
            'budget_tahunan' => $request->input('budget_tahunan'),
            'metode_panen' => $request->input('metode_panen'),
            'jenis_pakan' => $request->input('jenis_pakan'),
            'jenis_ikan' => $request->input('jenis_ikan'),
        ];

        // Add response for empty fields
        if (empty($data['waktu_panen']) || empty($data['budget_tahunan']) || empty($data['metode_panen']) || empty($data['jenis_pakan']) || empty($data['jenis_ikan'])) {
            return response()->json(['message' => 'Field wajib diisi'], 400);
        }

        // Add response for invalid waktu_panen
        $waktu_panen = $data['waktu_panen'];
        $budget_tahunan = $data['budget_tahunan'];

        if ($waktu_panen < 1 || $waktu_panen > 12) {
            return response()->json(['message' => 'Waktu panen harus berada antara 1 dan 12'], 400);
        }

        // Add response for invalid budget_tahunan
        if ($budget_tahunan < 1) {
            return response()->json(['message' => 'Budget tahunan harus lebih dari 0'], 400);
        }

        // Return data in JSON format
        return response()->json($data);
    }
}
