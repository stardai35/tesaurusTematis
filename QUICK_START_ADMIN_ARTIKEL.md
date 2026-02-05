# 🚀 Quick Start - Admin Artikel Management

## Akses Admin Panel

1. Login ke sistem → Dashboard Admin
2. Menu Sidebar → **Artikel**
3. Pilih: Create, Edit, atau Delete

## 🆕 Membuat Artikel Baru

### Step 1: Informasi Dasar
- **Judul**: Nama artikel (contoh: "Bilangan", "Keluarga")
- **Kategori**: Pilih kategori utama
- **Sub-Kategori**: Pilih sub-kategori (opsional)
- **Nomor Urut**: Untuk pengurutan (opsional)

### Step 2: Tambah Kata-Kata

#### Opsi A: Quick-Add (Cepat)
```
1. Lihat tombol: V N A K R P D
2. Klik salah satu (misalnya "V - Verba")
3. Otomatis membuat form untuk kata dari class itu
4. Isi lemma dan detail lainnya
```

#### Opsi B: Manual Add
```
1. Klik "+ Tambah Kata Manual"
2. Isi semua field
3. Repeat untuk kata berikutnya
```

### Step 3: Isi Detail Setiap Kata

| Field | Wajib | Keterangan |
|-------|-------|-----------|
| **Kata (Lemma)** | ✅ | Pilih kata dari database |
| **Kelas Kata** | ✅ | V/N/A/K/R/P/D |
| **Tipe Relasi** | ❌ | Contoh: sinonim, antonim |
| **Urutan** | ❌ | Nomor urut kata (1, 2, 3...) |
| **Deskripsi** | ❌ | Penjelasan makna/penggunaan |

### Step 4: Simpan
Klik tombol **💾 Simpan Artikel**

---

## ✏️ Edit Artikel Existing

1. Go to Admin → Artikel
2. Klik tombol **Edit** pada artikel yang ingin diubah
3. Ubah informasi dasar jika perlu
4. Update kata-kata:
   - **Tambah**: Gunakan quick-add atau manual add
   - **Edit**: Ubah value di field (sama dengan create)
   - **Hapus**: Klik 🗑️ tombol pada kata
5. Klik **💾 Simpan Perubahan**

---

## 🧠 Cara Kerja Admin Form

### Architecture
```
ARTIKEL FORM
├─ Informasi Dasar (title, kategori, dll)
└─ Pengelolaan Kata & Relasi (terpusat)
   ├─ Word Class Quick-Add (V, N, A, K, R, P, D)
   └─ Manual Add (kontrol penuh)
       └─ Form fields untuk setiap kata:
          ├─ Lemma selector
          ├─ Word class selector
          ├─ Type selector
          ├─ Word order input
          └─ Description textarea
```

### Real-Time Features

| Fitur | Fungsi |
|-------|--------|
| **Word Count Badge** | Tampilkan jumlah kata yang ditambahkan |
| **Lemma Info Box** | Tampilkan label info saat memilih kata |
| **Quick-Add Buttons** | Cepat membuat form dengan word class preset |
| **Remove Button** | Hapus kata dari artikel dengan konfirmasi |

---

## 💡 Tips Penggunaan

### Menambah Artikel "Bilangan" (Contoh)

```
1. Judul: "Bilangan"
2. Kategori: "Istilah"
3. Sub-Kategori: "Matematika"

4. Klik button "V - Verba"
   └─ Form muncul, word class sudah terisi
   └─ Pilih lemma: "membilang"
   └─ Klik field → lihat label info
   └─ Isi deskripsi: "Melakukan proses perhitungan"

5. Klik button "N - Nomina"
   └─ Form baru muncul
   └─ Pilih lemma: "bilangan"
   └─ Isi deskripsi: "Simbol atau nilai angka"

6. Klik button "A - Adjektiva"
   └─ Pilih lemma: "desimal"
   └─ Tipe relasi: "sinonim"
   └─ Isi deskripsi: "Berbasis angka 10"

7. Klik "💾 Simpan Artikel"
   └─ Simpan sekaligus dengan semua kata-katanya
```

### Best Practices

✅ **DO**
- Gunakan quick-add buttons untuk input lebih cepat
- Isi deskripsi untuk clarify makna kata
- Set urutan kata yang logis
- Review sebelum save

❌ **DON'T**
- Jangan hapus kata penting tanpa backup
- Jangan biarkan lemma kosong
- Jangan gunakan word class yang salah

---

## 🎯 Word Class Reference

| Kode | Nama | Contoh |
|------|------|--------|
| **V** | Verba | membaca, makan, berlari |
| **N** | Nomina | buku, rumah, manusia |
| **A** | Adjektiva | indah, besar, merah |
| **K** | Konjungsi | dan, atau, tetapi |
| **R** | Keterangan | cepat, di sini, kemarin |
| **P** | Preposisi | di, ke, dari |
| **D** | Determiner | ini, itu, yang |

---

## 🐛 Troubleshooting

### Lemma tidak muncul di dropdown?
→ Pastikan lemma sudah ada di database (Admin → Lemma → Tambah)

### Word count tidak update?
→ Refresh browser atau buka ulang form

### Form error saat save?
→ Cek warning/error messages
→ Pastikan semua field wajib sudah diisi
→ Pastikan lemma dan word class valid

### Tidak bisa edit artikel?
→ Pastikan sudah login dengan akses admin
→ Check jika artikel ada atau sudah dihapus

---

## 📊 Integrasi Sistem

Setelah artikel disimpan, data akan:
1. ✅ Muncul di halaman publik `/artikel`
2. ✅ Muncul di halaman subcategory `/artikel/subcategory/{slug}`
3. ✅ Muncul di halaman detail artikel `/artikel/{article}`
4. ✅ Grouped by word class otomatis di semua halaman

---

## 📝 Catatan Penting

- **Database**: Tidak ada database schema baru, semua menggunakan tabel existing
- **Cascade Delete**: Jika artikel dihapus, semua word relations otomatis dihapus
- **No Separate Management**: Tidak ada lagi page terpisah untuk word-relations
- **All-in-One**: Semua manajemen kata ada dalam article create/edit form

---

## 🔗 Related Pages

- Public Article List: `/artikel`
- Public Article Detail: `/artikel/{article}`
- Public Subcategory View: `/artikel/subcategory/{slug}`
- Admin Articles List: `/admin/articles`
- Admin Create Article: `/admin/articles/create`
- Admin Edit Article: `/admin/articles/{id}/edit`

---

**Status**: ✅ READY TO USE
**Last Updated**: Feb 2025
