临时设置
export PATH=/opt/android-studio/bin:$PATH

当前用户的全局设置
vim ~/.profile，添加行： 
export PATH=/opt/android-studio/bin:$PATH 
使生效 
source .profile

所有用户的全局设置
vim /etc/profile 
在里面加入： 
export PATH=/opt/android-studio/bin:$PATH 
使生效 
source /etc/profile

注意：
Ubuntu下xampp安装的引入路径是/opt/lampp/bin