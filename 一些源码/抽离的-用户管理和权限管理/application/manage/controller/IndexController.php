<?php 
namespace app\manage\controller;

use think\Db;
use app\manage\model\AuthRoleModel;
use app\manage\model\AuthRuleModel;

/**
 * @breif 首页信息控制器
 **/
class IndexController extends CommonController
{
    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
    public function region()
    {
        $param = '';
        $url = 'http://apis.map.qq.com/ws/district/v1/getchildren?key=PGYBZ-BZMW6-PTJSM-EWDSU-GYFAV-WMBX6&output=json';

        $time = 0.25 * 1000000;
        // 21
        $minKey = 21;
        $maxKey = 21;
        $count = 0;

        $firstData = $this->curl_request($url.$param);
        $firstData = json_decode($firstData,true); usleep($time);
        if ( !array_key_exists('result',$firstData) ) return;
        $firstData = $firstData['result'][0];

        foreach ($firstData as $firstDataKey => $firstDataValue)
        {
            if ($minKey <= $firstDataKey && $firstDataKey <= $maxKey)
            {
                echo $firstDataKey.'<br/>';
            } else
            {
                continue;
            }
            $data = array();
            $data['region_level'] = 1;
            $data['parent_code'] = 86;
            $data['region_order'] = $firstDataKey+1;
            // 必选
            $data['region_code'] = $firstDataValue['id'];
            $data['region_name'] = $firstDataValue['fullname'];
            // 可选
            if (array_key_exists('name', $firstDataValue))
            {
                $data['region_shortname'] = $firstDataValue['name'];
            }
            if (array_key_exists('pinyin', $firstDataValue))
            {
                $data['region_name_en'] = implode(',' , $firstDataValue['pinyin']);
                $data['region_shortname_en'] = '';
                foreach ($firstDataValue['pinyin'] as $key => $value)
                {
                    $data['region_shortname_en'] .= strtoupper(substr($value, 0, 1));
                }
            }
            if (array_key_exists('location', $firstDataValue))
            {
                $data['location_latitude'] = $firstDataValue['location']['lat'];
                $data['location_longitude'] = $firstDataValue['location']['lng'];
            }
            $result = Db::name('region')->insert($data);

            $count++;

            ///////////////////////////////////////////
            $param = '&id='.$firstDataValue['id'];

            $secondData = '';
            $secondData = $this->curl_request($url.$param); usleep($time);
            $secondData = json_decode($secondData,true);
            if ( !array_key_exists('result',$secondData) ) continue;
            $secondData = $secondData['result'][0];

            foreach ($secondData as $secondDataKey => $secondDataValue)
            {
                $data = array();
                $data['region_level'] = 2;
                $data['parent_code'] = $firstDataValue['id'];
                $data['region_order'] = $secondDataKey+1;
                // 必选
                $data['region_code'] = $secondDataValue['id'];
                $data['region_name'] = $secondDataValue['fullname'];
                // 可选
                if (array_key_exists('name', $secondDataValue))
                {
                    $data['region_shortname'] = $secondDataValue['name'];
                }
                if (array_key_exists('pinyin', $secondDataValue))
                {
                    $data['region_name_en'] = implode(',' , $secondDataValue['pinyin']);
                    $data['region_shortname_en'] = '';
                    foreach ($secondDataValue['pinyin'] as $key => $value)
                    {
                        $data['region_shortname_en'] .= strtoupper(substr($value, 0, 1));
                    }
                }
                if (array_key_exists('location', $secondDataValue))
                {
                    $data['location_latitude'] = $secondDataValue['location']['lat'];
                    $data['location_longitude'] = $secondDataValue['location']['lng'];
                }
                $result = Db::name('region')->insert($data);

                $count++;

                //////////////////////////////////////////////
                $param = '&id='.$secondDataValue['id'];

                $thirdData = '';
                $thirdData = $this->curl_request($url.$param);
                $thirdData = json_decode($thirdData,true); usleep($time);
                if ( !array_key_exists('result',$thirdData) ) continue;
                $thirdData = $thirdData['result'][0];

                foreach ($thirdData as $thirdDataKey => $thirdDataValue)
                {
                    $data = array();
                    $data['region_level'] = 3;
                    $data['parent_code'] = $secondDataValue['id'];
                    $data['region_order'] = $thirdDataKey+1;
                    // 必选
                    $data['region_code'] = $thirdDataValue['id'];
                    $data['region_name'] = $thirdDataValue['fullname'];
                    // 可选
                    if (array_key_exists('name', $thirdDataValue))
                    {
                        $data['region_shortname'] = $thirdDataValue['name'];
                    }
                    if (array_key_exists('pinyin', $thirdDataValue))
                    {
                        $data['region_name_en'] = implode(',' , $thirdDataValue['pinyin']);
                        $data['region_shortname_en'] = '';
                        foreach ($thirdDataValue['pinyin'] as $key => $value)
                        {
                            $data['region_shortname_en'] .= strtoupper(substr($value, 0, 1));
                        }
                    }
                    if (array_key_exists('location', $thirdDataValue))
                    {
                        $data['location_latitude'] = $thirdDataValue['location']['lat'];
                        $data['location_longitude'] = $thirdDataValue['location']['lng'];
                    }
                    $result = Db::name('region')->insert($data);

                    $count++;

                    //////////////////////////////////////////////
                    $param = '&id='.$thirdDataValue['id'];

                    $fourthData = '';
                    $fourthData = $this->curl_request($url.$param); usleep($time);
                    $fourthData = json_decode($fourthData,true);
                    if ( !array_key_exists('result',$fourthData) ) continue;
                    $fourthData = $fourthData['result'][0];

                    foreach ($fourthData as $fourthDataKey => $fourthDataValue)
                    {
                        $data = array();
                        $data['region_level'] = 4;
                        $data['parent_code'] = $thirdDataValue['id'];
                        $data['region_order'] = $fourthDataKey+1;
                        // 必选
                        $data['region_code'] = $fourthDataValue['id'];
                        $data['region_name'] = $fourthDataValue['fullname'];
                        // 可选
                        if (array_key_exists('name', $fourthDataValue))
                        {
                            $data['region_shortname'] = $fourthDataValue['name'];
                        }
                        if (array_key_exists('pinyin', $fourthDataValue))
                        {
                            $data['region_name_en'] = implode(',' , $fourthDataValue['pinyin']);
                            $data['region_shortname_en'] = '';
                            foreach ($fourthDataValue['pinyin'] as $key => $value)
                            {
                                $data['region_shortname_en'] .= strtoupper(substr($value, 0, 1));
                            }
                        }
                        if (array_key_exists('location', $fourthDataValue))
                        {
                            $data['location_latitude'] = $fourthDataValue['location']['lat'];
                            $data['location_longitude'] = $fourthDataValue['location']['lng'];
                        }

                        $find = Db::name('region')->where('region_code='.$fourthDataValue['id'])->find();
                        if (!$find)
                        {
                            $result = Db::name('region')->insert($data);
                        }

                    }
                }
            }
            echo 'count='.$count.'<br/>';
        }
    }

