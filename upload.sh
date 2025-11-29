#!/bin/sh

HOST="$FTP_HOST"
USER="$FTP_USER"
PASS="$FTP_PASS"
DIR="$FTP_DIR"

echo "📤 Enviando arquivos para o servidor..."

lftp -f "
open $HOST
user $USER $PASS
mirror --reverse --delete --verbose ./ $DIR
bye
"

echo "✔ Deploy finalizado!"
