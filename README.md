# Introduction
A PHP demo for student queue during convocation using qr code.

# Demo
- Go to https://convo.olumis.com
- Login using laptop/pc with webcam
  - Email: admin@gmail.com
  - Password: admin
- Download student qr code at https://convo.olumis.com/qr-code using your smartphone
- Navigate to the Admin Area --> Attendance and allow permission for the browser to use your webcam 
- Scan qr code from your smartphone

# Requirement
- PHP7.2+
- MySQL/MariaDB
- Nginx/Apache
- ZeroMQ http://zeromq.org/
  - Windows dll: https://windows.php.net/downloads/pecl/releases/zmq/

# Dependencies
- Ratchet https://github.com/ratchetphp/Ratchet
- Instascan https://github.com/schmich/instascan
- SimpleQrCode https://github.com/SimpleSoftwareIO/simple-qrcode
- Enable local HTTPS https://medium.freecodecamp.org/how-to-get-https-working-on-your-local-development-environment-in-5-minutes-7af615770eec
- Create virtual host called convo.sys
  - refer to [nginx.conf.sample] (https://github.com/olumis/qr-code-convo-queue-system/blob/master/nginx.conf.sample) for example of configuration

# Installation
- Clone this repository
- Refer sql folder and config.php for database import/configuration
- Install composer and run install/update for composer.json
- Open terminal and run: php -f bin/pusher.php
- Profit!

