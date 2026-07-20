<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Sinkronkan role yang dipilih dari form modal
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Akun Administrator baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Perbarui sinkronisasi role
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Data administrator berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan biarkan admin menghapus akunnya sendiri yang sedang aktif login
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan saat ini.');
        }

        $user->delete();

        return back()->with('success', 'Akun administrator berhasil dihapus.');
    }

    // --- PENGATURAN PROFIL PRIBADI ADMIN ---
    public function editProfile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan tidak sesuai.']);
            }
            $user->password = Hash::make($request->password);
        }

        // Tangani Gambar Hasil Crop (Base64)
        if ($request->filled('cropped_image')) {
            $base64Image = $request->cropped_image;

            // Pisahkan header data base64
            list($type, $base64Image) = explode(';', $base64Image);
            list(, $base64Image)      = explode(',', $base64Image);
            $imageDecoded = base64_decode($base64Image);

            $filename = time() . '_cropped.jpg';
            $destinationPath = public_path('uploads/profiles');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Simpan file hasil crop ke folder public/uploads/profiles
            file_put_contents($destinationPath . '/' . $filename, $imageDecoded);

            // Hapus foto lama jika ada
            if ($user->profile_photo && File::exists($destinationPath . '/' . $user->profile_photo)) {
                File::delete($destinationPath . '/' . $user->profile_photo);
            }

            $user->profile_photo = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil dan foto berhasil diperbarui.');
    }
}
