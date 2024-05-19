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

        // PakarTernak::create($data);

        // // Add response for empty fields
        if (empty($data['waktu_panen']) || empty($data['budget_tahunan']) || empty($data['metode_panen']) || empty($data['jenis_pakan']) || empty($data['jenis_ikan']) || empty($data['keyakinan_metode_pakan']) || empty($data['keyakinan_metode_panen'])) {
            return response()->json(['message' => 'Field wajib diisi'], 400);
        }

        $urgensi = "";
        $strategi = "";
        $rekomendasi = "";
        $cfurgensi = 1;
        $cfstrategi = 1;
        $cfrekomendasi = 1;

        #rule 1-4
        if($data['waktu_panen'] == "waktu" && $data['metode_panen'] == "perlu_drainase") {
            $urgensi = "sedikit";
            $cfrule = 1;
            $cfurgensi = min($data['keyakinan_metode_panen'], 1) * $cfrule;
        }

        if($data['waktu_panen'] == "waktu" && $data['metode_panen'] == "tidak_perlu_drainase") {
            $urgensi = "tidak perlu";
            $cfrule = 1;
            $cfurgensi = min($data['keyakinan_metode_panen'], 1) * $cfrule;
        }

        if($data['waktu_panen'] == "berat" && $data['metode_panen'] == "perlu_drainase") {
            $urgensi = "perlu";
            $cfrule = 1;
            $cfurgensi = min($data['keyakinan_metode_panen'], 1) * $cfrule;
        }

        if($data['waktu_panen'] == "berat" && $data['metode_panen'] == "tidak_perlu_drainase") {
            $urgensi = "sedikit";
            $cfrule = 1;
            $cfurgensi = min($data['keyakinan_metode_panen'], 1) * $cfrule;
        }

        #rule 5-7
        if($data['jenis_pakan'] == "bebas" && $data['jenis_ikan'] == "sama_jenis") {
            $strategi = "umum";
            $cfrule = 1;
            $cfstrategi = min($data['keyakinan_metode_pakan'], 1) * $cfrule;
        }

        if($data['jenis_pakan'] == "bebas" && $data['jenis_ikan'] == "campur_jenis") {
            $strategi = "spesifik";
            $cfrule = 0.8;
            $cfstrategi = min($data['keyakinan_metode_pakan'], 1) * $cfrule;
        }

        if($data['jenis_pakan'] == "spesifik") {
            $strategi = "spesifik";
            $cfrule = 1;
            $cfstrategi = min($data['keyakinan_metode_pakan'], 1) * $cfrule;
        }

        #rule 8 - 11
        if($urgensi == "tidak perlu" && $strategi == "umum") {
            $rekomendasi = "Tidak perlu alat";
            $cfrule = 0.8;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "tidak perlu" && $strategi == "spesifik") {
            $rekomendasi = "Alat pemberi makan otomatis";
            $cfrule = 0.85;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "sedikit" && $strategi == "umum") {
            $rekomendasi = "Sistem pompa air";
            $cfrule = 0.85;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "sedikit" && $strategi == "spesifik") {
            $rekomendasi = "paket 1";
            $cfrule = 0.9;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        #rule 12 - 17
        if($urgensi == "perlu" && $strategi == "umum" && $data['budget_tahunan'] == "rendah") {
            $rekomendasi = "Sistem pompa air";
            $cfrule = 0.9;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }
        
        if($urgensi == "perlu" && $strategi == "umum" && $data['budget_tahunan'] == "sedang") {
            $rekomendasi = "paket 2";
            $cfrule = 0.85;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "perlu" && $strategi == "umum" && $data['budget_tahunan'] == "tinggi") {
            $rekomendasi = "paket 3";
            $cfrule = 0.9;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "perlu" && $strategi == "spesifik" && $data['budget_tahunan'] == "rendah") {
            $rekomendasi = "paket 1";
            $cfrule = 0.8;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "perlu" && $strategi == "spesifik" && $data['budget_tahunan'] == "sedang") {
            $rekomendasi = "paket 4";
            $cfrule = 0.85;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        if($urgensi == "perlu" && $strategi == "spesifik" && $data['budget_tahunan'] == "tinggi") {
            $rekomendasi = "paket 5";
            $cfrule = 0.95;
            $cfrekomendasi = min($cfurgensi, $cfstrategi, 1) * $cfrule;
        }

        $result = ["keyakinan" => $cfrekomendasi*100, "rekomendasi" => $rekomendasi];

        // Return data in JSON format
        return response()->json($result);
    }
}
