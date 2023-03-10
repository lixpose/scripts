#!/usr/bin/env sh
# Usage: lixreq vim

set +e

me="vim"
echo ''
echo === Setup $me ===

if ! testcmd vim; then
	pkgreq vim
	echo set clipboard^=unnamed,unnamedplus > $HOME/.vimrc
	echo set number >> $HOME/.vimrc
	echo set relativenumber >> $HOME/.vimrc
fi

set -e

