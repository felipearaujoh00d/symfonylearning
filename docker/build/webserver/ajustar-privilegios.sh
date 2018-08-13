#Fix permissions and umask
setfacl -R -m u:www-data:rX /opt/plataforma/consultoria/var/cache/
setfacl -R -m u:www-data:rwX /opt/plataforma/consultoria/var/cache/ /opt/plataforma/consultoria/var/logs/
setfacl -dR -m u:www-data:rwX /opt/plataforma/consultoria/var/cache/ /opt/plataforma/consultoria/var/logs/
umask 0007