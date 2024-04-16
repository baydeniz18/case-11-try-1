


<p>Eğer bilgisayarınızda PHP ve Composer yüklü değilse , lütfen yükleyin</p>

<b>composer global require laravel/installer</b>
<br>
<p>Bu komutla laravel'i global olarak yükleyeceksiniz.</p>

<p>Daha sonrasında bilgisayarınızda XAMPP kurulu olmalı, xamppı kurduktan sonra default ayarlarıyla</p>
<p>Apache Server ve MySQL başlatmanız gerekli.</p>
<br>
<img src="documentation/xampp.png" alt="xampp.png">

<br>

<p>Başlattıktan sonra .env dosyanızda SQL connection'ı doğru yazdığınızdan emin olun.</p>

<img src="documentation/laravelenv.png" alt="laravel.png">

<b>Terminalde sırasıyla çalıştırmanız gereken komutlar ;</b>

<li>
    php artisan migrate
    <br>
    <small>Eğer Database localhostta bulunmuyorsa, size oluşturması için soracak, yes yazıp komutu çalıştırın.</small>
</li>
<li>
    php artisan db:seed
    <br>
    <small>Gerekli kategori ve tag verilerini ekleyecektir.</small>
</li>
<li>
    php artisan l5-swagger:generate
    <br>
    <small>Swagger Api Dökümasyonu oluşturacaktır.</small>
</li>
<li>
    php artisan serve
    <br>
    <small>son olarak bu komutla artık servisleriniz çalışır hale gelecek.</small>
</li>
<li>
    http://localhost:8000/api/documentation
    <br>
    bu adrese giderek de , dökümana ulaşabilirsiniz.
</li>

