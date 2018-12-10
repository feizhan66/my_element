打开 shell 窗口，
在窗口中输入 sudo apt-get update,更新软件源，最后会读取软件包列表：

输入 sudo apt-get dist-upgrade,更新所有的软件：

如果想要安装相应的软件，自需输入 sudo apt-get install 软件名


Ubuntu更新的几种命令:
1.列举本地更新sudo apt-get update

2.安装可用更新sudo apt-get upgrade

3.查询软件包apt-cache search package_name

4.安装一个软件包sudo apt-get install package_name

5.删除一个软件包sudo apt-get remove package

6.列举其他apt-get 命令apt-get help

7.install/unstall .deb filessudo dpkg -i package_file.deb ,sudo dpkg -r package_filename

8.convert .rpm to .deb filessudo alien package

9.install tarballstar xfvz tarball_name