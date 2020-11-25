|日期|问题|原因|修改|
|------|----|----|---|
|2017--3--15(QL)| 服务器无法ping www.baidu.com |DNS设置不正确|vi /etc/resolv.conf 添加	nameserver 8.8.8.8 nameserver 114.114.114.114|
|2017--3--15(QL)||| 服务器配置：安装ssh(apt-get install openssh-server) 开放22端口 cd 到/etc/()   添加规则 -A FW -m state –state NEW -m tcp -p tcp –dport 22 -j ACCEPT|
|2017--3--16(QL)||| 设置root用户的密码为loop(sudo passwd root) 远程登陆用户为loop loop 远程登陆只能使用(loop loop) root|
|2017--3--16(QL)||| 修改考试系统中编译系统的mysql数据库，（不知咋修改，cd 然后进入hustoj 修改judge.conf的数据库名字，然后重新执行了install.sh）|
|2017--3--16(QL)|开放3306 80 端口 更改apache2 网站根目录||（cd /etc/apache2/sites-available  vi 000-default.conf 修改： DocumentRoot /var/www/html/C_System/Code_Admin/web）|
|2017--3--16(QL)| 开放mysql 的root用户远程访问权限||（vi /etc/mysql/my.cnf 注释 #bind-address = 127.0.0.1 然后登陆mysql执行 GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root' WITH GRANT OPTION;)
|2017--3--16(QL)||| 修改数据库中question中 Description 中的文件路径 UPDATE questions SET `Description` = REPLACE(`Description`,'/C_System/Code_Admin/upload/question','/upload/question')|
|2017--3--16(QL)| 考试系统upload文件夹在web上一级，导致无法访问upload下的图片资源。|| 解决：在web下建立了一个软连接 (ln -s /var/www/html/C_System/Code_Admin/upload upload )|
|2017--3--16(QL)||| 考试系统前台无法进入考试(服务器没有执行最新代码，依旧执行的以前的代码) 解决：重启了下apache2 （service apache2 restart）（MDZZ）|
|2017--3--16(QL)| 考试系统执行最新代码后，当前时间获取不正确，|原因：php.ini 的时区配置不正确 |解决：(cd /etc/php5/apache2/)   vi php.ini 去掉 ;date.timezone前面的; 然后修改成data.timezone = "Asia/Shanghai" 重启apache2（FUCK）|
|2017--3--18(QL)| 考试系统访问速度太慢，|原因：apache配置的效率不够高，|修改配置：(vi /etc/apache2/apache2.conf),修改 Timeout 30  (确定发送超时和接收超时的秒数) KeepAlive Off (关闭保持连接)MaxKeepAliveRequests 200  (一次连接可以进行的HTTP请求的最大请求次数。0表示无限数量。)KeepAliveTimeout 5 (测试一次连接中的多次请求传输之间的时间，如果服务器已经完成了一次请求，但一直没有接收到客户程序的下一次请求，在间隔超过了这个参数设置的值之后，服务器就断开连接)|
|2017--4--8(QL)| 考试系统编译系统经常性挂掉（不知啥原因）||解决：利用crontab -e (定时执行任务)加入定时任务，每隔20秒监控/etc/init.d/judged 的状态是否已经崩掉，崩掉就重启（定时执行/root/MonitorJudged/RestartJudged 脚本）|
|2017--4--8(QL)|| | 考试系统备份工作，每天1:30备份数据库到本地文件（/root/mysqlbak）同时备份数据库到59服务器（每天1:30执行/root/mysqlbak/bak.sh 脚本）|



判题配置文件

	########################/home/judge/etc/judge.conf###########################
			OJ_HOST_NAME=localhost    #数据库地址
		OJ_USER_NAME=root #数据库用户名
		OJ_PASSWORD=root #数据库密码
		OJ_DB_NAME=stu_system #数据库名
		OJ_PORT_NUMBER=3306 #数据库端口
		OJ_RUNNING=1 #可以同时运行几个进程
		OJ_SLEEP_TIME=1 #如果有空闲 要休眠多久
		OJ_TOTAL=1 #总共有多少台机器负责判题
		OJ_MOD=0 #当前机器评判取模为多少的提交
	########################/home/judge/etc/judge.conf###########################

	设置启动脚本

	   with root or sudo
	   echo "LANG=C /usr/bin/judged" > /etc/init.d/judged
	   chmod +x  /etc/init.d/judged
	   ln -s /etc/init.d/judged /etc/rc2.d/S93judged
	   ln -s /etc/init.d/judged /etc/rc3.d/S93judged

	您需要修改系统php.ini,给予php操作数据目录的权限。 以下是推荐修改的设置

		   sudo gedit /etc/php5/apache2/php.ini
		   open_basedir =/home/judge/data:/var/www/JudgeOnline:/tmp
		   max_execution_time = 300     ; Maximum execution time of each script, in seconds
		   max_input_time = 600
		   memory_limit = 256M      ; Maximum amount of memory a script may consume (16MB)
		   post_max_size = 64M
		   upload_tmp_dir =/tmp
		   upload_max_filesize = 64M

	修改php.ini后apache需重启
