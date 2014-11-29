---
layout: post
title: "Reinstall Ubuntu: Disk by UUID not detected (initramfs), boot failure"
modified: 2014-11-28 01:28:16 +0800
tags: [IT]
image:
  feature: abstract-4.jpg
  credit: 
  creditlink: 
comments: true 
share: true
---

Today I'm installing Ubuntu on my lab's server,
a Dell R410 U2 server with 6-core Xeon Cpu and a complex RAID of disks,
which might be the key feature causing system boot failure described below.

After installing the system file along with the bootloader (grub2),
the computer reboots, loads the grub2, and then try to boot the linux kernel located in `\boot`.
However after a short waiting,
the bootloader cannot boot up the kernel file and outputs

~~~ bash
ALERT! /dev/disk/by-uuid/xxxxxxxxx does not exist. Dropping to a shell
~~~


After figuring out it's not due to missmatch of disk name or UUID (using 'blkid' to check for disks, and as is set by the new installed system, this configuration should not likely be wrong),
I start realizing the thing might be on the configuration `rootdelay`,
which determines time to wait for response of the root file,
and is not explicitly writen in the default conf-file (which is shown after typing 'e' in grub2).

So that's the thing:
my server machine comes with hardware costing much more time to load than some average PC,
and hence is default waiting time for `root/` is not enough.
To handle it,
simply add something like `rootdelay=120` in the command `linux`,
normally after the word `quiet`,
when `120` is some long-enough time in seconds.

The system now successfully boot into desktop.
While `120` is a great number for PC starting time,
it does not mean grub2 really waits for precisely 2 minutes.
it takes only 43 seconds to launch into desktop after firing up boot.
