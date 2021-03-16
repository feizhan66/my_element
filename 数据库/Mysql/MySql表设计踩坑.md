
utf8的锅

场景 : 之前在给客户做微商城时，需要保存微信的授权信息，此时就有一个nickname字段，在设计数据表时，潜意识的将表的存储格式设置为utf8，生产上线一段时间后偶尔出现保存异常。经分析，出现异常的原因是：用户nickname中有email表情符号。utf8格式的数据表存储不下导致。

经验提示： 在设计数据表时，一定要注意该字段存储的内容，如果允许设置表情，则一定不能使用utf8，而是使用utf8mb4。

选择合适的类型

  在数据库表设计时，字段的类型还真不好设计，这里简单说说：
保存手机号的字段，用varchar(20)就已经足够了，就不应该设计为varchar(100)，设置为varchar(100)只会消耗更多的存储以及内存开销，得不偿失啊！
保存Boolean类型，使用tinyint就够了，而不需要设计为int，甚至bigint。
数据类型设计的过大,就会造成没必要的浪费（磁盘，内存,CPU），最主要的是，这是一件费力不讨好的事情。


主外键字段类型不一致

  主外键类型不一致，说起来，你可能会不相信，但在数据库表设计时，稍不留神，就不一致，埋下隐式类型转换的坑。如下:

用户表:

create table t_base_user(

oid bigint(20) not null primary key auto_increment comment "主键", ....

)

注意此时的主键oid为bigint(20)。

用户地址表：

create table t_base_user_address(

oid bigint(20) not null primary key auto_increment comment "主键",

user_id varchar(30) null comment "用户id" ....

)

你看，此时在t_base_user_address表中的user_id外键字段,设计时的却是varchar(30)。你可能觉得你不可能发生这样的错误，说出来也不怕你笑话，我就踩过好几次这样的坑，到最后发现慢SQL了，才发现自己中了这样的坑！！！

注释

之前在数据库表设计时，就没有加注释的习惯，造成的直接后果是：数据库设计阶段一过，后续数据表的使用中，字段名就全靠猜了。我们写代码是知道注释是非常重要的，同样在设计数据库表时，注释也非常重要！一定要记住加注释，无论是表，还是字段，索引，都必须加上注释。

如:

create table t_base_user(

oid bigint(20) not null primary key auto_increment comment "主键", ....

)

已有表加注释

alter table t_base_user modify oid bigint(20) not null primary key auto_increment comment "主键"；

加注释时，还要注意的是：在一些需要计算的字段上，需要加上计算规则文档的链接。方便后续查找！


加索引

在之前的文章中也有说过，一个好的数据表设计，在一开始就应该考虑添加索引，这个阶段添加索引成本不仅最低









