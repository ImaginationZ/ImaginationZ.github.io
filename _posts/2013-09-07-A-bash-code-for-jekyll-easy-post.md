---
layout: post
title: A bash code for jekyll easy post
modified: 2013-09-07
image:
  feature: abstract-4.jpg
github: 
tags: [code, web, Geek]
comments: true
share: true
---
想必会去用jekyll的大都是unix shell下面的工作者了，我自己不会ruby，用rake命令不方便，写一个bash的命令来格式化生成新日志——当然，脚本很简陋，也是为了凑posts数量、做测试而已。

Most jekyll user work under unix-like shell. Since I'm not familiar with ruby, 'rake' seems hard for me, I wrote a simple bash script to creat new posts. Anyway, it's quite simple, so take it as a website test! :) 

{% highlight bash %}
#!/bin/bash

today()  
{  
    date +%Y-%m-%d  
}  

echo 'Post title: '
read NAME
number=$((RANDOM%11+1))
echo '---
layout: post
title: '"$NAME"'
modified: '"$(today)"'
description: 
image:
  feature: abstract-'"$number"'.jpg
github: 
tags: [words]
comments: true
share: true
---
' > "_posts/$(today)-${NAME// /-}.md"
emacs "_posts/$(today)-${NAME// /-}.md"
{% endhighlight %}
