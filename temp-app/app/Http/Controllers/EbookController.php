<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\Reader;
class EbookController extends Controller
{
    public function index(Request $request)
    {

        $ip = $request->ip();
        $agent = $request->header('User-Agent');

        // 1. Ekstraksi Sistem Operasi
        $os = 'Sistem Tidak Dikenal';
        if (preg_match('/windows nt 10/i', $agent)) $os = 'Windows 10/11';
        elseif (preg_match('/windows nt 6\.3/i', $agent)) $os = 'Windows 8.1';
        elseif (preg_match('/windows nt 6\.2/i', $agent)) $os = 'Windows 8';
        elseif (preg_match('/windows nt 6\.1/i', $agent)) $os = 'Windows 7';
        elseif (preg_match('/macintosh|mac os x/i', $agent)) $os = 'Mac OS';
        elseif (preg_match('/android/i', $agent)) $os = 'Android';
        elseif (preg_match('/iphone/i', $agent)) $os = 'iPhone (iOS)';
        elseif (preg_match('/ipad/i', $agent)) $os = 'iPad (iOS)';
        elseif (preg_match('/linux/i', $agent)) $os = 'Linux';

        // 2. Ekstraksi Browser
        $browser = 'Browser Tidak Dikenal';
        if (preg_match('/Edg/i', $agent)) $browser = 'Microsoft Edge';
        elseif (preg_match('/OPR/i', $agent)) $browser = 'Opera';
        elseif (preg_match('/Chrome/i', $agent)) $browser = 'Google Chrome';
        elseif (preg_match('/Safari/i', $agent)) $browser = 'Apple Safari';
        elseif (preg_match('/Firefox/i', $agent)) $browser = 'Mozilla Firefox';

        // 3. Ekstraksi Tipe Perangkat
        $deviceType = 'Desktop / PC';
        if (preg_match('/mobile/i', $agent)) $deviceType = 'Smartphone';
        elseif (preg_match('/tablet|ipad/i', $agent)) $deviceType = 'Tablet';

        // Gabungkan menggunakan separator (Pemisah pipa | agar mudah dibaca di view)
        $detailedDevice = "$deviceType|$os|$browser";

        \App\Models\Reader::updateOrCreate(
            ['ip_address' => $ip],
            [
                'device_name' => $detailedDevice,
                'user_agent' => $agent,
                'last_accessed_at' => now(),
            ]
        );
        // Ambil semua buku dan ambil semua form secara global
        $books = Book::with(['parts.chapters'])->get();
        $allForms = Form::with('book')->get();

        $activeChapter = null;
        $activeBook = null;
        $activeForm = null;
        $searchResults = null;

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $searchResults = Chapter::with('part')
                ->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->get();
        } elseif ($request->has('read')) {
            $activeChapter = Chapter::with('part.book')->findOrFail($request->read);
            $activeBook = $activeChapter->part->book;
        } elseif ($request->has('read_book')) {
            $activeBook = Book::findOrFail($request->read_book);
        } elseif ($request->has('read_form')) {
            // INI LOGIKA UNTUK MENAMPILKAN FORM DI KANAN
            $activeForm = Form::with('book')->findOrFail($request->read_form);
        }

        return view('ebook.index', compact('books', 'allForms', 'activeChapter', 'activeBook', 'activeForm', 'searchResults'));
    }
}
