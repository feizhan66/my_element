对于操作数据库的SQL语句，需要特别注意安全性，因为用户可能输入特定语句使得原有的SQL语句改变了功能。类似下面的例子：

```
$sql = "select * from pinfo where product = '$product'";
```

此时如果用户输入的$product参数为：

```
39'; DROP pinfo; SELECT 'FOO
```

那么最终SQL语句就变成了如下的样子：

```
select product from pinfo where product = '39'; DROP pinfo; SELECT 'FOO'
```

这样就会变成三条SQL语句，会造成pinfo表被删除，这样会造成严重的后果。

这个问题可以简单的使用PHP的内置函数解决：

```
$sql = 'Select * from pinfo where product = '"' 
       mysql_real_escape_string($product) . '"';
```

防止SQL注入攻击需要做好两件事：

对输入的参数总是进行类型验证

对单引号、双引号、反引号等特殊字符总是使用mysql_real_escape_string函数进行转义

但是，这里根据开发经验，不要开启php的Magic Quotes，这个特性在php6中已经废除，总是自己在需要的时候进行转义。

最有效的解决办法是用pdo预处理



**常见的mysql注入语句。**

**(1)不用用户名和密码**

```
1 //正常语句  
2 $sql =”select * from phpben where user_name=’admin’ and pwd =’123′”;  
3 //在用户名框输入’or’=’or’或 ‘or 1=’1 然后sql如下  
4 $sql =”select * from phpben where user_name=’ ‘or’=’or” and pwd =” “;  
5 $sql =”select * from phpben where user_name=’ ‘or 1=’1′ and pwd =” “;
```

这样不用输入密码。话说笔者见到登录框都有尝试的冲动。

**(2)在不输入密码的情况下，利用某用户。**

```
1 //正常语句  
2 $sql =”select * from phpben where user_name=’$username’ and pwd =’$pwd'”;  
3 //利用的用户名是benwin 则用户名框输入benwin’#  密码有无都可,则$sql变成  
4 $sql =”select * from phpben where user_name=’ benwin’#’ and pwd =’$pwd'”;
```

这是因为mysql中其中的一个注悉是“#”，上面语句中#已经把后面的内容给注悉掉，所以密码可以不输入或任意输入。网上有些人介绍说用“/*”来注悉，笔者想提的是只有开始注悉没结束注悉“*/”时，mysql会报错，也不是说“/**/”不能注悉，而是这里很难添加上“*/”来结束注悉，还有“– ”也是可以注悉mysql 但要注意“–”后至少有一个空格也就是“– ”，当然防注入代码要把三种都考虑进来，值得一提的是很多防注入代码中没把“– ”考虑进防注入范围。

**(3)猜解某用户密码**

```
1 //正常语句  
2 $sql =”select * from phpben.com where user_name=’$username’ and pwd =’$pwd'”;  
3 //在密码输入框中输入“benwin’ and left(pwd,1)=’p’#”，则$sql是  
4 $sql =”select * from phpben.com where user_name=’ benwin’ and left(pwd,1)=’p’#’ and pwd =’$pwd'”;
```

如果运行正常则密码的密码第一个字符是p，同理猜解剩下字符。

**(4)插入数据时提权**

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

```
1 //正常语句，等级为1  
2 $sql = “insert into phpben.com (`user_name`,`pwd`,`level`) values(‘benwin’,’iampwd’,1) “;  
3 //通过修改密码字符串把语句变成  
4 $sql = “insert into phpben.com (`user_name`,`pwd`,`level`) values(‘benwin’,’iampwd’,5)#’,1) “;  
5 $sql = “insert into phpben.com (`user_name`,`pwd`,`level`) values(‘benwin’,’iampwd’,5)–  ‘,1) “;这样就把一个权限为1的用户提权到等级5
```

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

**(5)更新提权和插入提权同理**

```
1 //正常语句  
2 $sql = “update phpben set  `user_name` =’benwin’, level=1″;  
3 //通过输入用户名值最终得到的$sql  
4 $sql = “update phpben set  `user_name` =’benwin’,level=5#’, level=1″;  
5 $sql = “update phpben set  `user_name` =’benwin’,level=5–  ‘, level=1″;
```

