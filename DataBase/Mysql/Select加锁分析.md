尝试说出下面六句sql的区别

```sql
select * from table where id = ?

select * from table where id < ?

select * from table where id = ? lock in share mode

select * from table where id < > lock in share mode

select * from table where id = ? for update 

select * from table where id < ? for update
```

首先三个问题：
* 当前事物隔离级别是什么
* id列是否存在索引
* 如果存在索引是聚簇索引还是非聚簇索引

innnodb一定存在聚簇索引，默认以主键作为聚簇索引

有几个索引，就有几颗B+树(不考虑hash索引的情形)

聚簇索引的叶子节点为键盘上的真实数据。非聚簇索引的叶子节点还是索引，只想聚簇索引B+树

## 基础知识

共享锁(S锁)：假设失误T1对数据A加上共享锁，那么事务T2可以读取数据A。不能修改数据A

排他锁(X锁)：假设事务T1对数据A加上排他锁，那么事务T2不能读取数据A，不能修改数据A

我们通过update，delete等语句加上的锁都是行及的锁，只有LOCK TABLE...READ和LOCK TABLE ... WRITE才能申请表级别的锁`也就是我们每次的操作都会有行级别的锁`

意向共享锁(IS锁)：一个事务在获取（任何一行/或者全表）S锁之前，一定会先在虽在的表上加上IS锁

意向排他锁(IX锁)：一个事务在获取（任何一行/或者全表）X锁之前，一定会现在所在的表上加IX锁

- 意向锁存在的目的？
假设事务T1，用X锁来锁住表上的几条记录，那么此时表上存在IX锁，即意向排他锁。那么此时事务T2要进项LOCK TABLE ... WRITE的表几倍锁的请求，可以直接根据以下报告锁是否存在而判断是否有锁冲突


## 加锁算法

Record Locks:行锁。该锁是对索引记录进行加锁！锁是加载索引上而不是加在行上的。注意：innnodb一定存在聚簇索引，因此行锁最终都会落在聚簇索引上！

Gap Locks：间隙锁。对索引的间隙加锁，其目的只有一个，防止其他事物插入数据。在Read Committed隔离级别下，不会使用间隙锁。隔离级别比Read Committed低的情况下，也不会使用间隙锁，如隔离级别为Read Uncommited时，也不存在间隙锁。当隔离几倍为Repeatable Read和Serializable时，就会存在间隙锁

Next-Key Locks：理解为Record Lock+索引前面的Gap lOCK。锁住的是索引前面的间隙！必去一个索引包含值，10,11,13和20那么间隙锁的范围如下：
```sql
(negative infinity, 10)
(10,11]
(11,13]
(13,20]
(20, positive infinty)
```

## 快照读和当前读

在mysql中select分为快照读和当前读，执行下面语句：
```sql
select * from table where id = ?
```

执行的是快照读，读的是数据库记录的快照版本，是不加锁的。

执行：
```sql
select * from table where id = ? lock in share mode
```
会对读取激励加S锁（共享锁）

执行：
```sql
select * from table where id  = ? from update
```
会对读取记录加X锁（排他锁）

那么：加的是表锁还是行锁呢？

针对这一点，事务的随个隔离级别，他们有弱到强如下所示：
* Read Uncommited(RU):读未提交，一个事务可以读到另外一个事务未提交的数据！
* Read Committed(RC):读已提交，一个事务可以读到另一个事务已提交的数据！
Repeatable Read(RR):可重复读，加入间隙锁，一定程度上比表了幻读的产生！注意了，只是一定程度上，并没有完全避免！另外，从该级别才开始加入间隙锁
* Serializable：串行化，该几倍下读写串行化，所有的select语句后都自动加上lock inshare mode，即使用了共享锁。因此在该隔离级别下，使用的是当前读，而不是快照读


`注意`下面是错误观点：
innodb行锁是通过给索引上的索引项加锁来实现的，这一点mysql与oracle不同，后者是通过在数据块中相应数据行加锁来实现的。innodb这种航所实现特点意味着：只有通过索引条件检索数据，innodb才使用行级锁，否则，innodb将使用表锁。




































