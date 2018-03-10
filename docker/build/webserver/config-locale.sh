#!/usr/bin/env bash

locale-gen en_US.UTF-8
locale-gen pt_BR.UTF-8

#export DEBIAN_FRONTEND=noninteractive DEBCONF_NONINTERACTIVE_SEEN=true && apt-get install -y tzdata
#dpkg-reconfigure --frontend noninteractive tzdata
cp -p /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime
echo "America/Sao_Paulo" | tee /etc/timezone

echo -e "en_US.UTF-8 UTF-8\npt_BR ISO-8859-1\npt_BR.UTF-8 UTF-8" | tee /var/lib/locales/supported.d/local
dpkg-reconfigure locales
