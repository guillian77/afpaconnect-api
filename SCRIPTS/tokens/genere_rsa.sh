#!/bin/sh
#encoding=utf8

set -e

SCRIPT=$(readlink -f "$0")
root=$(dirname "$SCRIPT")

cd $root

apps=("afpanier" "afpaticket" "resasalles" "afpasla")

for app in "${apps[@]}"
do
  echo -e "Generate keys for $app"
  openssl genrsa -out "$app"_private.key 2048
  openssl rsa -in "$app"_private.key -outform PEM -pubout -out "$app"_public.key
done