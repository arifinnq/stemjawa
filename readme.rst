###################
Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani
###################

Selain Bahasa Indonesia yang ada dan dipelajari masyarakat Indonesia, bahasa yang jelas digunakan dan harus terus dilestarikan adalah bahasa daerah, salah satunya adalah Bahasa Jawa. Morfologi bahasa jawa (Ngoko, Krama, Madya) berbeda dengan bahasa Indonesia memiliki keunikan dan kesulitan tersendiri dalam proses stemming-nya. Algoritma stemming bahasa Jawa dikembangkan dengan mengadaptasi algoritma Nazief & Adriani dan dibuat berdasarkan aturan morfologi bahasa Jawa. Algoritma akan menghilangkan ater-ater (awalan), seselan (sisipan), penambang (akhiran) dan bebarengan (imbuhan gabungan) serta tembung rangkep (kata ulang), dan pada setiap hasil proses akan dibandingkan dengan kamus. Dalam penelitian ini disiapkan data kamus dan dokumen uji sebanyak 10 dokumen dalam bahasa Jawa. Dari jumlah kata hasil stemming (13 011 kata), kata-kata yang didapat dan sesuai dengan harapan berjumlah 12 323 kata dan sisanya 687 adalah kata-kata hasil yang tidak sesuai dengan harapan. Dari data ini dapat dihitung bahwa akurasi stemming hasil kata yang diharapkan adalah sebesar: (12 323/13 011) x 100% = 94.72%. Pada proses Tokenizing, dari 10 dokumen uji didapat 12 112 kata. Dari jumlah kata tersebut setelah di-stem hasilnya adalah 11 466 kata. Dalam pengujian terhadap semua kata bahasa Jawa (11 466 kata), algoritma stemming yang dirancang menghasilkan akurasi sebesar 94.67%. Algoritma yang dirancang sebagian besar memberikan hasil yang cukup baik, meskipun masih dapat terjadi beberapa kata tidak menghasilkan kata seperti yang diharapkan. 

***************
Demo
***************
- http://wazifa.web.id/stemjawa


***************
Autor
***************

-  Mohammad Arifin Nurul Qhomar - STMIK Nusa Mandiri Jakarta
