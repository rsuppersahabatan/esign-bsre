# Esign Library with API from BSRE

Library BSRe yang dikembangkan Oleh Rio Firmansyah Eka Saputra, sudah dimodifikasi oleh M Desta Fadilah, bersumber berikut: https://gitlab.com/rio80/esign-library yang digunakan selain pengguna Composer. Jika aplikasi yang dikembangkan mendukung composer bisa merujuk kehalaman berikut: https://github.com/Diskominfotik-Banda-Aceh/E-Sign-BSrE-PHP.

## Revision 1.2 (01-Maret-2019)

![Logo BSre](logo-bsre.png)

## Tujuan Esign

1. Untuk memberikan tanda tangan pada format dokumen tipe pdf secara elektronik, sehingga dokumen mempunyai tingkat keaslian atau originalitas yang bisa di pertanggung jawabkan.

## Tujuan Library Esign

1. Untuk memudahkan programmer web CodeIgniter maupun Laravel agar dapat mengimplementasikan Tanda Tangan Elektronik dengan mudah, dan lebih cepat dalam proses implementasinya.

## Setting awal library

### Merubah URL endpoint

Berikut untuk dapat merubah URL yang mengarah ke endpoint API, buka file **env.php**, lalu cari variabel $env["url"], kemudian rubah value nya, contoh merubah value :

```
$env["url"] = "https://esign-dev.bssn.go.id";
```
Menjadi
```
$env["url"] = "https://esign.bssn.go.id";
```

### Merubah Proxy Host dan Proxy Port

- Untuk dapat merubah nomor Proxy Host maupun Proxy Port, buka file **env.php**, lalu cari variabel $env["proxy"], kemudian rubah value nya, contoh value apabila memang harus melewati proxy :

```
$env["proxy"] = "10.15.3.21:80";
```

Apabila tidak ada proxy, maka cukup berikan titik dua ":" :

```
$env["proxy"] = ":";
```


## Pemasangan Library Esign

### Memasang library

1. Buat folder dengan nama '**Esign**' di libraries
2. Clone/Download file didalam git ini
3. untuk clone bisa menggunakan perintah "git clone http://10.15.34.82/rio/esign-library.git"
4. lalu extract file hasil download, lalu copy semua file didalam folder esign-library
5. lalu paste didalam folder 'Esign' yang sudah dibuat sebelumnya di libraries CI
6. Buat file dengan nama 'esign_lib.php' didalam folder libraries CI.
7. Copy paste kode dibawah ini kedalam file 'esign_lib.php'

   ```
   <?php
   if (!defined('BASEPATH')) {
       exit('No direct script access allowed');
   }

   require_once __DIR__ . '/Esign/Esign.php';
   class esign_lib extends \Esign\Esign
   {
       public function __construct()
       {
           parent::__construct();
       }
   }
   ```

8. kemudian buat function di controller CI, lalu pada bagian construct panggil library dengan perintah berikut

```
$this->load->library(array('esign_lib', 'session'));
```

9. lalu untuk pengetesannya, buat function index, lalu panggil perintah berikut :

```
echo $this->esign_lib->index();
```

## Penggunaan API Esign

### Registrasi User

A. Sebelum registrasi, pastikan kita sudah bekerja sama dengan pihak BSRE, situs BSRE resmi bisa diakses pada : https://bssn.go.id/hubungi-kami/.

B. Variabel tipe TEXT dan harus di sebutkan dan di post pada form view

- 1.  _nik_ (mandatory)
- 2.  _nama_ (mandatory)
- 3.  _nip_ (mandatory)
- 4.  _email_ (mandatory)
- 5.  _jabatan_
- 6.  _nomor_telepon_ (mandatory)
- 7.  _unit_kerja_
- 8.  _kota_ (mandatory)
- 9.  _provinsi_ (mandatory)

C. Variabel yang bertipe FILE dan harus disebutkan pada form view, (_sebaiknya dokumen yang di upload bertipe PDF_)

