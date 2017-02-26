#!/usr/bin/env bash

source="src"
destination="docs/api"
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

# generate metrics for package
if [ -f vendor/bin/phpmetrics ] ; then
    ./vendor/bin/phpmetrics --report-html=docs/metrics src
fi
