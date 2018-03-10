#!/usr/bin/env bash
service apache2 start

# workaround para manter o processo vivo
tail -f /dev/null
