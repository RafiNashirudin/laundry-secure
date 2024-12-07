Berikut langkah-langkah untuk mengamankan file `.sql` di CentOS 9 dengan server web **Apache (httpd)**:

#### **Tambahkan Aturan di Konfigurasi Apache**
Edit file konfigurasi virtual host atau file utama di `/etc/httpd/conf/httpd.conf`:
```apache
<Directory /var/www/html>
    <FilesMatch "\.sql$">
        Require all denied
    </FilesMatch>
</Directory>
```

- Setelah perubahan, restart Apache:
    ```bash
    systemctl restart httpd
    ```

### **Kesimpulan**
Langkah-langkah di atas memastikan:
1. File `.sql` tidak dapat diakses oleh pengguna web.
2. Konfigurasi server membatasi akses file sensitif.
3. Data dilindungi melalui izin file, SELinux, dan firewall.

Dengan mengamankan file `.sql` dan meningkatkan konfigurasi server, Anda dapat meminimalkan risiko kebocoran data pada server berbasis CentOS 9.