**(6)恶意更新和删除**

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

```
1 //正常语句  
2 $sql = “update phpben set `user_name` = ‘benwin’ where id =1″;  
3 //注入后,恶意代码是“1 or id>0”  
4 $sql = “update phpben set `user_name` = ‘benwin’ where id =1 or id>0″;  
5 //正常语句  
6 $sql = “update phpben set  `user_name` =’benwin’ where id=1″;  
7 //注入后  
8 $sql = “update phpben set  `user_name` =’benwin’ where id>0#’ where id=1″;  
9 $sql = “update phpben set  `user_name` =’benwin’ where id>0– ‘ where id=1″;
```

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

**(7)union、join等**

```
1 //正常语句  
2 $sql =”select * from phpben1 where `user_name`=’benwin’ “;  
3 //注入后  
4 $sql =”select * from phpben1 where`user_name`=’benwin’ uninon select * from phpben2#’ “;  
5 $sql =”select * from phpben1 where`user_name`=’benwin’ left join……#’ “;
```

**(8)通配符号%、_**

```
1 //正常语句  
2 $sql =”select * from phpben where `user_name`=’benwin’ “;  
3 //注入通配符号%匹配多个字符，而一个_匹配一个字符，如__则匹配两个字符  
4 $sql =”select * from phpben where `user_name` like ‘%b’ “;  
5 $sql =”select * from phpben where `user_name` like ‘_b_’ “;
```

这样只要有一个用户名字是b开头的都能正常运行,“ _b_”是匹配三个字符，且这三个字符中间一个字符时b。这也是为什么有关addslashes()函数介绍时提示注意没有转义%和_(其实这个是很多phper不知问什么要过滤%和_下划线，只是一味的跟着网上代码走)

**(9)还有很多猜测表信息的注入sql**

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

```
1 //正常语句  
2 $sql =”select * from phpben1 where`user_name`=’benwin'”;  
3 //猜表名，运行正常则说明存在phpben2表  
4 $sql =”select * from phpben1 where`user_name`=’benwin’ and (select count(*) from phpben2 )>0#’ “;  
5 //猜表字段，运行正常则说明phpben2表中有字段colum1  
6 $sql =”select * from phpben1 where`user_name`=’benwin’ and (select count(colum1) from phpben2 )>0#'”;  
7 //猜字段值  
8 $sql =”select * from phpben1 where`user_name`=’benwin’ and left(pwd,1)=’p’#””;
```

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

当然还有很多，笔者也没研究到专业人士那种水平，这里提出这些都是比较常见的，也是phper应该知道并掌握的，而不是一味的在网上复制粘贴一些防注入代码，知然而不解其然。

下面一些防注入方法回看可能更容易理解。

**3.3防注入的一些方法**

**3.3.1 php可用于防注入的一些函数和注意事项。**

**(1)addslashes 和stripslashes。**

Addslashes给这些 “’”、“””、“\”,“NULL” 添加斜杆“\’”、“\””、“\\”,“\NULL”, stripslashes则相反，这里要注意的是php.ini是否开启了magic_quotes_gpc=ON，开启若使用addslashes会出现重复。所以使用的时候要先get_magic_quotes_gpc()检查

一般代码类似：

```
1 if(!get_magic_quotes_gpc())  
2 {  
3          $abc = addslashes($abc);  
4 }
```

其实这个稍微学习php一下的人都知道了，只不过笔者想系统点介绍(前面都说不是专家级文章)，所以也顺便写上了。addslashes

**(2)mysql_escape_string()和mysql_ real _escape_string()**

mysql_real_escape_string 必须在(PHP 4 >= 4.3.0, PHP 5)的情况下才能使用。否则只能用 mysql_escape_string

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

```
1 if (PHP_VERSION >= ‘4.3’)  
2 {  
3 $string  =  mysql_real_escape_string($string);  
4 }else  
5 {  
6 $string  =  mysql_escape_string($string );  
7 }
```

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

