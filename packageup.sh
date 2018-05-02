#!/bin/sh

if [ -d package ]
then
  /bin/rm -rf package
fi

mkdir -p package/twdocs/common
cp -R config src twdocs.info.yml twdocs.install twdocs.links.menu.yml twdocs.module twdocs.routing.yml package/twdocs
cp common/TWDocs.inc package/twdocs/common

version=`git rev-parse --abbrev-ref HEAD`
(cd package
tar zcvf twdocs-${version}.tar.gz twdocs
)


