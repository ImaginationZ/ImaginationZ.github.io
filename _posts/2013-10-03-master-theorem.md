---
layout: post
title: A Proof for Master Theorem 主定理证明
modified: 2013-10-03
description: 主定理(The Master Theorem)提供了用渐进符号表示许多由分治法得到的递推关系式的方法，因而在算法分析中广泛地使用。
image:
  feature: abstract-4.jpg
github: 
tags: [CS, Mathematics]
comments: true
share: true
---

###The Master Theorem:

Let $$T(n)$$ be a function defined on nonegative integers and taking positive value, if it satisfies
$$
		T(n) = a T (\frac{n}{b}) + f(n)
$$
for $$a \geq 1,b \geq 1$$, then

1. If $$f(n) = \Theta( n^c )$$ where $$c < log_b a$$, then $$T(n) = \Theta( n^{log_b a} )$$.
2. If $$f(n) = \Theta( n^c log^k n )$$ where $$c = log_b a$$, then $$T(n) = \Theta( n^c log^{k+1}n )$$.
3. If $$f(n) = \Theta( n^c )$$ where $$c > log_b a$$, then $$T(n) = \Theta( f(n) )$$.

**主定理(The Master Theorem)**提供了用渐进符号表示许多由分治法得到的递推关系式的方法，因而在算法分析中广泛地使用。

###Proof:

Let's first set $$f(n) = \Theta(n^c)$$ a weaker problem and think about the recursion tree for this recurrence. There will be $$log_b n$$ levels. At each level, the number of subproblems will be multiplied by $$a$$, and so the number of subproblems at level $$i$$ will be $$a^i$$. Each subproblem at level $$i$$ is a problem of size $$(\frac{n}{b^i})$$, which needs another $$\Theta((\frac{n}{b^i})^c)$$ work. So the total number of units of work on level $$i$$ is 
$$
		\Theta(a^i (\frac{n}{b^i})^c ) = \Theta( n^c (\frac{a}{b^c})^i )
$$

In general, we have the total work done is 
$$
		\sum_{i=0}^{log_b n} \Theta( n^c (\frac{a}{b^c})^i ) = \Theta( n^c \sum _{i=0}^{log_b n} (\frac{a}{b^c})^i )
$$

---

In **Case 1**, we see $$\frac{a}{b^c} > 1$$, so we have
$$
		\sum _{i=0}^{log_b n} (\frac{a}{b^c})^i = \Theta( (\frac{a}{b^c})^{log_b n} )
$$
when

$$
\begin{align}
	n^c (\frac{a}{b^c})^{log_b n} & = a^{log_b n} \\ 
							      & = n^{log_b a}
\end{align}
$$

So **Case 1** holds.

---

In **Case 3**, we have $$\frac{a}{b^c} < 1$$, then $$\sum _{i=0}^{log_b n} (\frac{a}{b^c})^i$$
converge to some constance. So we have 

$$
\begin{align}
		\sum_{i=0}^{log_b n} \Theta( n^c (\frac{a}{b^c})^i ) & = \Theta(n^c) \\
						  	 		 	 				   	 & = \Theta(f(n))
\end{align}
$$

So **Case 3** holds.

---

Finally let's take a look at a little more strict **Case 2**. Just take $$\frac{a}{b^c} = 1$$ and change the work done on level $$i$$ to 

$$
	 \Theta(a^i (\frac{n}{b^i})^c log^k\frac{n}{b^i} ) = \Theta( n^c log^k\frac{n}{b^i} )
$$

Then in general the total work needs done is 

$$
\begin{align}
		\sum_{i=0}^{log_b n} \Theta( n^c log^k\frac{n}{b^i} ) & = \Theta( n^c log_b n log^k n ) \\
						  			 	 					  & = \Theta (n^c log^{k+1} n)	  
\end{align}
$$

So **Case 2** holds. $$\square$$