mysql_escape_string()和mysql_ real _escape_string()却别在于后者会判断当前数据库连接字符集，换句话说在没有连接数据库的前提下会出现类似错误：

```
1 Warning: mysql_real_escape_string() [function.mysql-real-escape-string]: Access denied for user ‘ODBC’@’localhost’ (using password: NO) in E:\webphp\test.php on line 11
```

**(3)字符代替函数和匹配函数**
str_replace() 、perg_replace()这些函数之所以也在这里提是因为这些函数可以用于过滤或替代一些敏感、致命的字符。

**3.3.2防注入字符优先级。**

防注入则要先知道有哪些注入字符或关键字，常见的mysql注入字符有字符界定符号如“’”、“””；逻辑关键字如“and”、“or”；mysql注悉字符如“#”，“– ”，“/**/”；mysql通配符“%”，“_”；mysql关键字“select|insert|update|delete|*|union|join|into|load_file|outfile”

**(1)对于一些有规定格式的参数来说，防注入优先级最高的是空格” ”。**

如一些银行卡号，身份证号，邮箱，电话号码，，生日，邮政编码等这些有自己规定的格式且格式规定不能有空格符号的参数，在过滤的时候一般最先过滤掉空格（包括一些空格“变种”），因为其他字符界定符号，逻辑关键字，mysql注悉，注意下图可以看出重要的是“’”,“ ”

ps：空格字符的变种有：“%20”，“\n”，“\r”，“\r\n”，“\n\r”，“chr(“32″)” 这也是为什么mysql_escape_string()和mysql_real_escape_string() 两个函数转义“\n”，“\r”。其实很多phper只知道转义\n,\r而不知原因，在mysql解析\n,\r时把它们当成空格处理，笔者测试验证过，这里就不贴代码了。

**(2)“and”，“or”，“\”，“#”，“– ”**

逻辑关键可以组合很多注入代码；mysql注悉则把固有sql代码后面的字符全部给注悉掉从而让注入后的sql语句能正常运行；“\”也是能组合很多注入字符\x00,\x1a。

ps:sql解析“#”，“– ”是大多数mysql防注入代码没有考虑到的，也是很多phper忽略。还有因为一些phper给参数赋值的时候会有用“-”来隔开，所以笔者建议不要这样写参数，当然也可以再过滤参数的时候“– ”（注意有空格的，没空格不解析为注悉）当一个整体过滤而不是过滤“-” ，这样就避免过多过滤参数。

**(3)“null”，“%”，“_”**

这几个不能独立，都不要在特定情况下，比如通配字符“%，_”都要在mysql like子句的前提下。所以“%”，“_”的过滤一般在搜索相关才过滤，不能把它们纳入通常过滤队列，因为有些如邮箱就可以有”_”字符

**(4)关键字“select|insert|update|delete|*|union|join|into|load_file|outfile”**

也许你会问怎么这些重要关键字却优先级这么低。笔者想说的是因为这些关键字在没有“’”,“””，“ ”，“and”，“or”等情况下购不成伤害。换句话说这些关键字不够“独立”，“依赖性”特别大。当然优先级低，不代表不要过滤。

**3.3.3防注入代码。**

**(1)参数是数字直接用intval()函数**

注意：现在很多网上流行的防注入代码都只是只是用addslashes()、mysql_escape_string()、mysql_real_escape_string()或三者任意组合过滤，但phper以为过滤了，一不小心一样有漏洞，那就是在参数为数字的时候：

```
1 $id = addslashes($_POST[‘id’]); //正确是$id = intval($_POST[‘id’]);  
2 $sql =” select * from phpben.com where id =$id”;  
3 $sql =” select * from phpben.com where id =1 or 1=1″;
```

对比容易发现，post过来的数据通过addslashes过滤后的确很多注入已经不起作用，但是$id并没有intval，导致漏洞的存在，这是个小细节，不小心则导致漏洞。

**(2)对于非文本参数的过滤**

文本参数是指标题、留言、内容等可能有“’”，“’”等内容，过滤时不可能全部转义或代替。

但非文本数据可以。

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

