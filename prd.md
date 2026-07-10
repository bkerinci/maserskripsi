# PRD – ThesisAI

**Platform AI Penyusun Skripsi, Tesis, dan Disertasi**

**Versi:** MVP 1.0
**Framework:** Laravel 13
**Frontend (Rekomendasi):** Blade + Livewire + Tailwind CSS
**Alternatif:** Vue.js atau React (opsional untuk versi Enterprise)

---

# 1. Ringkasan Produk

ThesisAI adalah platform AI yang membantu mahasiswa menyusun skripsi, tesis, maupun disertasi secara bertahap sesuai kaidah akademik.

Fokus aplikasi bukan sekadar menghasilkan tulisan dengan AI, tetapi menjadi **AI Academic Assistant** yang:

* membantu menemukan topik
* menyusun proposal
* membuat BAB 1–BAB 5
* mencari referensi
* membuat sitasi otomatis
* melakukan parafrase akademik
* memeriksa plagiarisme (integrasi pihak ketiga)
* memberi masukan metodologi
* menghasilkan tabel penelitian
* membuat instrumen penelitian
* membantu analisis data
* menghasilkan kesimpulan sesuai hasil penelitian

---

# 2. Target Pengguna

* Mahasiswa D3
* Mahasiswa S1
* Mahasiswa S2
* Mahasiswa S3
* Dosen Pembimbing
* Konsultan Skripsi

---

# 3. Tujuan MVP

Membantu mahasiswa menyelesaikan penelitian lebih cepat tanpa mengabaikan proses akademik.

---

# 4. Tech Stack

## Backend

* Laravel 13
* PHP 8.4
* MySQL
* Redis
* Queue
* Scheduler

---

## Frontend

### Rekomendasi

✅ Blade

*

Livewire 3

*

Tailwind CSS

Alasan:

* cepat dibuat
* SEO bagus
* ringan
* tanpa SPA
* mudah maintenance

---

## Editor

* TipTap Editor

atau

* TinyMCE

Fitur:

* Heading
* Footnote
* Table
* Citation
* Export DOCX

---

## AI

* Gemini API
* OpenAI API (opsional)
* Claude API (opsional)

---

## Storage

Laravel Storage

atau

S3 Compatible

---

## Authentication

Laravel Breeze

atau

Laravel Starter Kit

---

# 5. Role

## Guest

* Landing Page
* Pricing
* Demo

---

## Member

* Dashboard
* Project Penelitian
* AI Writer
* Referensi

---

## Premium

Semua fitur AI

---

## Admin

* User
* Subscription
* Prompt
* Statistik
* Pembayaran

---

# 6. Dashboard

Widget

* Total Project
* Progress Skripsi
* AI Credits
* Referensi
* Status Bimbingan

---

# 7. Modul Project

Setiap mahasiswa dapat memiliki banyak project.

Contoh

```
Skripsi Sistem Informasi Akademik

Pembimbing:
Dr. Ahmad

Universitas:
Universitas Indonesia

Program Studi:
Teknik Informatika
```

---

# 8. Wizard Pembuatan Skripsi

Langkah-langkah:

## Step 1

Data

* Judul

* Universitas

* Fakultas

* Program Studi

* Jenjang

---

## Step 2

Jenis Penelitian

* Kuantitatif

* Kualitatif

* Mixed Method

* R&D

* Studi Literatur

* Eksperimen

---

## Step 3

Topik

AI akan memahami bidang.

Misalnya

```
Machine Learning

Pendidikan

Kesehatan

Ekonomi

Hukum

Psikologi

Pertanian
```

---

# 9. AI Topik Generator

Input

```
Minat:
AI

Lokasi:
Indonesia

Bidang:
Pendidikan
```

Output

* 20 Judul
* Kebaruan
* Tingkat Kesulitan
* Ketersediaan Referensi
* Peluang Lulus

---

# 10. AI Proposal Generator

Generate otomatis

BAB I

* Latar Belakang
* Rumusan Masalah
* Tujuan
* Manfaat
* Batasan

---

BAB II

* Kajian Teori
* Penelitian Terdahulu
* Kerangka Berpikir

---

BAB III

* Metodologi

---

# 11. AI BAB Generator

Generate

BAB 1

BAB 2

BAB 3

BAB 4

BAB 5

Per subbab.

---

# 12. AI Academic Writer

Editor AI.

Fitur:

* Rewrite
* Expand
* Shorten
* Academic Tone
* Humanize
* Formal
* Passive Voice
* Active Voice
* Translate

---

# 13. AI Paraphrase

Mode

* Ringan

* Sedang

* Tinggi

---

# 14. AI Citation

Format

* APA

* IEEE

* MLA

* Chicago

* Vancouver

---

# 15. AI Reference Finder

