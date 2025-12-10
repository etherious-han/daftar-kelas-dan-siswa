<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function __construct()
    {
        // Middleware: cuma admin yang bisa akses CRUD
        $this->middleware(['auth','admin'])->only([
            'createByKelas','storeByKelas','edit','update','delete','tampil'
        ]);

        // Middleware: siswa harus login untuk akses dashboard dan kelas mereka
        $this->middleware(['auth', 'siswa'])->only(['dashboard', 'kelasSiswa']); // ✅ UBAH: lihatKelas jadi kelasSiswa
        
        // Middleware: semua yang login bisa akses perKelas
        $this->middleware(['auth'])->only(['perKelas']);
    }

    // ============================================================
    //  TAMPIL SISWA PER KELAS (LIST)
    // ============================================================
    public function perKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $query = Siswa::where('kelas_id', $id);

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $siswa = $query->paginate(10);

        // Cek role, beda view untuk admin dan siswa
        if(Auth::user()->role === 'siswa'){
            return view('siswa.perkelas_siswa', compact('kelas', 'siswa'));
        }

        return view('siswa.perkelas_admin', compact('kelas', 'siswa'));
    }

    // ============================================================
    //  REDIRECT SISWA KE KELAS MEREKA (NEW) ✅ TAMBAH METHOD INI
    // ============================================================
  public function kelasSiswa(Request $request)
{
    $user = Auth::user();
    
    // Ambil data siswa berdasarkan user yang login
    $siswaData = Siswa::where('user_id', $user->id)->first();
    
    // Query kelas
    $query = Kelas::query();
    
    // Kalau mau cuma kelas siswa itu aja (uncomment baris ini)
    // if ($siswaData && $siswaData->kelas_id) {
    //     $query->where('id', $siswaData->kelas_id);
    // }
    
    // Search
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_kelas', 'like', '%' . $request->search . '%');
    }
    
    // Pagination
    $kelas = $query->paginate(10);
    
    // Tampilkan view daftar kelas
    return view('kelas.index_siswa', compact('kelas'));
}

    // ============================================================
    //  STORE / TAMBAH SISWA (ADMIN)
    // ============================================================
    public function storeByKelas(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        // Cek duplikat nama di kelas yang sama
        if (Siswa::where('kelas_id', $id)->where('nama', $request->nama)->exists()) {
            return redirect()
                ->route('siswa.perkelas', $id)
                ->with('error', 'Nama siswa sudah ada di kelas ini!');
        }

        // Cek duplikat NIS di kelas yang sama
        if (Siswa::where('kelas_id', $id)->where('nis', $request->nis)->exists()) {
            return redirect()
                ->route('siswa.perkelas', $id)
                ->with('error', 'NIS sudah digunakan di kelas ini!');
        }

        Siswa::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nis' => $request->nis,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $id
        ]);

        return redirect()
            ->route('siswa.perkelas', $id)
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    // ============================================================
    //  EDIT SISWA (ADMIN)
    // ============================================================
    public function edit($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);
        $kelas = $siswa->kelas;
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    // ============================================================
    //  UPDATE SISWA (ADMIN)
    // ============================================================
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama' => ['required','string','max:255',
                Rule::unique('siswa')->ignore($id)->where(function($query) use ($siswa, $request){
                    return $query->where('kelas_id', $siswa->kelas_id)
                                 ->where('nama', $request->nama);
                })
            ],
            'nis' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $siswa->update($request->all());

        return redirect()
            ->route('siswa.perkelas', ['id'=>$siswa->kelas_id])
            ->with('success','Data siswa berhasil diupdate!');
    }

    // ============================================================
    //  DELETE SISWA (ADMIN)
    // ============================================================
    public function delete($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas_id = $siswa->kelas_id;
        $siswa->delete();

        return redirect()
            ->route('siswa.perkelas', ['id'=>$kelas_id])
            ->with('success','Siswa berhasil dihapus!');
    }

    // ============================================================
    //  HALAMAN INDEX SEMUA SISWA (HANYA ADMIN)
    // ============================================================
    public function tampil(Request $request)
    {
        $keyword = $request->keyword;

        $siswa = Siswa::with('kelas')
            ->when($keyword, function($query) use($keyword){
                $query->where('nama','like','%'.$keyword.'%')
                      ->orWhere('nis','like','%'.$keyword.'%');
            })
            ->paginate(10);

        return view('siswa.index', compact('siswa', 'keyword'));
    }
    
    // ============================================================
    //  DASHBOARD SISWA
    // ============================================================
    public function dashboard()
    {
        $user = Auth::user();
        $siswaData = Siswa::where('user_id', $user->id)->with('kelas')->first();
        
        return view('siswa.dashboard', compact('siswaData'));
    }
    
    // ============================================================
    //  LIHAT KELAS SISWA (BISA DIHAPUS, GAK KEPAKE LAGI) ❌
    // ============================================================
    public function lihatKelas()
    {
        $user = Auth::user();
        
        // Ambil data siswa berdasarkan user yang login
        $siswaData = Siswa::where('user_id', $user->id)->first();
        
        if ($siswaData && $siswaData->kelas_id) {
            // Ambil kelas siswa (hanya 1 kelas)
            $kelas = Kelas::find($siswaData->kelas_id);
        } else {
            $kelas = null;
        }
        
        return view('kelas.index_siswa', compact('kelas'));
    }
}