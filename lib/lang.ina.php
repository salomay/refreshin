<?

/*******************************************************************************
* Filename : lang.ina.php
* Description : bahasa indonesia
*******************************************************************************/

## HTML ##
$app[lang][html]['company'] = "PT Indotank";
$app[lang][html]['title'] = "PT Indotank";
$app[lang][html]['webmin_title'] = "PT Indotank Website Administration";

## KEYWORDS ##
$app[keywords] = "";
$app[description] = "";

## BUTTON ##
$app[lang][button][back] = "<div align='center'><form><input type='button' value='Kembali' OnClick='history.back()' class='btn'></form></div>";
$app[lang][button][ok] = "<div align='center'><form><input type='button' value='Ok' OnClick='set_action(this, 'home')' class='btn'><input type='hidden' name='act'></form></div>";
$app[lang][button][agree] = "<div align='center'><form><input type='button' value='Setuju' OnClick='set_action(this, 'agree')' class='btn'><input type='hidden' name='act'></form></div>";

## PAGINATION ##
$app[lang][txt][page] = "Halaman";
$app[lang][txt][out_of] = "dari";
$app[lang][txt][all] = "Semua";


## ERROR COMPONENT ##
$app[lang][error]['header'] = "<div class='error-msg'>Error sebagai berikut :<br>";
$app[lang][error]['element'] = "<li>";
$app[lang][error]['footer'] = "</div><hr size='1'>";
$app[lang][error]['title'] = "Error...";

## ERROR TYPE ##
$app[lang][error]['empty'] = "harus diisi.";
$app[lang][error]['digit'] = "harus angka.";
$app[lang][error]['digit_exist'] = "Digit sudah ada. Isi yang lain.";
$app[lang][error]['penerbit_exist'] = "Kode penerbit sudah ada. Isi yang lain.";
$app[lang][error]['member_not_found'] = "Kode member tidak diketemukan.";
$app[lang][error]['date'] = "tanggal harus benar.";
$app[lang][error]['checkbox'] = "minimal pilih satu record.";
$app[lang][error]['select'] = "harus dipilih.";
$app[lang][error]['email'] = "alamat email salah.";
$app[lang][error]['invalid_login'] = "Username atau Password salah.";
$app[lang][error]['adm_not_login'] = "Ma'af anda belum login...<br><br>Silahkan login <a href='$app[webmin]/index.php'>disini</a>";
$app[lang][error]['adm_no_permission'] = "Ma'af anda tidak punya hak akses untuk aplikasi.{$app[lang][button][back]}";
$app[lang][error]['username_exist'] = "Username sudah ada. Isi yang lain.";
$app[lang][error]['email_exist'] = "Ma'af, email anda sudah terdaftar. silahkan mendaftar dengan email yang lain.";
$app[lang][error]['password_not_match'] = "Silahkan ketik ulang password baru anda.";
$app[lang][error]['one_application_required'] = "Anda harus memilih salah satu hak aplikasi untuk pengguna.";
$app[lang][error]['image.ERR_TYPE'] = "jenis image salah.";
$app[lang][error]['image.ERR_WIDTH'] = "tinggi x lebar salah.";
$app[lang][error]['image.ERR_SIZE'] = "ukuran salah.";
$app[lang][error]['ERR_COPY'] = "upload error.";
$app[lang][error]['file.ERR_SIZE'] = "besar file error.";
$app[lang][error]['block_error_up'] = "block currently on the highest position.";
$app[lang][error]['block_error_down'] = "block currently on the lowest position.";
$app[lang][error]['member_not_login'] = "Ma'af anda belum login...<br><br>Silahkan login <a href='$app[www]/internal/index.php'>disini</a>";
$app[lang][error]['char'] = "karakter terlalu banyak.";


## FIELD ##
$app[lang][field][name] = "nama";
$app[lang][field][nama] = "nama";
$app[lang][field][digit] = "digit";
$app[lang][field][to] = "to";
$app[lang][field][username] = "username";
$app[lang][field][password] = "password";

$app[lang][field][nama_brg] = "nama barang";
$app[lang][field][kode_brg] = "kode barang";

$app[lang][field][title] = "judul";
$app[lang][field][lead] = "lead";
$app[lang][field][content] = "konten";
$app[lang][field][content_ina] = "konten indonesia";
$app[lang][field][description] = "deskripsi";
$app[lang][field][url] = "url";

$app[lang][field][thumbnail] = "thumbnail";
$app[lang][field][picture] = "picture";
$app[lang][field]['file'] = "file";
$app[lang][field][reply] = "reply";
$app[lang][field][email] = "email";
$app[lang][field]['link'] = "link";
$app[lang][field][comment] = "comment";
$app[lang][field][subject] = "subject";

