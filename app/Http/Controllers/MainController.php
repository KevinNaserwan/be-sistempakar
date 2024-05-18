<?php

namespace App\Http\Controllers;

use App\Models\PakarTernak;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function returnInput(Request $request)
    {
        $request->validate([
            'waktu_panen' => 'required',
            'budget_tahunan' => 'required',
            'metode_panen' => 'required',
            'jenis_pakan' => 'required',
            'jenis_ikan' => 'required',
            'keyakinan_metode_pakan' => 'required',
            'keyakinan_metode_panen' => 'required',
        ]);

        $data = [
            'waktu_panen' => $request->input('waktu_panen'),
            'budget_tahunan' => $request->input('budget_tahunan'),
            'metode_panen' => $request->input('metode_panen'),
            'jenis_pakan' => $request->input('jenis_pakan'),
            'jenis_ikan' => $request->input('jenis_ikan'),
            'keyakinan_metode_pakan' => $request->input('keyakinan_metode_pakan'),
            'keyakinan_metode_panen' => $request->input('keyakinan_metode_panen'),
        ];

        PakarTernak::create($data);

        // // Add response for empty fields
        if (empty($data['waktu_panen']) || empty($data['budget_tahunan']) || empty($data['metode_panen']) || empty($data['jenis_pakan']) || empty($data['jenis_ikan']) || empty($data['keyakinan_metode_pakan']) || empty($data['keyakinan_metode_panen'])) {
            return response()->json(['message' => 'Field wajib diisi'], 400);
        }

        // Return data in JSON format
        return response()->json($data);
    }
}
