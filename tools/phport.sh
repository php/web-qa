#!/bin/sh 
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
# | Authors:    Jan Lehnardt <jan@php.net>                               |
# |             Sebastian Nohn <nohn@php.net>                            |
# +----------------------------------------------------------------------+
# 
# $Id: phport.sh,v 1.18 2002-11-13 19:32:14 nohn Exp $

#  The PHP Port project should provide the ability to build and test 
#  any PHP4+ Version with any module/webserver.

# Variable declaration
USE_BZ2=NO
TRY_ZE2=NO

PREFIX="/tmp"
DISTFILESDIR="$PREFIX/distfiles"
WRKDIR="$PREFIX/work"
ETCDIR="$PREFIX/etc"
PHPSNAPSERVER="http://snaps.php.net/"
PHPCVSSERVER=":pserver:cvsread@cvs.php.net:/repository"
PHPCVSPASS="A:c:E?"

# functions
usage() {
    cat <<EOF
    $1 mode [argument]
    mode: 
     - snap    Builds from a Snapshot requires remote archive 
               in argument (http/ftp)
     - cvs     Builds from CVS
     - local   Builds from the local sourcetree specified in argument
EOF
}


# Build directory structure if not available
if ! [ -d "$WRKDIR" ] ; then
    mkdir "$WRKDIR"
    mkdir "$WRKDIR/php4-cvs"
    mkdir "$WRKDIR/php4-snap"
    mkdir "$WRKDIR/php4-local"
fi           

if ! [ -d "$DISTFILESDIR" ] ; then
    mkdir "$DISTFILESDIR"
    mkdir "$DISTFILESDIR/cvs"
fi

if ! [ -d etc ] ; then
    mkdir etc
fi    

if [ "$USE_BZ2" = "NO" ] ; then 
    PHPSNAPFILE="php4-latest.tar.gz"
    TARMOD=z
 else
    PHPSNAPFILE="php4-latest.tar.bz2"
    TARMOD=y
fi

# Detect mode (snap|cvs|local)
case $1 in 
    snap|cvs|local) 
        MODE=$1
        ;;
    *)
    echo "Invalid Mode"
    usage $0
    exit 1
    ;;
esac
echo $MODE    

# Clean $WRKDIR 
rm -rf "$WRKDIR/php4-$MODE/*"
# Fetch/extract source to $DISTFILESDIR/$WRKDIR
case $MODE in
    snap) # 24h distfile!!
        if [ $2 ] ; then
            SNAPURI=$2;
            PHPSNAPFILE="`echo $SNAPURI | sed 's#.*/##'`"
        else
            SNAPURI=$PHPSNAPSERVER/$PHPSNAPFILE
        fi    
        
        if [ 'echo $PHPSNAPFILE | sed 's/http:\/\/.*//g'' = "" ] ; then
            cp $PHPSNAPFILE "$DISTFILESDIR"
        
        fi
        
        if [ "`which fetch` " != " " ] ; then
            FETCHCMD="fetch -m -o \"$DISTFILESDIR/$PHPSNAPFILE\" $SNAPURI"
        elif [ "`which wget` " != " " ] ; then
            FETCHCMD="wget -O \"$DISTFILESDIR/$PHPSNAPFILE\" $SNAPURI"
        fi    
        
        if  ! [ -s "$DISTFILESDIR/$PHPSNAPFILE" ] ; then 
            echo "$PHPSNAPFILE does not seem to exist in $DISTFILESDIR, downloading..."
            $FETCHCMD
        fi
        echo "Extracting source package..."

	# see if we have gzip or bzip2

	EXT="`echo $PHPSNAPFILE | sed -e 's/.*\.//`";
	
	if [ $EXT = "gz" ] ; then
	    TARMOD=z;
	elif [ $EXT = "bz2" ] ; then
	    TARMOD=y;
	else
	    echo "Unknown package format";
	    exit 1;
	fi

        tar -C "$WRKDIR/php4-$MODE" -x -$TARMOD -f "$DISTFILESDIR/$PHPSNAPFILE"
        mv -f "$WRKDIR/php4-$MODE/php*/*" "$WRKDIR/php4-$MODE"
        
    ;;

    cvs)
        if [ ! `grep -c cvsread@cvs.php.net ~/.cvspass` -gt 0 ] ; then
            echo $PHPCVSSERVER $PHPCVSPASS>> ~/.cvspass
        fi 
        cd "$DISTFILESDIR/$MODE"
                cvs -d $PHPCVSSERVER co php4
                    cd php4
                        if [ $TRY_ZE2 = "NO" ] ; then
                            cvs -d $PHPCVSSERVER co Zend TSRM
                         else
                            cvs -d $PHPCVSSERVER co ZendEngine2 TSRM
                            mv ZendEngine2 Zend
                        fi    
                        find . | cpio -pdm "$WRKDIR/php4-$MODE"
                    cd ../../..
                    
    ;;
    
    local)
        if [ $2 ] ; then
            cd $2
            find . | cpio -pdm "$WRKDIR/php4-$MODE"
        else
            echo "No local Path supplied"    
            exit 1
        fi    
    ;;
esac    

# Get configure optioms
if ! [ -d "$ETCDIR" ] ; then
    for option in `cat $ETCDIR/configure-options` ; do
        options="$options $option"
    done    
fi
# Check dependencies of configured extensions
# Clean dependencies
# Fetch/extract source into $DISTFILESDIR/$WRKDIR
# Build dependencies
# Install dependencies (Libraries) locally
  
# Configure PHP
cd "$WRKDIR/php4-$MODE"
if [ ! -s ./configure ] ; then
    ./cvsclean
    ./buildconf
fi
config="./configure $options";
$config
# Clean
make clean
# Build PHP
make 2>error.log
# Install PHP locally

# Mail the compile-errors & warnings...
cat error.log | mail -s "PHP Compile Report" $USER

# Running testcases against the environment
NO_INTERACTION=1
export NO_INTERACTION
make test | mail -s "PHP Test Report" $USER