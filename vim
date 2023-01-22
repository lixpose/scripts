#!/usr/bin/env sh
# Usage: lxcreq vim

set +e

me="vim"
echo ''
echo === Setup $me ===

if ! testc vim; then
	pkgreq vim
	echo -e "set clipboard^=unnamed,unnamedplus\nset number\nset relativenumber" > $HOME/.vimrc
fi

set -e

