---
layout: post
title: "Compile Deep Matching on Ubuntu 14.04"
modified: 2014-12-02 23:20:00 +0800
tags: [IT, SCI]
image:
  feature: abstract-2.jpg
  credit: 
  creditlink: 
comments: true 
share: true
---
Today I successed in porting the Deep Matching algorithm & tools from [LEAR]:(http://lear.inrialpes.fr/people/revaud/) to Ubuntu.
The algorithm itself is a stand-of-art solution to mutipal questions concerning image matching,
comes with a easy-understanding code.
However the author did not mention the dependency request of tools he used,
and the system file structure of Fedora differs a lot from Ubuntu/Debian,
hence the compile&install takes me quite a long time.

First to first,
using `apt-get` to fix dependency.
Take a look into `Makefile`,
we have (although the default `make` method did not use this)

~~~
STATICLAPACKLDFLAGS=-static -static-libstdc++ /usr/lib64/libjpeg.a /usr/lib64/libpng.a /usr/lib64/libz.a /usr/lib64/libblas.a /usr/lib/gcc/x86_64-redhat-linux/4.7.2/libgfortran.a  # statically linked version
~~~

Which briefly declares the dependecy.
In the following codes I'm omitting `sudo`,
however most steps corcerning system-libary installation should be executed as root.

~~~ bash
apt-get install libjepg-dev
apt-get install libpng-dev
apt-get install libatlas-base-dev libatlas-dev
~~~

The following commands should add the corresponding `.h` file to gcc include search path.
However it's just the beginning:
Ubuntu itself includes `libjpeg`, `libpng` and some other tools the program uses in its kernel include path,
hence a fix is taken to link such libaries to `/usr/lib/`

~~~ bash
ln -s /usr/lib/x86_64-linux-gnu/libjpeg.a /usr/lib
ln -s /usr/lib/x86_64-linux-gnu/libjpeg.so /usr/lib
ln -s /usr/lib/x86_64-linux-gnu/libpng.a /usr/lib
ln -s /usr/lib/x86_64-linux-gnu/libpng.so /usr/lib
ln -s /usr/lib/x86_64-linux-gnu/libz.a /usr/lib
ln -s /usr/lib/x86_64-linux-gnu/libpng.so /usr/lib
~~~

Now we've dealt with `libjpeg`, `libpng` and `libz`.
The part of `atlas` is a little unusal since the program uses machine-optimized version.
We have to manually install `atlas`.
Notice the following name of folder maynot be the same as others since the version of `atlas` at the time I try is 3.10.1.

~~~ bash
sudo apt-get source atlas
cd atlas-3.10.1
sudo fakeroot debian/rules custom
cd ..
sudo dpkg -i libatlas3-base_3.10.1-4+custom1_amd64.deb
sudo dpkg -i libatlas3gf-base_3.10.1-4+custom1_all.deb
~~~

Now return to `Makefile`,
we have some last modify here.
The dynamic link may work now,
only to change `libptf77blas.so` to `libptfblas.so` if you don't have `libptf77blas.so` under `/usr/lib`.

However when I tried on another computer,
such method fails in loading `jpeglib.h`.
A more steady way can be used by calling the static link method:

In `STATICLAPACKLDFLAGS`, Change all `usr/lib64/` to `usr/lib/`,
and change `x86_64-redhat-linux` in the last argument to something like `/x86_64-linux-gnu` which is the folder name occurs in `/usr/lib`.
Finally change `all: deepmatching` to `all: deepmatching-static`.

Now calling the static-link method by `make`.
Happy deep-matching.
