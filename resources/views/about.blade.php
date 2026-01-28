@extends('layouts.app')

@section('title', 'Tentang - Tesaurus Tematis')

@section('content')
<div class="container" style="padding: 3rem 2rem;">
    <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Tentang Tesaurus Tematis</h1>
    
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <p style="margin-bottom: 1rem; line-height: 1.8;">
            Tesaurus Tematis Bahasa Indonesia adalah kamus sinonim dan padanan kata yang disusun berdasarkan tema atau bidang ilmu tertentu. 
            Tesaurus ini bertujuan untuk membantu pengguna menemukan kata-kata yang tepat dalam berbagai konteks penggunaan bahasa Indonesia.
        </p>
        
        <p style="margin-bottom: 1rem; line-height: 1.8;">
            Dikembangkan oleh Badan Pengembangan dan Pembinaan Bahasa, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia, 
            tesaurus ini menjadi rujukan penting bagi penulis, pelajar, dan siapa saja yang ingin memperkaya kosakata bahasa Indonesia.
        </p>
        
        <h2 style="font-size: 1.5rem; margin: 2rem 0 1rem;">Fitur Utama</h2>
        <ul style="margin-left: 1.5rem; line-height: 1.8;">
            <li>Pencarian kata berdasarkan kelas kata (nomina, verba, adjektiva, dll)</li>
            <li>Sinonim dan antonim yang terstruktur</li>
            <li>Kategori berdasarkan bidang ilmu</li>
            <li>Contoh penggunaan kata dalam kalimat</li>
            <li>Kata-kata terkait untuk memperluas wawasan</li>
        </ul>
    </div>
</div>
@endsection
