<?php

/**
 * 用法
 */
// $mysql = new Mysql('hk_dollar');
// $a = $mysql->select('id','key')->table('bop_id')->forPage(2,10)->get();
// $a = $mysql->select('id','key')->table('bop_id')->where('key','=','jfayGvakkaXhWwpKkxcXudDE8P8HHJit')->first();
// $a = $mysql->table('bop_id')->insert(['key'=>rand(1,99999999),'type'=>'va']);
// $a = $mysql->table('bop_id')->insertAll([['key'=>rand(1,99999999),'type'=>'va'],['key'=>rand(1,99999999),'type'=>'va']]);
// $a = $mysql->table('bop_id')->where('id','=','1000258')->update(['key'=>'123456']);
// $a = $mysql->table('bop_app')->getTableColumn();
// $a = $mysql->query("select * from bop_id where id = 0 limit 1");
// var_dump($a);
// exit();

class Mysql{
    const dbms = 'mysql'; // 数据库类型
    const host = '127.0.0.1'; // 数据库主机名
    const dbName = 'hkpay'; // 使用的数据库
    const user = 'root'; // 数据库连接用户名
    const pass = '123456'; // 对应的密码

    public $initPdo;

    public $query;

    public function __construct($dbName='')
    {
        $this->query = new \stdClass;

        try {

            $db = $dbName ? $dbName : self::dbName;
            // 初始化一个pdo对象
            // var_dump(self::dbms.':host='.self::host.';dbname='.self::dbName,self::user,self::pass);
            $this->initPdo =  new PDO(self::dbms.':host='.self::host.';dbname='.$db,self::user,self::pass);
            $this->initPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//设置异常模式

            // $pre = $this->initPdo->prepare("select * from bop_id");
            // $pre->execute();

            // $res = $pre->fetchAll(PDO::FETCH_ASSOC);
            // print_r($res);
            // exit();

            // 默认不是长连接，如果需要长连接需要在最后加一个参数
            // $dbh = new PDO(self::dbms.':host='.self::host.';dbname'.self::dbName,self::user,self::pass,array(PDO::ATTR_PERSISTENT => true));

        }catch(\Exception $e){
            die("连接数据库失败".$e->getMessage());
        }
    }

    /**
     * 直接SQL查询
     */
    public function query($sql){
        $res = $this->initPdo->query($sql,PDO::FETCH_ASSOC);
        return $res->fetchAll();
        
        // foreach($res as $value){
        //     var_dump($value);
        // }
        // var_dump($res);
    }

    /**
     * 获取操作的表
     */
    public function table($table){
        $this->query->table = $table;
        return $this;
    }

    /**
     * 插入查询条件
     * $where 可以是字符串也可以是数组
     */
    public function where($column,$operator = null,$value = null,$boolean = 'and'){
        // if(is_string($where)){
        //     // $this->initPdo
        // }
        // print_r($where);
        // func_get_args


        if ($column instanceof Closure) {
            // 判断是否闭包
        } else {
            // Laravel查询层 还有这么一层的
            // $this->query->where(...func_get_args());

            if (is_array($column)){
                // 数组传参
                foreach($column as $key=>$value){
                    $this->query->where[] = [
                        'column'=>$key,
                        'operator'=>'=',
                        'value'=>$value,
                        'boolean'=>'and'
                    ];
                }
            } else {
                $this->query->where[] = [
                    'column'=>$column,
                    'operator'=>$operator,
                    'value'=>$value,
                    'boolean'=>$boolean
                ];
            }
        }

        return $this;
    }

    public function forPage($page,$size){
        $begin = ($page-1) * $size + 1;
        $this->query->limit = [$begin,$size];
        return $this;
    }

    public function beginTransaction(){
        $this->initPdo->beginTransaction();
        return $this;
    }

    public function rollback(){
        $this->initPdo->rollBack();
        return $this;
    }

    public function commit(){
        $this->initPdo->commit();
        return $this;
    }

    /**
     * 获取所有的数据
     */
    public function get(){
        return $this->buildSql('select');
    }

    /**
     * 获取第一条
     */
    public function first(){
        return $this->buildSql('select',true);
    }

    /**
     * 更新
     */
    public function update($data = []){
        $this->query->update = $data;
        return $this->buildSql('update');
    }

    // public function save(){}

    /**
     * 插入一条
     */
    public function insert($data=[]){
        $this->query->insert = $data;
        return $this->buildSql('insert');
    }

    /**
     * 批量插入
     */
    public function insertAll($data=[]){
        // $count = 0;
        // foreach($data as $value){
        //     if($this->insert($value)){
        //         $count ++;
        //     }
        // }
        // return $count;

        $this->query->insertAll = $data;
        return $this->buildSql('insertAll');
    }

    /**
     * 选择获取的字段
     */
    public function select(...$select){
        $this->query->select = $select;
        return $this;
    }

