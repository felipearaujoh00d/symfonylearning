#!/usr/bin/env bash

# Exiba todos os erros
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/apache2/php.ini
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/cli/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/cli/php.ini

# Aumenta a quantidade limite de memória
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.1/apache2/php.ini
sed -i "s/memory_limit = .*/memory_limit = -1/" /etc/php/7.1/cli/php.ini

# Aumenta o tempo máximo de execução de cada script
sed -i "s/max_execution_time = .*/max_execution_time = 120/" /etc/php/7.1/apache2/php.ini
sed -i "s/max_execution_time = .*/max_execution_time = 120/" /etc/php/7.1/cli/php.ini

# Não expoe a versão do PHP no header da response.
sed -i "s/expose_php = .*/expose_php = Off/" /etc/php/7.1/apache2/php.ini
sed -i "s/expose_php = .*/expose_php = Off/" /etc/php/7.1/cli/php.ini

# tempo que o servidor guarda os dados da sessão antes de enviar para o Garbage Collection
sed -i "s/session.cookie_lifetime = .*/session.cookie_lifetime = 172800/" /etc/php/7.1/apache2/php.ini # 2 dias em segundos
sed -i "s/session.cookie_lifetime = .*/session.cookie_lifetime = 172800/" /etc/php/7.1/cli/php.ini # 2 dias em segundos

# tempo de expiração do cookie PHPSSESIONID
sed -i "s/gc_maxlifetime = .*/gc_maxlifetime = 172800/" /etc/php/7.1/apache2/php.ini # 2 dias em segundos
sed -i "s/gc_maxlifetime = .*/gc_maxlifetime = 172800/" /etc/php/7.1/cli/php.ini # 2 dias em segundos

# TIMEZONE == O -r a baixo é pro sed aceitar ?: http://stackoverflow.com/questions/6156259/sed-expression-dont-allow-optional-grouped-string
sed -r -i "s/date.timezone =.*/date.timezone = America\/Sao_Paulo/" /etc/php/7.1/apache2/php.ini
sed -r -i "s/date.timezone =.*/date.timezone = America\/Sao_Paulo/" /etc/php/7.1/cli/php.ini

# Habilita short open tags (<? ?>)
sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php/7.1/apache2/php.ini
sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php/7.1/cli/php.ini

# Aumenta o tamanho máximo dos uploads para 100MB
sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php/7.1/apache2/php.ini # 2 dias em segundos
sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php/7.1/cli/php.ini # 2 dias em segundos
sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php/7.1/apache2/php.ini # 2 dias em segundos
sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php/7.1/cli/php.ini # 2 dias em segundos


# Opcache - configs recomendadas pelo manual do PHP: http://php.net/manual/en/opcache.installation.php
cat << EOF | tee -a /etc/php/7.1/mods-available/opcache.ini
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_cli=0
opcache.enable=0
EOF

# Desabilita xdebug no PHP Cli (melhora velocidade composer/cache:clear)
phpdismod -v 7.1 -s cli xdebug
