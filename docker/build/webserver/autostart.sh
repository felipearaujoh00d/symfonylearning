#!/usr/bin/env bash

#
#  --> rodar composer install
#

export PATH=$PATH:/opt/env-config

#
# ---> script para criar as chaves JWT
#
#/opt/env-config/criar-chaves-jwt.sh


#
# ---> mantém o servidor apache rodando
#
/usr/bin/supervisord -c /opt/env-config/supervisord.conf
