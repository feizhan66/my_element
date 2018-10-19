# shutil模块

import shutil

# copy 复制文件 (拷贝的同时可以重命名)
rst = shutil.copy("D:\project\python_study\WatchVideo\\aa\\66.html","D:\project\python_study\WatchVideo\\aa\\aa\\66.html")
print(rst)

# copy2 复制文件，保留原数据（文件信息）
res = shutil.copy2("D:\project\python_study\WatchVideo\\aa\\66.html","D:\project\python_study\WatchVideo\\aa\\aa\\666.html")
print(res)

# copyfile 将一个文件中的内容复制到另外一个文件当中
# 覆盖源文件
# 不存在则创建
f = shutil.copyfile("D:\project\python_study\WatchVideo\\aa\\66.html","D:\project\python_study\WatchVideo\\aa\\aa\\6666.html")

# move 移动 文件 / 文件夹
# re = shutil.move("","")
# print(re)





# 归档和压缩 make_archive
# - 归档：把多个文件或者文件夹合并到一个文件当中
# - 压缩：用算法把多个文件或者文件夹无算或者有损合并到一个文件当中
help(shutil.make_archive)
# "zip", "tar", "gztar",
#     "bztar", or "xztar"
r = shutil.make_archive("D:\project\python_study\WatchVideo\\aa","zip","D:\project\python_study\WatchVideo\\aa")
print(r)
help(shutil.unpack_archive)
# 解压
shutil.unpack_archive(r,"D:\project\python_study\WatchVideo\\aa\\a")



# zip 压缩包
import zipfile
# 获取对象实例
zf = zipfile.ZipFile("D:\project\python_study\WatchVideo\\aa\\66.html.zip")
print(zf)
print(zf.getinfo("66.html.zip"))
# 获取zip文档内所有文件列表
nl = zf.namelist()
print(nl)
# 解压缩
rst = zf.extractall("D:\project\python_study\WatchVideo\\aa\\a")
print(rst)

