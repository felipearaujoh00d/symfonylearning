#!/usr/bin/env bash

# TODO: tornar o IP e o hostname parametrizaveis

openssl req -newkey rsa:2048 -x509 -nodes \
        -keyout /etc/ssl/private/plataforma.key \
        -new -out /etc/ssl/certs/plataforma.crt \
        -subj /CN=*.learningsymfony.dev -reqexts SAN \
        -extensions SAN \
        -config <(cat /etc/ssl/openssl.cnf <(printf '[SAN]\nsubjectAltName=DNS:*.learningsymfony.dev,IP:10.0.1.10')) \
        -sha256 -days 3650

#openssl req -newkey rsa:2048 -x509 -nodes \
#        -keyout /etc/ssl/private/frontend.key \
#        -new -out /etc/ssl/certs/frontend.crt \
#        -subj /CN=*.evolutto.dev -reqexts SAN \
#        -extensions SAN \
#        -config <(cat /etc/ssl/openssl.cnf <(printf '[SAN]\nsubjectAltName=DNS:*.learningsymfony.dev,IP:10.0.1.10')) \
#        -sha256 -days 3650

