#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

for i in `ls $SCRIPT_DIR/../tests/Doubles/gpio` ; do
  if [ -d "$SCRIPT_DIR/../tests/Doubles/gpio/$i" ]; then
    rm $SCRIPT_DIR/../tests/Doubles/gpio/$i/*
  fi
done;