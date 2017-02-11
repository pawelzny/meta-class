#!/usr/bin/env bash

source="src"
destination="docs"
template="bootstrap"

# if apigen installed globally generate docs and exit gracefully
if [ apigen -v >/dev/null 2>&1 ]; then
    apigen generate -s ${source} -d ${destination} --template-theme ${template}
    exit 0
fi

# if apigen.phar does not exist download it and give executable permission
if [ ! -f apigen.phar ] ; then
    wget http://apigen.org/apigen.phar
    chmod +x apigen.phar
fi

# generate docs using apigen.phar
php apigen.phar generate -s ${source} -d ${destination} --template-theme ${template}
