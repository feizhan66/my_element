    /**
     * 将array转换为XML格式的字符串
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public static function array2xml($data) {
        $xml = new \SimpleXMLElement('<xml/>');
        foreach($data as $k => $v ) {
            if (is_string($k) && (is_numeric($v) || is_string($v))) {
                $xml->addChild("$k",htmlspecialchars("$v"));
            }
            else {
                throw new \Exception('Invalid array, will not be converted to xml');
            }
        }
        return $xml->asXML();
    }

    /**
     * 将XML格式字符串转换为array
     * 参考： http://php.net/manual/zh/book.simplexml.php
     * @param string $str XML格式字符串
     * @return array
     * @throws \Exception
     */
    public static function xml2array($str) {
        $xml = simplexml_load_string($str, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $result = array();
        $bad_result = json_decode($json,TRUE);  // value，一个字段多次出现，结果中的value是数组
        // return $bad_result;
        foreach ($bad_result as $k => $v) {
            if (is_array($v)) {
                if (count($v) == 0) {
                    $result[$k] = '';
                }
                else if (count($v) == 1) {
                    $result[$k] = $v[0];
                }
                else {
	                $result[$k] = $v;
                }
            }
            else {
                $result[$k] = $v;
            }
        }
        return $result;
    }