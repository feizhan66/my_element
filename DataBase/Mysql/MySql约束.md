# 约束类型

- 主键约束 primary key
> 添加语法：alter  table 表名 add primary key;（列名）※  可以有多个列名

> 删除语法：alter table 表名 drop primary key；
- 唯一约束 unique key

- 外键约束 foreign key
> 添加语法：alter table 表名称 add foreign key (列名称)  references  关联表名称（列名称）;

> 删除语法：alter table 表名称 drop foreign key 外键名称;   ※外键名和外键名称不一样
- 非空约束 not null
- 默认值约束 default
