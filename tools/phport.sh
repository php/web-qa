#!/bin/sh -x
# +----------------------------------------------------------------------+
# | PHP Version 4                                                        |
# +----------------------------------------------------------------------+
# | Copyright (c) 1997-2002 The PHP Group                                |
# +----------------------------------------------------------------------+
# | This source file is subject to version 2.02 of the PHP licience,     |
# | that is bundled with this package in the file LICENCE and is         |
# | avalible through the world wide web at                               |
# | http://www.php.net/license/2_02.txt.                                 |
# | If uou did not receive a copy of the PHP license and are unable to   |
# | obtain it through the world wide web, please send a note to          |
# | license@php.net so we can mail you a copy immediately                |
# +----------------------------------------------------------------------+
# | Authors:    Jan Lehnardt <jan@lehnardt.de>                           |
# +----------------------------------------------------------------------+
# 
# $Id: phport.sh,v 1.5 2002-11-10 18:57:34 nohn Exp $

#  The PHP Port project should provide the ability to build and test 
#  any PHP4+ Version with any module/webserver.



# Variable Deklaration
USE_BZ2=NO
TRY_ZE2=NO

DISTFILES=distfiles
WRKDIR=work
PHPSNAPSERVER=http://snaps.php.net/
PHPPSERVER=':pserver:cvsread@cvs.php.net:/repository'
PHPCVSPASS='A:c:E?'

# Build directory structure if not available
if ! [ -d $WRKDIR ] ; then
    mkdir $WRKDIR
    mkdir $WRKDIR/php4-cvs
    mkdir $WRKDIR/php4-snap
    mkdir $WRKDIR/php4-local
fi           

if ! [ -d $DISTFILES ] ; then
    mkdir $DISTFILES
    mkdir $DISTFILES/cvs
fi

if ! [ -d etc ] ; then
    mkdir etc
fi    

if [ $USE_BZ2 = "NO" ] ; then 
    PHPSNAPFILE=php4-latest.tar.gz
    TARMOD=z
 else
    PHPSNAPFILE=php4-latest.tar.bz2
    TARMOD=y
fi

# Detect mode (snap|cvs|local)
case $1 in 
    snap|cvs|local) 
        MODE=$1
        ;;
    *)
    echo "Invalid Mode"
    exit 1
    ;;
esac
echo $MODE    

# Clean $WRKDIR dir
rm -rf $WRKDIR/php4-$MODE/*
# Fetch/extract source to $DISTFILES/$WRKDIRdir
case $MODE in
    snap) # 24h distfile!!
        if [ $2 ] ; then
            SNAPURI=$2;
            PHPSNAPFILE=`echo $SNAPURI | sed 's/.*\///g'`
        else
            SNAPURI=$PHPSNAPSERVER/$PHPSNAPFILE
        fi    
        
        if [  'echo $PHPSNAPFILE | sed 's/http:\/\/.*//g'' -nq "" ] ; then
            cp $PHPSNAPFILE $DISTFILES
        
        fi
        
        if [ "`which fetch` " != " " ] ; then
            FETCHCMD="fetch -m -o $DISTFILES/$PHPSNAPFILE $SNAPURI"
        elif [ "`which wget` " != " " ] ; then
            FETCHCMD="wget -O $DISTFILES/$PHPSNAPFILE $SNAPURI"
        fi    
        
        if  ! [ -s $DISTFILES/$PHPSNAPFILE ] ; then 
            echo "$PHPSNAPFILE does not seem to exist in $DISTFILES, downloading..."
            $FETCHCMD
        fi
        echo "Extracting source package..."
        
        tar -C $WRKDIR/php4-$MODE -x -$TARMOD -f $DISTFILES/$PHPSNAPFILE
        mv -f $WRKDIR/php4-$MODE/php*/* $WRKDIR/php4-$MODE
        
    ;;

    cvs)
        if [ ! `grep -c cvsread@cvs.php.net ~/.cvspass` -gt 0 ] ; then
            echo $PHPPSERVER $PHPCVSPASS>> ~/.cvspass
        fi 
        cd $DISTFILES/$MODE
                cvs -d $PHPPSERVER co php4
                    cd php4
                        if [ $TRY_ZE2 = "NO" ] ; then
                            cvs -d $PHPPSERVER co Zend TSRM
                         else
                            cvs -d $PHPPSERVER co ZendEngine2 TSRM
                            mv ZendEngine2 Zend
                        fi    
                        find . | cpio -pdm ../../../$WRKDIR/php4-$MODE
                    cd ../../..
                    
    ;;
    
    local)
        if [ $2 ] ; then
            cd $2
            find . | cpio -pdm $WRKDIR/php4-$MODE
        else
            echo "No local Path supplied"    
            exit 1
        fi    
    ;;
esac    

# Get configure optioms
for option in `cat etc/configure-options` ; do
    options="$options $option"
done    
# Check dependencies of configured extensions

# Clean dependencies
  
  # Fetch/extract source into $DISTFILES/$WRKDIRdir
  
  # Build dependencies
  
  # Install dependencies (Libraries) locally
  
# Configure PHP
cd $WRKDIR
   /php4-$MODE
if [ ! -s configure ] ; then
    ./cvsclean
    ./buildconf
fi
config="./configure $options";
$config
# Build PHP
make 2>error.log
# Install PHP locally

cat error.log | mail -s "PHP Compile Report" $USER

# Running testcases against the environment
export NO_INTERACTION=1
NO_INTERACTION=1 make test | mail -s "PHP Test Report" $USER
