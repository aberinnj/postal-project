
<VirtualHost *:80>
    ServerName foobah.com
    DocumentRoot public folder here
    <Directory  public folder>
        Options +Indexes +Includes +FollowSymLinks +MultiViews
        AllowOverride All
        Require local
    </Directory>
</VirtualHost>
