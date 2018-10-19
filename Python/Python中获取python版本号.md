```
#!/usr/bin/python 
# 第1种方法
import platform 
print(platform.python_version())

>>> import platform
>>> print(platform.python_version())
3.6.3

# 第2种方法
import sys 
print(sys.version)
print(sys.version_info)

>>> import sys
>>> print(sys.version)
3.6.3 (v3.6.3:2c5fed8, Oct  3 2017, 18:11:49) [MSC v.1900 64 bit (AMD64)]
>>> print(sys.version_info)
sys.version_info(major=3, minor=6, micro=3, releaselevel='final', serial=0)
>>> print(sys.version_info.major)

```




