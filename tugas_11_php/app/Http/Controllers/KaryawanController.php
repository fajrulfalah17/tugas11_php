<?php

namespace App\Http\Controllers;

use App\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = DB::table('table_karyawan')->get();
        if(count($data) > 0)
        {
            $res['message'] = "Success";
            $res['value'] = $data;

            return response($res);
        }
        else
        {
            $res['message'] = "Empty!";

            return response($res);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'umur' => 'required',
            'alamat' => 'required',
            'file' => 'required|max:4096'
        ]);

        // save data
        $file = $request->file('file');
        $nama_file = time()."_".$file->getClientOriginalName();

        // upload $file
        $tujuan_upload = 'assets';
        if($file->move($tujuan_upload, $nama_file))
        {
            $data = Karyawan::create([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'umur' => $request->umur,
                'alamat' => $request->alamat,
                'foto' => $nama_file,
            ]);

            $res['message'] = "Success";
            $res['value'] = $data;

            return response($res);
        }
    }

    public function update(Request $request)
    {
        if(!empty($request->file))
        {
            $this->validate($request, [
                'nama' => 'required|string',
                'jabatan' => 'required|string',
                'umur' => 'required',
                'alamat' => 'required',
                'file' => 'required|max:4096'
            ]);

            $file = $request->file('file');

            $nama_file = time()."_".$file->getClientOriginalName();

            $tujuan_upload = 'assets';
            $file->move($tujuan_upload, $nama_file);

            $data = DB::table('table_karyawan')->where('id', $request->id)->get();
            foreach($data as $katalog) {
                @unlink(public_path('data_file/' . $katalog->foto));
                $new = DB::table('table_karyawan')->where('id', $request->id)->update([
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'umur' => $request->umur,
                    'alamat' => $request->alamat,
                    'foto' => $nama_file,
                ]);
                $res['message'] = "Success";
                $res['value'] = $new;

                return response($res);
            }
        }
        else
        {
            $data = DB::table('table_karyawan')->where('id', $request->id)->get();
            foreach($data as $katalog) {
                $new = DB::table('table_karyawan')->where('id', $request->id)->update([
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'umur' => $request->umur,
                    'alamat' => $request->alamat
                ]);
                $res['message'] = "Success";
                $res['value'] = $new;

                return response($res);
            }
        }
    }

    public function delete($id)
    {
        $data = DB::table('table_karyawan')->where('id', $id)->get();
        foreach($data as $katalog) {
            if(file_exists(public_path('assets/'. $katalog->foto)))
            {
                @unlink(public_path('assets/' . $katalog->foto));

                DB::table('table_karyawan')->where('id', $id)->delete();

                $res['message'] = "Success";

                return response($res);
            }

            $res['message'] = "Data Kosong";

            return response($res);
        }
    }
    public function show($id)
    {
        $data = DB::table('table_karyawan')->where('id', $id)->get();
        if(count($data) > 0)
        {
            $res['message'] = "Success";
            $res['value'] = $data;

            return response($res);
        }
        else
        {
            $res['message'] = "Empty!";

            return response($res);
        }
    }
}
