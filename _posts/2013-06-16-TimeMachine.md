---
layout: post
title: 自建Mac系统的TimeMachine时光机器备份服务器
modified: 2013-06-16
description: "通过Ubuntu server下的netatalk和avahi服务，搭建afp服务器并使mac系统能将网络磁盘作为timemachine备份盘，实现和时光胶囊相同的效果"
tags: [code, Mac, Geek]
image:
  feature: abstract-10.jpg
comments: true
share: true  
---
Mac的Timemachine是一个很有特色的增量式备份系统。我一直认为这种安全性质的软件实现的方式应当是静默的、后台的，所以
Timemachine有一个好搭档就是TimeCapsule，时光胶囊，苹果自家的无线路由器+网络存储，通过bonjour协议实现了Mac系统的自动访问、
自动挂载和自动备份。

当然TimeCapsule这货2K+的售价，加上我买rmbp时ac协议的新款还没出，旧款n协议并且经常会发热死机的路由实在是找不到任何可以购
买的理由（当然很多果粉是买这个两三千的东西回去纯当路由器使的，很多人还装着windows系统）。Timemachine同样可以备份在移动硬
盘上，同时通过一些设置可以备份在smb协议网络空间的磁盘镜像上，但是这两种方式都有的弊端是无法做到静默操作，你总得去点点这
儿点点那儿才能开始备份，这完全违背了这种增量式备份体系的初衷。因此，实现TimeCapsule的用户体验是本文的重点。

通过linux下的开源afp协议实现timecapsule，至少需要：

+ 路由
+ 一台服务器主机，或是主机上的虚拟机，搭载了linux系统
+ 服务器和待备份的mac电脑接入同一内网，并确保548端口可用

我使用的服务器端平台是ubuntu server 10.04，以下是详细过程：

安装必备的服务：
    {% highlight bash %}sudo apt-get install netatalk{% endhighlight %}
netatalk是linux下afp的开源实现，用来建立网络共享

    {% highlight bash %}sudo apt-get install avahi-daemon{% endhighlight %}
avahi是bonjour的开源实现，通过这个服务mac会自动检测到内网上的文件服务器

修改配置文件：
    {% highlight bash %}sudo emacs /etc/avahi/services/afpd.service{% endhighlight %}
我使用的editor是emacs，当然你可以使用nano，vi等等。这个文件默认是不存在的

在文件中加入下列命令：
{% highlight html %}
<?xml version="1.0" standalone='no'?><!--*-nxml-*-->
<!DOCTYPE service-group SYSTEM "avahi-service.dtd">
<service-group>
    <name replace-wildcards="yes">%h</name>
    <service>
        <type>_afpovertcp._tcp</type>
        <port>548</port>
    </service>
    <service>
        <type>_device-info._tcp</type>
        <port>0</port>
        <txt-record>model=TimeCapsule</txt-record>
    </service>
</service-group>
{% endhighlight %}
保存退出。
这一步是让afp服务器被识别为TimeCapsule。当然你也可以把这一句话换成其他文本，比如ipad试试。

设置：
    {% highlight bash %}sudo emacs /etc/default/netatalk{% endhighlight %}
这个文件本来应该长这样：
{% highlight bash %}
#### Set which legacy daemons to run.
#### If you need AppleTalk, run atalkd.
#### papd, timelord and a2boot are dependent upon atalkd.
ATALKD_RUN=no
PAPD_RUN=no
TIMELORD_RUN=no
A2BOOT_RUN=no
{% endhighlight %}
把它改成这样：
{% highlight bash %}
#### Set which legacy daemons to run.
#### If you need AppleTalk, run atalkd.
#### papd, timelord and a2boot are dependent upon atalkd.
ATALKD_RUN=no
PAPD_RUN=no
CNID_METAD_RUN=yes
AFPD_RUN=yes
TIMELORD_RUN=no
A2BOOT_RUN=no
{% endhighlight %}
这是为了mac能自动发现网络备份

最后编辑：
    {% highlight bash %}sudo emacs /etc/netatalk/AppleVolumes.default{% endhighlight %}
文件原来长这样：
{% highlight bash %}
# The line below sets some DEFAULT, starting with Netatalk 2.1.
:DEFAULT: options:upriv,usedots

# By default all users have access to their home directories.
~/                      "Home Directory"

# End of File
{% endhighlight %}
第二段就是挂载命令，我们可以改成
{% highlight bash %}/TimeCapsule                       "Time Capsule"   option:tm{% endhighlight %}
保存退出。

Ok，现在回到mac，应该可以自动搜索到备份服务器了，输入你linux的用户密码就能自动备份了。
