# lxc-compose

Automate dependency installation for linux containers. Also works interactively.

## About

lxc-compose is a set of useful shell scripts to help to install dependencies in a fast passion on fresh linux containers. You can build a clean bash script for a project or even leverage it interactively from the terminal. lxc-compose are nothing more than templates and functions that let your script look cleaner. For stability, consider forking and modifying the `init` script to point to the right repository.

The helper functions are designed to be re-run without issue, i.e. packages will only be installed, if they haven't been installed already.

> This is pure bash, no need to learn new stuff here.

## How-To

```
# initialize lxc-compose:
\. /dev/stdin <<< "$(wget -qO- https://raw.githubusercontent.com/lxc-compose/scripts/master/init)"

# initialize environment:
lxcreq env/debian

# prepare additional post-install steps for php
testc php || hatch_php=1

# ensure some packages are installed:
pkgreq software-properties-common gnupg redis-server imagemagick

# ensure some package-kits are installed and configured:
lxcreq lemp 8.4 # nginx, mariaDB, php8.4
lxcreq node 18
lxcreq python3

# post-install steps php
if [ $hatch_php ]; then
	php_ini="/etc/php/$phpversion/fpm/php.ini"
	sed -ri 's/(memory_limit[	 ]*=).*$/\1 512M/' "$php_ini" || exit
	sed -ri 's/(post_max_size[	 ]*=).*$/\1 32M/' "$php_ini" || exit
	sed -ri 's/(upload_max_filesize[	 ]*=).*$/\1 32M/' "$php_ini" || exit
	sed -ri 's/(serialize_precision[	 ]*=).*$/\1 -1/' "$php_ini" || exit
fi
```

## KVM

Although lxc-compose is designed for Linux Containers, it should be compatible with KVMs as well. There are also some KVM scripts in the `kvm` sub-directory.

