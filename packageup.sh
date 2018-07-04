#!/bin/sh

/bin/rm -rf package

mkdir -p package/web/modules/twdocs/common
mkdir -p package/web/modules/twdocs/js
mkdir -p package/web/modules/twdocs/css
cp -R config src twdocs.info.yml twdocs.install twdocs.libraries.yml twdocs.links.menu.yml twdocs.module twdocs.routing.yml package/web/modules/twdocs
cp common/TWDocs.inc package/web/modules/twdocs/common
cp common/js/* package/web/modules/twdocs/js
cp common/css/* package/web/modules/twdocs/css
cp -R common/media package/media

version=`git rev-parse --abbrev-ref HEAD`
(cd package
tar zcvf twdocs-${version}.tar.gz web media
)