    public function curl_request($url, $post = '', $cookie = '', $returnCookie = 0)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if ($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie'] = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        } else {
            return $data;
        }
    }

	/**
     * @breif 首页
     **/
	public function index()
	{
        // 获取用户角色权限
      	$role_ids = session('manage_role_ids');
		$rules = AuthRoleModel::where('tid','in', $role_ids)->column('rules');
        $ruleTids = array();
        foreach ($rules as $key => $rule) 
        {
            $ruleTids = array_merge( $ruleTids , explode(',',$rule) );
        }
        $ruleTids = array_unique($ruleTids);
        $ruleTidsString = implode(',',$ruleTids);
		
		$filterMap 			= array();
		$filterMap['tid']	= ['in', $ruleTidsString];
		$filterMap['menu']	= 1;
		$filterMap['status']= 1;
		$filterMap['pid']	= 0;

		$menus = AuthRuleModel::field('tid,title,name,icon')->where($filterMap)->order('sort asc')->select();
		foreach ($menus as $key => $value) 
		{
			$filterMap['pid'] = $value['tid'];
			$menus[$key]['subs'] = AuthRuleModel::field('tid,title,name')->where($filterMap)->order('sort asc')->select();
		}

		$this->assign('menus',$menus);
		return view();
	}

	/**
     * @breif 欢迎页面
     **/
    public function welcome()
    {
        $userinfo = array(
            '<span class="label label-primary">用户信息</span>' => '',
            '用户角色' => session('manage_role_titles'),
            '用户昵称' => session('manage_account_name'),
            '用户性别' => session('manage_account_sex'),
            '用户生日' => session('manage_account_birthday')
        );

        // 系统信息
        if (input('session.manage_account_id')==1)
        {
          $systeminfo = array(
            '<span class="label label-primary">服务器信息</span>' => '',
            '管理系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO'
          );
        }
        else
        {
          	$systeminfo = array();
        }

        $infos = array_merge($userinfo, $systeminfo);
        $this->assign('infos',$infos);
        return view();
    }
}


?>