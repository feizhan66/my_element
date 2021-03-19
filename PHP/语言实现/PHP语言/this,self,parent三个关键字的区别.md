# this,self,parent三个关键字的区别

- this,self,parent三个关键字从字面上比较好理解,分别是指这、自己、父亲。


* this是指向当前对象的指针(姑且用C里面的指针来看吧)
* self是指向当前类的指针【self是指向类本身，也就是self是不指向任何已经实例化的对象，一般self使用来指向类中的静态变量。因为self是指向类本身，与任何对象实例无关。换句话说，假如我们的类里面静态的成员，我们也必须使用self来调用。】
* parent是指向父类的指针(我 们这里频繁使用指针来描述，是因为没有更好的语言来表达)

> this是指向对象实例的一个指针，self是对类本身的一个引用，parent是对父类的引用。


[详细介绍](https://www.feizhan.me/public/index/blog/blog.html?article_id=1413)


