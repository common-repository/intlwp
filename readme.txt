=== Internationalize WordPress (IntlWP) ===
Contributors: wdisk
Donate link: http://xn--fjqz24b.xn--fiqs8s/u?id=2
Tags: idns, Domain-based, Path-based, sub-domainname, Internationalize, localize
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 1.2.1

Internationalize your WordPress multisite. Your users can use their local language as sub-domainname or sub-path in your wordpress multisite.

== Description ==

<strong>1) Domain-based network WordPress multisite: </strong>

Default WordPress multisite only allow user use English letters and numbers as sub-domainname. 

With this plugin, your users can use their own local language as sub-domainname. e.g. 

Main site domainname: blogs.com

User blog use sub-domainname:

我的.blogs.com (Chinese)<br />
私の.blogs.com (Japanese)<br />
나의.blogs.com (Korean)<br />
мой.blogs.com (Russian)<br />
...

If your main site domainname use IDNs, then the users sub-domainname will be:
 
我的.博客.中国 (Chinese)<br />
私の.ブログ.日本 (Japanese)<br />
나의.블로그.한국 (Korean)<br />
мой.Блог.РФ (Russian)<br />
...

<strong>2) Path-based network WordPress multisite</strong>

your users can use their own local language as path-name. e.g. 

blogs.com/我的/ (Chinese)<br />
blogs.com/私の/ (Japanese)<br />
blogs.com/나의/ (Korean)<br />
blogs.com/мой/ (Russian)<br />
...

<strong>3)Restrict the sub-domainname and path name length</strong>

Default WordPress multisite only allow user choose more than 4 characters as sub-domainname or path name.

With this plugin, you can change it in network admin side, both max length and min length.


== Installation ==

1. Your WordPress multisite is installed and runing. more help: http://mu.wordpress.org/ and http://xn--fjqz24b.xn--fiqs8s/
2. Upload, and activate the IntlWp plugin through the 'Plugins' menu in WordPress network admin side(Super admin of WordPress multisite).
3. setup IntlWp config through the 'IntlWp' menu in WordPress network admin side.
4. If using Path-based network WordPress multisite, you need change your .htaccess manually.

replace [_0-9a-zA-Z-] with [^/]

a example file is placed in tool/path-based-htaccess.txt

That's all.

== Frequently Asked Questions ==

1)Localize translation

po file locate in language folder, you can edit it and build mo file

== Changelog ==

= 1.2.1 =
* filter punct and space
= 1.2.0 =
* fix Idna class bug
* support path-based network
= 1.1.0 =
* fix load plugin language bug
= 1.0 =
* Add readme.txt