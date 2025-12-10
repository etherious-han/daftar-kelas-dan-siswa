<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware admin wajib login & role admin
        $this->middleware(['auth','admin']);
    }

    // ============================================================
    // DASHBOARD ADMIN
    // ============================================================
    public function dashboard()
    {
        $kelas = Kelas::all();
        $siswa = Siswa::all();
        return view('admin.dashboard', compact('kelas','siswa'));
    }

    // ============================================================
    // CRUD KELAS
    // ============================================================

    // Index semua kelas
    public function indexKelas()
    {
        $kelas = Kelas::paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    // Form tambah kelas
    public function createKelas()
    {
        return view('admin.kelas.create');
    }

    // Store kelas baru
    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:kelas,nama',
            'wali_kelas' => 'nullable|string|max:255',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success','Kelas berhasil ditambahkan!');
    }

    // Form edit kelas
    public function editKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    // Update kelas
    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama' => ['required','string',
                Rule::unique('kelas')->ignore($id)
            ],
            'wali_kelas' => 'nullable|string|max:255',
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success','Kelas berhasil diupdate!');
    }

    // Delete kelas
    public function deleteKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success','Kelas berhasil dihapus!');
    }

    // ============================================================
    // CRUD SISWA (Admin bisa akses juga lewat sini jika mau)
    // ============================================================

    public function indexSiswa()
    {
        $siswa = Siswa::paginate(10);
        return view('admin.siswa.index', compact('siswa'));
    }

    public function createSiswa()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function storeSiswa(Request $request)
    {
        if (Siswa::where('kelas_id', $request->kelas_id)->where('nama', $request->nama)->exists()) {
            return redirect()->back()->with('error','Nama siswa sudah ada di kelas ini!');
        }

        if (Siswa::where('kelas_id', $request->kelas_id)->where('nis', $request->nis)->exists()) {
            return redirect()->back()->with('error','NIS sudah digunakan di kelas ini!');
        }

        Siswa::create($request->all());

        return redirect()->route('admin.siswa.index')->with('success','Siswa berhasil ditambahkan!');
    }

    public function editSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa','kelas'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama' => ['required','string','max:255',
                Rule::unique('siswa')->ignore($id)->where(function($query) use($siswa,$request){
                    return $query->where('kelas_id',$siswa->kelas_id)
                                 ->where('nama',$request->nama);
                })
            ],
            'nis' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')->with('success','Siswa berhasil diupdate!');
    }

    public function deleteSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success','Siswa berhasil dihapus!');
    }
}