```
 1 function _str_replace($str )  
 2 {  
 3      $str = str_replace(” “,””,$str);  
 4      $str = str_replace(“\n”,””,$str);  
 5      $str = str_replace(“\r”,””,$str);  
 6      $str = str_replace(“‘”,””,$str);  
 7      $str = str_replace(‘”‘,””,$str);  
 8      $str = str_replace(“or”,””,$str);  
 9      $str = str_replace(“and”,””,$str);  
10      $str = str_replace(“#”,””,$str);  
11      $str = str_replace(“\\”,””,$str);  
12      $str = str_replace(“– “,””,$str);  
13      $str = str_replace(“null”,””,$str);  
14      $str = str_replace(“%”,””,$str);  
15      //$str = str_replace(“_”,””,$str);  
16      $str = str_replace(“>”,””,$str);  
17      $str = str_replace(“<“,””,$str);  
18      $str = str_replace(“=”,””,$str);  
19      $str = str_replace(“char”,””,$str);  
20      $str = str_replace(“declare”,””,$str);  
21      $str = str_replace(“select”,””,$str);  
22      $str = str_replace(“create”,””,$str);  
23      $str = str_replace(“delete”,””,$str);  
24      $str = str_replace(“insert”,””,$str);  
25      $str = str_replace(“execute”,””,$str);  
26      $str = str_replace(“update”,””,$str);  
27      $str = str_replace(“count”,””,$str);  
28      return $str;  
29 }
```

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

ps：还有一些从列表页操作过来的一般href是”phpben.php?action=delete&id=1”,这时候就注意啦，_str_replace($_GET[‘action’])会把参数过滤掉，笔者一般不用敏感关键作为参数，比如delete会写成del，update写成edite，只要不影响可读性即可;

还有上面代码过滤下划线的笔者注悉掉了，因为有些参数可以使用下划线，自己权衡怎么过滤;

有些代码把关键字当重点过滤对象，其实关键字的str_replace很容易“蒙过关”，str_replace(“ininsertsert”)过滤后的字符还是insert，所以关键的是其他字符而不是mysql关键字。

**(3)文本数据防注入代码。**

文本参数是指标题、留言、内容等这些数据不可能也用str_replace()过滤掉，这样就导致数据的完整性，这是很不可取的。

代码：

[![复制代码](https://common.cnblogs.com/images/copycode.gif)](javascript:void(0); "复制代码")

```
 1 function no_inject($str)  
 2  
 3 {  
 4          if(is_array($str))  
 5          {  
 6                    foreach($str as $key =>$val)  
 7                    {  
 8                            $str[$key]=no_inject($val);  
 9                    }  
10          }else  
11          {  
12                    $str = str_replace(” “,” “,$str);  
13                    $str = str_replace(“\\”,”\”,$str);  
14                    $str = str_replace(“‘”,”‘”,$str);  
15                    $str = str_replace(‘”‘,”””,$str);  
16                    $str = str_replace(“or”,”or”,$str);  
17                    $str = str_replace(“and”,”and”,$str);  
18                    $str = str_replace(“#”,”#”,$str);  
19                    $str = str_replace(“– “,”– “,$str);  
20                    $str = str_replace(“null”,”null”,$str);  
21                    $str = str_replace(“%”,”%”,$str);  
22                    //$str = str_replace(“_”,””,$str);  
23                    $str = str_replace(“>”,”>”,$str);  
24                    $str = str_replace(“<“,”<“,$str);  
25                    $str = str_replace(“=”,”=”,$str);  
26                    $str = str_replace(“char”,”char”,$str);  
27                    $str = str_replace(“declare”,”declare”,$str);  
28                    $str = str_replace(“select”,”select”,$str);  
29                   $str = str_replace(“create”,”create”,$str);  
30                   $str = str_replace(“delete”,”delete”,$str);  
31                   $str = str_replace(“insert”,”insert”,$str);  
32                  $str = str_replace(“execute”,”execute”,$str);  
33                  $str = str_replace(“update”,”update”,$str);  
34                  $str = str_replace(“count”,”count”,$str);  
35          }  
36     return $str;  
37 }
```
