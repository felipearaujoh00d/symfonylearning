#!/usr/bin/env bash

#
#   ---> Cria o certificado utilizado para o jwt bundle, caso não exista
#        Deve ser executado quando o container for instanciado
#
cd /opt/plataforma/learningsymfony

# TODO: a senha 12345 não deve ser hardcoded
if [ ! -f app/var/jwt/private.pem ]; then
    mkdir -p app/var/jwt
    openssl genrsa -passout pass:12345 -out app/var/jwt/private.pem -aes256 4096
    openssl rsa -pubout -passin pass:12345 -in app/var/jwt/private.pem -out app/var/jwt/public.pem
fi
