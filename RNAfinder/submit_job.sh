#! /bin/sh
# $1 input gtf
# #2 output directory
# $3 species
# $4 ratio


rootdir=/var/www/html/RNAfinder
  cd $rootdir
 # bash $rootdir/come/bin/COME_chr.sh $rootdir/$1 $rootdir/$2 $rootdir/come/bin $3   
 bash $rootdir/come/bin/test.sh $rootdir/$1 $rootdir/$2 $rootdir/come/bin $3   
 cat $2/result