Cari referensi dari

* Crossref
* Semantic Scholar
* arXiv
* DOAJ
* PubMed (untuk bidang kesehatan)

Output:

* Judul
* Penulis
* Tahun
* DOI
* Sitasi otomatis

---

# 16. AI Literature Review

Input

20 PDF

Output

* Ringkasan
* Gap Penelitian
* Persamaan
* Perbedaan
* Research Gap
* Novelty

---

# 17. PDF Reader AI

Upload PDF.

AI menjawab pertanyaan berdasarkan isi PDF.

---

# 18. AI Metodologi

Membantu menentukan

* Populasi
* Sampel
* Teknik Sampling
* Variabel
* Hipotesis
* Instrumen
* Uji Validitas
* Uji Reliabilitas

---

# 19. AI Kuesioner

Generate otomatis

Likert

1–5

beserta indikator.

---

# 20. AI Statistik

Integrasi:

* SPSS
* Excel
* CSV

Upload data.

AI menghasilkan:

* Analisis Deskriptif
* Normalitas
* Regresi
* Korelasi
* ANOVA
* Interpretasi hasil

---

# 21. AI Diagram Penelitian

Generate

* Flowchart
* Framework
* ERD
* UML
* BPMN

---

# 22. AI PPT Seminar

Generate otomatis

10–20 slide.

---

# 23. AI Tanya Dosen

Simulasi dosen penguji.

Contoh:

```
Apa novelty penelitian Anda?

Mengapa menggunakan metode tersebut?

Apa kelemahan penelitian?
```

---

# 24. AI Plagiarism Checker

Integrasi API pihak ketiga (misalnya Turnitin jika tersedia melalui institusi, atau layanan lain yang memiliki API resmi).

---

# 25. AI Grammar Checker

Bahasa

* Indonesia

* Inggris

---

# 26. Export

* DOCX
* PDF
* Markdown

---

# 27. Riwayat AI

Semua prompt tersimpan.

Dapat diulang.

---

# 28. Template Kampus

Admin dapat membuat template:

* Universitas A
* Universitas B
* Universitas C

Berisi:

* margin
* font
* heading
* cover
* daftar isi
* format sitasi

---

# 29. Pembayaran

* Midtrans
* Xendit
* Stripe (global)

---

# 30. Membership

### Free

* 1 Project
* 5 AI Prompt/hari
* Export PDF
* Maksimal 5 referensi

---

### Pro

* Unlimited Project
* Unlimited AI
* AI Literature Review
* AI Statistik
* Export DOCX
* AI PPT
* AI Citation

---

### Campus

* Multi-user
* Dashboard Dosen
* Manajemen Mahasiswa
* Statistik penggunaan
* Branding kampus

---

# 31. Struktur Menu

```
Dashboard

Project

AI Judul

Proposal

BAB Generator

Editor

Referensi

Literature Review

Upload PDF

AI Statistik

AI Diagram

AI PPT

Riwayat

Profil

Subscription
```

---

# 32. Struktur Database (Ringkas)

* users
* projects
* chapters
* chapter_sections
* ai_conversations
* references
* citations
* uploaded_documents
* questionnaires
* datasets
* analysis_results
* presentations
* exports
* subscriptions
* payments
* prompt_templates
* universities
* study_programs
* activity_logs

---

# 33. Keamanan

* Laravel Policies & Gates
* CSRF Protection
* Rate Limiting
* Enkripsi file sensitif
* Audit Log
* Backup otomatis
* Two-Factor Authentication (opsional)

---

# 34. Roadmap

### MVP (2–3 bulan)

* Manajemen proyek penelitian
* AI Judul
* AI Proposal
* AI BAB Generator
* Editor AI
* Referensi
* Export DOCX/PDF
* Pembayaran

### Versi 2

* AI Literature Review
* AI Chat PDF
* AI Statistik
* AI Kuesioner
* AI Diagram
* AI PPT Seminar

### Versi 3

* Dashboard Dosen Pembimbing
* Kolaborasi real-time
* Workflow bimbingan dan revisi
* Integrasi perpustakaan digital
* Integrasi LMS kampus
* Marketplace template kampus

## Rekomendasi Arsitektur

Untuk **Laravel 13**, kombinasi **Blade + Livewire 3 + Tailwind CSS** adalah pilihan paling efisien untuk MVP karena:

* Pengembangan lebih cepat dibanding SPA.
* SEO lebih baik.
* Interaksi dinamis tanpa banyak JavaScript.
* Mudah dipelihara dan dikembangkan.
* Skalabel; modul tertentu (misalnya editor atau visualisasi statistik) dapat ditingkatkan menggunakan Vue.js atau React di kemudian hari tanpa mengubah keseluruhan arsitektur aplikasi.