- 1.  _ktp_ (mandatory)
- 2.  _surat_rekomendasi_ (mandatory)
- 3.  _sk_pengangkatan_ (mandatory)
- 4.  _image_ttd_ (mandatory)

D. Lalu panggil kode berikut didalam controller untuk Registrasi User

```
echo $this->esign_lib->registrasiUser();
```

E. untuk contoh hasil response seperti berikut :

```
success :
{
    "message": "Pendaftaran berhasil"
}
```

```
error saat ada kolom yang belum di isi:
{
    "status_code": 4014,
    "error": "NIK harus diisi"
}
```

```
error saat ada data sudah pernah terdaftar:
{
    "status_code": 4024,
    "error": "NIK telah terdaftar"
}
```
```
error saat format email tidak sesuai :
{
    "status_code": 4015,
    "error": "Data tidak sesuai ketentuan : Kolom 'Email' hanya diperbolehkan mencantumkan karakter number, underscores, '@' dan '.' "
}
```

F. Setelah berhasil registrasi, maka kita wajib konfirmasi ke pihak BSRE untuk dilakukan approve data kita.

### Send Sign Request

- Untuk Nama file maupun File itu sendiri harus berformat **.pdf**

A. Variabel yang harus disebutkan dan di post pada form view

- 1.  _penandatangan_ (di isikan dengan NIK)(mandatory)
- 2.  _tujuan_
- 3.  _perihal_
- 4.  _info_
- 5.  _jenis_dokumen_
- 6.  _nomor_
- 7.  _tampilan_ (di isikan dengan **visible** dan **invisible**)
- 8.  _image_ (di isikan **true** dan **false**, bila **true** maka gambar tampil, bila **false** maka gambar tidak tampil)
- 9.  _linkQR_ (di isikan dengan alamat download dokumen)
- 10. _halaman_ (di isikan hanya **pertama** dan **terakhir**)
- 11. _yAxis_ (di isikan dengan angka dan satuan milimeter)
- 12. _xAxis_ (di isikan dengan angka dan satuan milimeter)
- 13. _width_ (di isikan dengan angka dan satuan milimeter)
- 14. _height_ (di isikan dengan angka dan satuan milimeter)

B. Variabel yang bertipe FILE dan harus disebutkan pada form view (Dokumen upload bertipe PDF)

- 1.  _file_ (mandatory)

C. Lalu panggil kode berikut didalam controller untuk send sign request

```
<!-- Untuk Contoh assign value ke variabel -->
        // $file_name = "BPJS.pdf";
        // $file_tmp = "D:\BPJS.pdf";
<!-- ====================================  -->

echo $this->esign_lib->sendSignRequest($file_name, $file_tmp);
```

D. Untuk contoh hasil response sebagai berikut :

```
Apabila sukses maka muncul sebagai berikut :
{
    "message": "Permintaan tanda tangan telah disampaikan kepada user. Silahkan untuk mengecek status tanda tangan",
    "id_signed": "10d6b831f3a34a09aab272ed940d388a"
}
```

```
error saat kolom penandatangan berisi NIP yang tidak terdaftar atau kosong :
{
    "status_code": 2011,
    "error": "Penandatangan tidak terdaftar"
}
```

E. **(Optional)** untuk service ini (send sign request), sudah dibuat tampungan data id_signed ke dalam session dengan nama 'id_signed', untuk contoh pemanggilannya dengan CI bisa dengan kode berikut ini :

```
echo $this->session->userdata('id_signed');
```

### Sign Dokumen

A. Variabel yang harus disebutkan dan di post pada form view

- 1.  _passphrase_ (di isikan dengan passphare yang dimasukan pada saat pendaftaran)(mandatory)
- 2.  _id_signed_ (didapatkan pada hasil respon send request)(mandatory)

B. Lalu panggil kode berikut didalam controller untuk Sign Dokumen

```
echo $this->esign_lib->signDokumen($id_signed);
```

C. Untuk contoh hasil response sebagai berikut :

