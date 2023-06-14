# lixpose (Linux Compose)

Automate dependency installation for linux environments. Works for containers, VMs and bare metal. Use in scripts or interactively.

## About

lixpose is a set of useful shell scripts to help to install dependencies in a fast passion on linux environments. Originally designed for fresh LXC instances you can build a clean shell script for a project or even leverage it interactively from the terminal. lixpose is nothing more than a set of templates and functions that let your setup script look cleaner and it can even be used to setup entire workstations. For stability, consider forking and modifying the `init` script to point to the right repository.

The helper functions are designed to be re-run without issue, i.e. packages will only be installed, if they haven't been installed already.

> This is pure shell scripting no need to learn new stuff here.

## How-To

```
# initialize lixpose:
\. /dev/stdin << EOF
	$(wget -qO- lix.me.uk)
EOF

# initialize environment:
lixreq env/debian

# prepare additional post-install steps for php
testcmd php || hatch_php=1

# ensure some packages are installed:
pkgreq software-properties-common gnupg redis-server imagemagick

# ensure some package-kits are installed and configured:
lixreq pack/lemp 8.4 # nginx, mariaDB, php8.4
lixreq pack/node 18
lixreq pack/python3

# post-install steps php
if [ $hatch_php ]; then
	php_ini="/etc/php/$phpversion/fpm/php.ini"
	sed -ri 's/(memory_limit[	 ]*=).*$/\1 512M/' "$php_ini"
	sed -ri 's/(post_max_size[	 ]*=).*$/\1 32M/' "$php_ini"
	sed -ri 's/(upload_max_filesize[	 ]*=).*$/\1 32M/' "$php_ini"
	sed -ri 's/(serialize_precision[	 ]*=).*$/\1 -1/' "$php_ini"
fi
```

> Note: If you are on Alpine, please `apk add ssl_client`, first.

## KVM

Although lixpose was designed for Linux Containers in mind, it is compatible with KVMs as well. There are some KVM scripts in the `pack/kvm` sub-directory.

## WL

For workstations there is a `pack/wl` directory that offers scripts to setup wayland compositors and compatible GUI software. If there are no options, the directory also features X software that is compatible with `xwayland` in the `pack/wl/x` sub directory.

