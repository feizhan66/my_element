# mysql 分组之后如何统计记录条数gourp by 之后的count()

```
SELECT count(*) FROM 表名 WHERE 条件; // 这样查出来的是总记录数

SELECT count(*) FROM 表名 WHERE GROUP BY id; // 这样统计的是魅族的记录条数
```

如何获得 第二个sql语句的总记录条数？

如下
```
select count(*) from (select count(*) from 表名 where 条件 group by id) a;

select count(*) from (select count(*) from `order` where date>'xxx' and date<'xxx' group by id) a;
```
注意：
子查询方式mysql中子结果集必须使用别名，而oracle中不需要特意加别名