$app[lang][field][product_description] = "product description";

$app[lang][field][form] = "form";
$app[lang][field][company_id] = "ID perusahaan";
$app[lang][field][company] = "perusahaan";
$app[lang][field][company_name] = "nama perusahaan";
$app[lang][field][company_address] = "alamat perusahaan";
$app[lang][field][company_type] = "tipe perusahaan";
$app[lang][field][fax] = "fax";
$app[lang][field][address] = "alamat";
$app[lang][field][alamat] = "alamat";
$app[lang][field][city] = "kota";
$app[lang][field][kota] = "kota";
$app[lang][field][state] = "negara";
$app[lang][field][negara] = "negara";
$app[lang][field][zipcode] = "kode pos";
$app[lang][field][kode_pos] = "kode pos";
$app[lang][field][country] = "country";
$app[lang][field][phone] = "nomor telepon";
$app[lang][field][comments] = "komen";
$app[lang][field][message] = "pesan";
$app[lang][field][keterangan] = "keterangan";
$app[lang][field][features] = "fitur";
$app[lang][field][purpose] = "purpose";

$app[lang][field][question] = "pertanyaan";
$app[lang][field][answer] = "jawaban";
$app[lang][field][nama] = "nama";

$app[lang][field][product] = "produk";
$app[lang][field][category] = "kategori";

$app[lang][field][your_name] = "nama anda";
$app[lang][field][your_email] = "email anda";

$app[lang][field][friend_name] = "Your Friend Name";
$app[lang][field][friend_email] = "Your Friend Email";


## INFO ##
// $app[lang][info]['header'] = "<div class='info-msg'>";
// $app[lang][info]['footer'] = "</div><hr size='1'>";
$app[lang][info]['header'] = "";
$app[lang][info]['footer'] = "";
$app[lang][info]['adm_logout'] = "Admin telah logout.";
$app[lang][info]['member_logout'] = "Member has logout.";
$app[lang][info]['user_added'] = "User baru telah ditambahkan dalam database.";
$app[lang][info]['user_modified'] = "User telah diubah.";
$app[lang][info]['user_deleted'] = "User yang dipilih telah dihapus.";
$app[lang][info]['password_modified'] = "Password User telah diubah.";
$app[lang][info]['dollar_modified'] = "Setting untuk harga dollar telah diubah.";

$app[lang][info]['news_added'] = "Berita telah ditambahkan pada database.";
$app[lang][info]['news_modified'] = "Berita telah dirubah";
$app[lang][info]['news_deleted'] = "Berita yang dipilih telah dihapus.";

$app[lang][info]['news_cat_added'] = "Kategori Berita telah ditambahkan pada database.";
$app[lang][info]['news_cat_modified'] = "Kategori Berita telah dirubah";
$app[lang][info]['news_cat_deleted'] = "Kategori Berita yang dipilih telah dihapus.";

$app[lang][info]['page_added'] = "Halaman teks telah ditambahkan pada database.";
$app[lang][info]['page_modified'] = "Halaman teks telah dirubah";
$app[lang][info]['page_deleted'] = "Halaman teks yang dipilih telah dihapus.";

$app[lang][info]['inquiry_deleted'] = "Selected inquiry has been deleted.";
$app[lang][info]['contact_sent'] = "Terima kasih telah menghubungi kami.";
$app[lang][info]['contact_delete'] = "kontak yang dipilih telah dihapus.";

$app[lang][info]['inquiry_sent'] = "Inquiry telah dikirim.";

$app[lang][info]['block_moved'] = "Block telah dipindah.";

$app[lang][info]['page_statis_modified'] = "Page Statis has been modified.";
$app[lang][info]['content_modified'] = "Content Page has been modified.";
$app[lang][info]['product_image_modified'] = "Product Image has been modified.";

$app[lang][info]['kategori_barang_added'] = "Kategori barang telah ditambahkan pada database.";
$app[lang][info]['kategori_barang_modified'] = "Kategori barang telah dirubah";
$app[lang][info]['kategori_barang_deleted'] = "Kategori barang yang dipilih telah dihapus.";

$app[lang][info]['barang_added'] = "Barang telah ditambahkan pada database.";
$app[lang][info]['barang_modified'] = "Barang telah dirubah";
$app[lang][info]['barang_deleted'] = "Barang yang dipilih telah dihapus.";

$app[lang][info]['link_added'] = "Link telah ditambahkan pada database.";
$app[lang][info]['link_modified'] = "Link telah dirubah";
$app[lang][info]['link_deleted'] = "Link yang dipilih telah dihapus.";

?>