    // public function toArray(){}

    /**
     * 格式化成SQL
     */
    private function buildSql($operation,$limitOne=false){
        // print_r(gettype($this->query->where));
        // print_r($this->query);
        $sql = '';
        // 处理select条件
        $format_select = '*';
        if(!empty($this->query->select)){
            // 注意关键字
            foreach($this->query->select as $key=>$value){
                $this->query->select[$key] = '`'.$value.'`';
            }
            $format_select = implode(',',$this->query->select);
        }

        $column_str = '';
        $value_str = '';
        $where_str = ' ';
        $execute_data = [];
        if ($operation == 'select'){
            if(!empty($this->query->where)){
            
                $where_str = ' where ';
                foreach($this->query->where as $key=>$value){
                    if($key != 0){
                        $where_str = $where_str.' '.$value['boolean'];
                    }
                    $where_str = $where_str.' `'.$value['column'].'` '.$value['operator'].' ?';
    
                    $execute_data[] = $value['value'];
                }
                // print_r($where_str);
            }
        } else if($operation == 'insert'){
            // 插入不允许查询语句
            // 当前只允许一条一条插入
            if (empty($this->query->insert)){
                return 0; // 影响0条
            } else {
                
                $array_keys = array_keys($this->query->insert);
                foreach($array_keys as $k=>$v){
                    $array_keys[$k] = '`'.$v.'`';

                    $value_str = $value_str.' ,?';
                }
                $column_str = '('.implode(',',$array_keys).')';

                $value_str = '('.trim($value_str,' ,').')';
                
                $execute_data = array_values($this->query->insert);
                // print_r($execute_data);
            }
        } else if($operation == 'insertAll'){
            // 插入不允许查询语句
            if (empty($this->query->insertAll)){
                return 0; // 影响0条
            } else {
                $one_line_count = 0;
                $value_str_one = '';
                foreach($this->query->insertAll as $value){
                    // var_dump($value);exit();

                    // 特殊的字段，在没有主键的时候出现
                    unset($value['__#alibaba_rds_row_id#__']);

                    if(empty($column_str)){
                        $array_keys = array_keys($value);
                        foreach($array_keys as $k=>$v){
                            $array_keys[$k] = '`'.$v.'`';
    
                            $value_str_one = $value_str_one.' ,?';
                        }
                        $column_str = '('.implode(',',$array_keys).')';
                        $one_line_count = count($array_keys);
                        $value_str_one = '('.trim($value_str_one,' ,').')';
                    }
                    $value_str = $value_str.','.$value_str_one;

                    // 如果为空的话需要赋数据库的默认值
                    $tableColumn = $this->getTableColumn();
                    foreach($value as $k=>$v){
                        if (empty($v)){
                            $value[$k] = $tableColumn[$k]['Default'];
                        }
                    }

                    $one_line_value = array_values($value);
                    foreach($one_line_value as $v){
                        $execute_data[] = $v;
                    }
                }
                $value_str = trim($value_str,',');

                // print_r($one_line_count * count($this->query->insertAll));
                // print_r(count($execute_data));
                // print_r($value_str);

                // 校验参数
                if($one_line_count * count($this->query->insertAll) != count($execute_data)){
                    throw new \Exception('参数校验失败，请检查数组是否标准二维结构');
                }
                
            }
        } else if($operation == 'update'){
            // 更新语句
            $update_keys = array_keys($this->query->update);
            foreach($update_keys as $value){
                $column_str = $column_str.',`'.$value.'`=?';
            }
            $column_str = trim($column_str,',');
            $execute_data = array_values($this->query->update);
            if(!empty($this->query->where)){
            
                $where_str = ' where ';
                foreach($this->query->where as $key=>$value){
                    if($key != 0){
                        $where_str = $where_str.' '.$value['boolean'];
                    }
                    $where_str = $where_str.' `'.$value['column'].'` '.$value['operator'].' ?';
    
                    $execute_data[] = $value['value'];
                }
                // print_r($where_str);
            }
        }

        $limit_str = '';
        if(!empty($this->query->limit)){
            $limit_str = ' limit '.implode(',',$this->query->limit);
        }
        if($limitOne){
            $limit_str = ' limit 1';
        }

        // 构建SQL
        if ($operation == 'select'){
            // select * from bop_id where id = ''
            $sql = 'select '.$format_select.' from `'.$this->query->table.'` '.$where_str.$limit_str;
        } else if($operation == 'insert' || $operation == 'insertAll'){
            $sql = 'insert into `'.$this->query->table.'` '.$column_str.' values '.$value_str;
        } else if($operation == 'update'){
            $sql = 'update `'.$this->query->table.'` set '.$column_str.' '.$where_str;
        }

        // print_r($sql);
        // print_r($execute_data);

        // 预处理
        // var_dump($this->initPdo);
        // 执行预处理
        $sm = $this->initPdo->prepare($sql);
        // 执行操作
        if(!empty($execute_data)){
            $exec = $sm->execute($execute_data);
        } else {
            $exec = $sm->execute();
        }

        if($operation == 'select') {
            $dataList = [];
            // while($data = $sm->fetch(PDO::FETCH_ASSOC)){
            //     $dataList[] = $data;
            // }
            $dataList = $sm->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($dataList)){
                if($limitOne){
                    return $dataList[0];
                }
            }
            return $dataList;
        } else {
            return $exec;
        }

