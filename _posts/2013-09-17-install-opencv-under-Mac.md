---
layout: post
title: 在Mac下安装openCV
modified: 2013-09-17
description: 开始试着在cpp环境下面做CV
image:
  feature: abstract-11.jpg
github: 
tags: [code, Mac, Geek]
comments: true
share: true
---
通过brew安装openCV运行库。
{% highlight bash %}
   brew install opencv
{% endhighlight %}

通过一个样例进行测试：
{% highlight bash %}
   mkdir example
   cd example
   emacs example.cpp
{% endhighlight %}

example.cpp文件：
{% highlight cpp %}
#include <cv.h>
#include <highgui.h>
using namespace cv;
int main( int argc, char* argv[] )
{
  Mat image;
  image = imread( argv[1], 1 );
 
  if( argc != 2 || !image.data )
    {
      printf( "No image data \n" );
      return -1;
    }
 
  namedWindow( "Example", CV_WINDOW_AUTOSIZE );
  imshow( "Example", image );
 
  waitKey(0);
 
  return 0;
}
{% endhighlight %}

通过cmake解决命令行下g++编译链接库的问题。
新建CMakeLists文件：
{% highlight cpp %}
   project( example )
   find_package( OpenCV REQUIRED )
   add_executable( example example )
   target_link_libraries( example ${OpenCV_LIBS} )
{% endhighlight %}

编译文件：
{% highlight bash %}
   cmake .
   make
{% endhighlight %}

运行程序：
{% highlight bash %}
   ./example example.jpg
{% endhighlight %}

