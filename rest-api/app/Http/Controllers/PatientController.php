<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller{
    # membuat method index
    public function index() {
        # menampilkan data patients dari database
        $patients = Patient::all();
        # menghitung jumlah data pada tabel patient
        $total = count($patients);
        # jika resource ada
        if ($total) {
            # maka data akan ditampilkan
            $data = [
                'message' => 'Get all patients',
                'data' => $patients
            ];
            # mengirim data (json) dan kode 200
            return response()->json($data, 200);

        }else { # jika resource tidak ada
            # maka akan menampilkan pesan 'Data is empty'
            $data = [
                'message' => 'Data is empty'
            ];
            # mengirim data (json) dan kode 200
            return response()->json($data, 404);
        }
    }

    # membuat method store
    public function store(Request $request) {
        # membuat validasi
        $validated = $request->validate([
            # column => 'rules|rules'
            'name' => 'required',
            'phone' => 'required|min:10|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'null|date'
        ]);

        # menggunakan model Patient untuk insert data
        $patient = Patient::create($validated);

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patient,
        ];

        # mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }

    # membuat method show
    public function show($id) {
        # cari id patient yang ingin dilihat
        $patient = Patient::find($id);
        # jika data ada
        if ($patient) {
            # data akan ditampilkan
            $data = [
                'message' => 'Get detail resource',
                'data' => $patient
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else { # jika data tidak ada
            # akan menampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];

            # mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method update
    public function update(Request $request, $id) {
        # cari id patient yang ingin diupdate
        $patient = Patient::find($id);
        # jika data ada
        if ($patient) {
            # akan menangkap data request
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];

            # melakukan update data
            $patient->update($input);

            $data = [
                'message' => 'Resource is updated successfully',
                'data' => $patient
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else{ # jika data tidak ada
            # akan menampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];
            # mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method destroy
    public function destroy($id) {
        # cari id patient yang ingin dihapus
        $patient = Patient::find($id);
        # jika data patient ada
        if ($patient) {
            # data patient akan dihapus
            $patient->delete();

            $data = [
                'message' => 'Resource is deleted successfully'
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else { # jika data patient tidak ada
            # akan menampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];

            # mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method search
    public function search($name) {
        # mencari data patient dengan name
        $patient = Patient::where('name', 'like', '%'.$name.'%')->get();
        # menghitung jumlah patient
        $total = count($patient);
        # jika data ada
        if ($total) {
            # data akan ditampilkan
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $patient
            ];
            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else { # jika data tidak ada
            # akan menampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];
            # mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method positive
    public function positive() {
        # mencari patient yang berstatus positive
        $patient = Patient::where('status', 'positive')->get();
        # menghitung jumlah patient
        $total = count($patient);
        # menampilkan data
        $data = [
            'message' => 'Get positive resource',
            'total' => $total,
            'data' => $patient
        ];
        # mengembalikan data (json) dan kode 200
        return response()->json($data, 200);
    }

    # membuat method recovered
    public function recovered() {
        # mencari patient yang berstatus recovered
        $patient = Patient::where('status', 'recovered')->get();
        # menghitung jumlah patient
        $total = count($patient);
        # menampilkan data
        $data = [
            'message' => 'Get recovered resource',
            'total' => $total,
            'data' => $patient
        ];
        # mengembalikan data (json) dan kode 200
        return response()->json($data, 200);
    }

    # membuat method dead
    public function dead() {
        # mencari patient yang berstatus dead
        $patient = Patient::where('status', 'dead')->get();
        # menghitung jumlah patient
        $total = count($patient);
        # menampilkan data
        $data = [
            'message' => 'Get dead resource',
            'total' => $total,
            'data' => $patient
        ];
        # mengembalikan data (json) dan kode 200
        return response()->json($data, 200);
    }
}