        return false;

    }

    /**
     * 处理默认值的
     * 
     * 存在不允许为null但是默认值为null的情况
     */
    public function getTableColumn(){
        if(empty($this->query->tableOld)){
            $this->query->tableOld = '';
        }
        $sql = "DESCRIBE ".$this->query->table;
        $re_data = [];
        if($this->query->table == $this->query->tableOld){
            if (empty($this->query->tableColumn)){
                $sm = $this->initPdo->prepare($sql);
                // 执行操作
                $sm->execute();
        
                $column = $sm->fetchAll(PDO::FETCH_ASSOC);
                $data = [];
                foreach($column as $value){

                    if($value['Null'] == 'NO' && $value['Default'] == null){
                        if(strpos($value['Type'],'int')!==false){
                            $value['Default'] = 0;
                        } else if(strpos($value['Type'],'char')!==false){
                            $value['Default'] = '';
                        }
                    }

                    $data[$value['Field']] = $value;
                }
                $this->query->tableColumn = $data;
                $re_data = $data;
            } else {
                $re_data = $this->query->tableColumn;
            }
        } else {
            $sm = $this->initPdo->prepare($sql);
            // 执行操作
            $sm->execute();
    
            $column = $sm->fetchAll(PDO::FETCH_ASSOC);
            $data = [];
            foreach($column as $value){

                if($value['Null'] == 'NO' && in_array($value['Default'],[null,'0000-00-00 00:00:00'])){
                    if(strpos($value['Type'],'int')!==false){
                        $value['Default'] = 0;
                    } else if(strpos($value['Type'],'char')!==false){
                        $value['Default'] = '';
                    } else if(strpos($value['Type'],'timestamp') !== false){
                        $value['Default'] = '2018-01-01 00:00:01';
                    }
                }

                $data[$value['Field']] = $value;
            }
            $this->query->tableColumn = $data;
            $re_data = $data;
            $this->query->tableOld = $this->query->table;
        }
        
        return $re_data;
        // var_dump($re_data);
        // exit();

    }


    /**
     * ------------------------------下面是测试的------------------------------
     */




    /**
     * 事务与自动提交
     */
    public function TransactionAndCommit(){
        $pdo = $this->initPdo;

        try{

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->beginTransaction();
            // 执行一条语句并分会受影响的行数
            $pdo->exec("insert into bop_id (type, last) values (23, 'Joe', 'Bloggs')");
            $pdo->exec("insert into salarychange (id, amount, changedate) 
                values (23, 50000, NOW())");
            $pdo->commit();

        }catch(\Exception $e){
            $pdo->rollBack();
            echo "Failed: " . $e->getMessage();
        }

    }

    /**
     * 预处理语句进行重复输入
     */
    public function PrepareAndInsertMore(){
        $pdo = $this->initPdo;
        $stmt = $pdo->prepare("INSERT INTO REGISTRY (name, value) VALUES (:name, :value)");
        // 可以用"?"代替
        // $stmt = $pdo->prepare("INSERT INTO REGISTRY (name, value) VALUES (?, ?)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':value', $value);

        // 插入一行
        $name = 'one';
        $value = 1;
        $stmt->execute();

        //  用不同的值插入另一行
        $name = 'two';
        $value = 2;
        $stmt->execute();

        // 提交方法
        $stmt->execute(array(':name'=>'free',':value'=>3));

        $sm = $pdo->prepare("select * from xxxx");
        $sm->execute();
        // 返回一个包含结果集中所有行的数组
        $yellow = $sm->fetchAll();
    }

    /**
     * 预处理语句获取数据
     */
    public function PrepareAndGetData(){
        $pdo = $this->initPdo();
        $stmt = $pdo->prepare("SELECT * FROM REGISTRY where name = ?");
        if ($stmt->execute(array($_GET['name']))) {
            // fetch从结果集中获取下一行，括号里面逗号隔开可以传多个值
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                print_r($row);
            }
        }
    }

    /**
     * 查询，获取结果集
     */
    public function QueryResult(){
        $pdo = $this->initPdo();
        $sql = 'SELECT name, color, calories FROM fruit ORDER BY name';
        foreach ($pdo->query($sql) as $row) {
            print $row['name'] . "\t";
            print $row['color'] . "\t";
            print $row['calories'] . "\n";
        }
    }




}


