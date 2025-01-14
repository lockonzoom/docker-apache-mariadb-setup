# Dockerfile หลังแก้ไข
# ใช้ PHP 8.2 พร้อม Apache
FROM php:8.2-apache

# คัดลอก Composer จาก Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ติดตั้งแพ็คเกจเพิ่มเติม
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    ffmpeg \
    procps \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

# เปิดใช้งาน mod_rewrite
RUN a2enmod rewrite

# คัดลอกไฟล์การตั้งค่า Apache ที่กำหนดเอง
COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

# คัดลอกโฟลเดอร์ src ไปยัง DocumentRoot
COPY ./src /var/www/html

# ตั้งค่า DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html

# ตั้งค่าโฟลเดอร์ทำงาน
WORKDIR /var/www/html

# ติดตั้ง Composer dependencies
RUN composer install || (cat /var/www/html/composer.json && exit 1)

# ใช้คำสั่ง CMD เพื่อรัน Apache
CMD ["apache2-foreground"]