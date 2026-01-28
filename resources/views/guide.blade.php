@extends('layouts.app')

@section('title', 'Petunjuk Penggunaan - Tesaurus Tematis')

@section('content')
<div class="container" style="padding: 3rem 2rem;">
    <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Petunjuk Penggunaan</h1>
    
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Cara Menggunakan Tesaurus</h2>
        
        <h3 style="font-size: 1.25rem; margin: 1.5rem 0 0.75rem;">1. Pencarian Kata</h3>
        <p style="margin-bottom: 1rem; line-height: 1.8;">
            Gunakan kotak pencarian di halaman utama untuk mencari kata yang Anda inginkan. 
            Anda dapat memfilter berdasarkan kelas kata (nomina, verba, adjektiva, dll).
        </p>
        
        <h3 style="font-size: 1.25rem; margin: 1.5rem 0 0.75rem;">2. Jelajah Kategori</h3>
        <p style="margin-bottom: 1rem; line-height: 1.8;">
            Klik menu "Kategori" untuk menjelajahi kata berdasarkan bidang ilmu seperti Pendidikan, Teknologi, Hukum, dll.
        </p>
        
        <h3 style="font-size: 1.25rem; margin: 1.5rem 0 0.75rem;">3. Detail Kata</h3>
        <p style="margin-bottom: 1rem; line-height: 1.8;">
            Setiap halaman kata menampilkan:
        </p>
        <ul style="margin-left: 1.5rem; line-height: 1.8;">
            <li><strong>Sinonim:</strong> Kata-kata yang memiliki makna serupa</li>
            <li><strong>Antonim:</strong> Kata-kata yang memiliki makna berlawanan</li>
            <li><strong>Contoh Penggunaan:</strong> Kalimat yang menunjukkan cara menggunakan kata</li>
            <li><strong>Kata Terkait:</strong> Kata-kata lain yang berhubungan</li>
        </ul>
    </div>
</div>
@endsection