```
apabila sukses muncul response berikut :
{
    "waktu": "111 ms",
    "message": "Proses berhasil"
}
```
```
Muncul error apabila token yang dimasukan salah :
{
    "error": "invalid_token",
    "error_description": "Invalid access token: fcfd5668-e5a3-4f3e-8bbc-1fac32338a9c"
}
```
```
Muncul error apabila passphrase yang dimasukan salah :
{
    "status_code": 2031,
    "error": "Passphrase anda salah !!!"
}
```

### Download Dokumen

A. Variabel yang harus disebutkan dan di post pada form view

- 1.  _id_signed_ (didapatkan pada hasil respon send request)(mandatory)
- 2. Lalu panggil kode berikut didalam controller untuk Download Dokumen

```
$this->esign_lib->downloadDok('Di isi id_signed', 'Nama File');
```

- 3. Untuk hasil response berupa file yang awalnya di send sign request
- 4. Jika download dilakukan 2 kali dengan id_signed yang sama maka akan muncul response seperti berikut :

```
{
    "status_code": 4044,
    "error": "File tidak tersedia, pastikan bahwa dokumen belum di download"
}
```

### Sign Dokumen & Download

A. Variabel yang harus disebutkan dan di post pada form view

- 1.  _passphrase_ (di isikan dengan passphare yang dimasukan pada saat pendaftaran)(mandatory)
- 2.  _id_signed_ (didapatkan pada hasil respon send request)(mandatory)

B. Lalu panggil kode berikut didalam controller untuk Download Dokumen

```
$this->esign_lib->signDokumenDownload('Di isi id_signed', 'Nama File');
```

C. Untuk contoh hasil response berupa file yang awalnya di send sign request


### Verify Dokumen

- 1. Panggil kode berikut didalam controller untuk Verify Dokumen

```
$name     = "tes_sudah_esign.pdf";
$fullPath = 'D:\tes_sudah_esign.pdf';

echo $this->esign_lib->verifyDokumen($name, $fullPath);
```

- 2. Untuk contoh hasil response sebagai berikut :

   - Apabila dokumen valid maka muncul :

```
{
    "SUMMARY": "DOCUMENT VALID !!!",
    "details": [
        {
            "info_signer": {
                "signer_dn" : "E=cyberlove80@gmail.com,CN=Rio Firmansyah,OU=Diskominfo,O=Balai Sertifikasi Elektronik,L=Jakarta,ST=DKI Jakarta,C=ID,2.5.4.13=17150219185233_Tanda Tangan Digital Demo",
                "cert_user_certified": true,
                "issuer_dn": "CN=OSD DEMO,O=Badan Siber dan Sandi Negara,C=ID",
                "signer_name": "Rio Firmansyah",
                "signer_cert_validity": "2018-10-17 10:07:06.00 to 2018-11-16 10:07:06.00"
            },
            "info_tsa": {
                "name": null,
                "tsa_cert_validity": "null to null"
            },
            "signature_field": "Rio Firmansyah1539748624950",
            "signature_document": {
                "signed_using_tsa": false,
                "signed_in": "2018-10-17 10:57:04.00",
                "location": "Jakarta",
                "reason": "Tanda tangan elektronik untuk menjamin keaslian dari dokumen elektronik",
                "hash_value": "e306e66ee2b6b2f8bd75c68b160e393850a58bd513558262cc8bc0dd52461b68",
                "document_integrity": true,
                "signature_value": "314b301806092a864886f70d010903310b06092a864886f70d010701302f06092a864886f70d01090431220420e306e66ee2b6b2f8bd75c68b160e393850a58bd513558262cc8bc0dd52461b68"
            }
        }
    ],
    "nama_dokumen": "new (1).pdf",
    "jumlah_signature": 1,
    "notes": "Dokumen asli dan valid, tetapi dokumen tidak menggunakan waktu TSA"
}
```

 - Apabila dokumen tidak valid atau belum ditandatangani maka muncul :

```
{
    "details": [],
    "nama_dokumen": "LIST RUBAH QUERY.pdf",
    "jumlah_signature": 0
}
```
