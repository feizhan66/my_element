**4、防止xss攻击**

XSS：cross site script 跨站脚本，为什么不叫css，为了不和div+css混淆。

**4.1Xss攻击过程：**

(1)发现A站有xss漏洞。

(2)注入xss漏洞代码。可以js代码，木马，脚本文件等等，这里假如A站的benwin.php这个文件有漏洞。

(3)通过一些方法欺骗A站相关人员运行benwin.php，其中利用相关人员一些会员信息如cookies，权限等。

相关人员：

管理员（如贴吧版主），管理员一般有一定权限。目的是借用管理员的权限或进行提权，添或加管理员，或添加后门，或上传木马，或进一步渗透等相关操作。

A站会员：会员运行A站的benwin.php。目的一般是偷取会员在A站的信息资料。

方法：

1) 在A站发诱骗相关人到benwin.php的信息，比如网址，这种是本地诱骗
   2)   在其他网站发诱骗信息或者发邮件等等信息。
   一般通过伪装网址骗取A站相关人员点击进benwin.php
   (4)第三步一般已经是一次xss攻击，如果要更进一步攻击，那不断重复执行(2)、(3)步以达到目的。
   简单例说xss攻击
   代码：benwin.php文件
   [![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")
   ```
    1 <html>  
    2 <head>  
    3 <title>简单xss攻击例子</title></head>  
    4 <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>  
    5 <dody>  
    6 <form action=”phpben.com?user_name=<?php echo $user_name; ?>”>  
    7 <input type=”submit” value=”提交” >  
    8 </form>  
    9 </body>  
   10 </html>
   ```
   [![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")
   当用户名$user_name的值是“benwin” onSubmit=”alert(‘这是xss攻击的例子’);” class= “”（这里）
   ```
   1 <form action=”phpben.com?user_name=benwin” onSubmit=”alert(‘这是xss攻击的例子’);” class= “” >  
   2 <input type=”submit” value=”提交” >  
   3 </form>
   ```
   当提交表单的时候就会弹出提示框。
   (1)     很明显$user_name在保存进数据库的时候没有过滤xss字符（和防注入很像，这里举例说明）==>发现漏洞
   (2)     构造xss代码：benwin” onSubmit=”alert(‘这是xss攻击的例子’);” class= “” 传入数据库
   (3)     骗相关人员进来点击“提交”按钮
   **4.2常见xss攻击地方**
   **(1)Js地方**
   ```
   1 <script language=”javascript”>  
   2 var testname =” <?php echo $testname;?>”;  
   3 </script>
   4 $testname的值只要符合js闭合关系：“”;alert(“test xss “);”(以下同理)
   ```
   **(2)form表单里面**
   ```
   1 <input type=”text” name=”##” value=”<?php echo $val; ?>” />
   ```
   **(3)a标签**
   ```
   1 <a href=”benwin.php?id= <?php echo $id; ?>”>a标签可以隐藏xss攻击</a>
   ```
   **(4)用得很多的img标签**
   ```
   1 <img src=”<?php echo $picPath; ?>” />
   ```
   甚至一些文本中插入整个img标签并且用width、 height、css等隐藏的很隐蔽
   **(5)地址栏**
   总之，有输出数据的地方，更准确的说是有输出用户提交的数据的地方，都有可能是XSS攻击的地方。
   **4.3防XSS方法**
   防xss方法其实和防注入很相似，都是一些过滤、代替、实体化等方法
   (1)过滤或移除特殊的Html标签。
   例如:< 、>、<,、> ‘、”、<script>、 <iframe> 、<,、>、”
   (2)过滤触发JavaScript 事件的标签。例如 onload、onclick、onfocus、onblur、onmouseover等等。
   (3)php一些相关函数，strip_tags()、htmlspecialchars()、htmlentities()等函数可以起作用
