#!/usr/bin/env sh
# Usage: lixreq php <phpversion: {N.N}>

set +e

me="php"
echo ''
echo === Setup $me ===
phpversion=$1

test -n "$phpversion" || { echo "$me: Parameter 1 is missing: phpversion" >&2; exit 1; } 

if ! testc php; then
	pkgreq wget
	pkgreq zip
	pkgreq unzip
	pkgmysql="mysql"
	if [ "$ENV_DIST_NAME" = "alpine" ]; then
		phpversion="$(echo $phpversion | sed 's/\.//g')"
		pkgmysql="mysqli"
	elif [ "$ENV_DIST_NAME" = "debian" ]; then
		req lsb-release
		wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
		echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php$phpversion.list
		apt-get update
	fi
	pkgreq \
		php$phpversion \
		php$phpversion-common \
		php$phpversion-cli \
		php$phpversion-curl \
		php$phpversion-gd \
		php$phpversion-gmp \
		php$phpversion-imap \
		php$phpversion-intl \
		php$phpversion-mbstring \
		php$phpversion-$pkgmysql \
		php$phpversion-soap \
		php$phpversion-sqlite3 \
		php$phpversion-xml \
		php$phpversion-zip
	if [ "$ENV_DIST_NAME" = "alpine" ]; then
		echo '# php' >> $ENV_SHELL_RC
		echo "alias php=php$phpversion" >> $ENV_SHELL_RC
		sourcerc
	fi
fi

set -e

