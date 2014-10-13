---
layout: post
title: "Lab-day Record 1"
modified: 2014-10-11 23:24:20 +0800
tags: [CV, SJTU]
image:
  feature: abstract-2.jpg
  credit: 
  creditlink: 
comments: 
share: 
---

I am starting fresh on the project of stereo matching on flow.
This is a hard work since Bai did not study in this area, and few resource can be found in our lab.
I've come through some papers, but the key problem in this point is the program, so that I can test the algorithm and put the study in practice.

After failing to search the code for the #1 [KITTI](http://www.cvlibs.net/datasets/kitti/eval_stereo_flow.php?benchmark=flow) paper [View-Consistent 3D Scene Flow Estimation over Multiple Frames.](http://scholar.google.de/scholar?q=View-Consistent%203D%20Scene%20Flow%20Estimation%20over%20Multiple%20Frames), It's been a while I'm caught in trouble. 
Hopefully on Friday Oct 10, I ran into some dataset [MPI](http://sintel.is.tue.mpg.de), and eventually found a well-organized resourse, provided by [LEAR](http://lear.inrialpes.fr/src/deepmatching/). It's amazing that the thing comes to you right when you've got nothing to turn to, and the dataset itself, is beautiful and gorgerous, making it outstanding and attractive other than any data I'm come to before.

And that's how things are going: I'm starting from scratch from the [code](http://lear.inrialpes.fr/people/revaud/data/deepmatching_1.0.1.zip).
The matching algorithm they give is an implementation of deep learning, rather similar to what I've talked in the meeting, but stands on a higher level of image matching. A good thing is their code is well organized, so I can build things upon them.

However the compiling stage is not that organized as common project standard asks.
It's been a while to set things right on a new machine, and it makes sense to have a record of the set-up stage.

I've planned to use the tool under my Mac, but it anoys me that the code uses many headers like `malloc.h`, that is included by `stdlib` in later c enviroment, but is not valid under Mac System.
So I turned to Ubuntu 14.04 operating as a virtual machine on Vmware Fusion 7.

The 'README.txt' in the project does not tell the dependence, only mentioned that the code is compiled right under Fedora.
However default Fedora may not serve all the dependence as well. 
To set up the code, there are some libaries to install.
Notice what I've done may not perform right on some other machine,
depending on the system and hardware.

The compiling enviroment is
{% highlight bash %}
   sudo apt-get install gcc-4.8
{% endhighlight %}

The media processing needs boost
{% highlight bash %}
   sudo apt-get install boost-all-dev
{% endhighlight %}
The version is 1.5.4

The image file processing needs `jpeg.h` and `png.h`, which is in 
{% highlight bash %}
   sudo apt-get install libjpeg-dev lib-png12-dev
{% endhighlight %}

The linear algorithm needs `atlas` and `blapack`, which is in 
{% highlight bash %}
   sudo apt-get install libatlas-base-dev liblapack-dev
{% endhighlight %}

By now I can't fix the compiling problem for this project; Leave it as undone and maybe somebody can help me with it.