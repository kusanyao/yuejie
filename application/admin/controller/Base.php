<?php
namespace app\admin\controller;
use think\Session;
use think\Request;

class Base extends \think\Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->member = Session::get('admin');
		$controller = Request::instance()->controller();
		$action = Request::instance()->action();
		$isLogin = ($controller == 'Member' && $action == 'login');
		if(empty($this->member) && !$isLogin ){
			header("Location: /member/login"); 
		}elseif(!empty($this->member) && $isLogin){
			header("Location: /"); 
		}
	}

	protected function getPage($key='page')
	{
		$page = input('param.'.$key.'/d');
		return ($page > 0 ) ? $page : 1;
	}
	protected function getLimit($key='rows')
	{
		$limit = input('param.'.$key.'/d');
		return ($limit > 0 && $limit <= 50) ? $limit : 20;
	}
	protected function getOffset()
	{
		$limit = $this->getLimit();
		$page  = $this->getPage();
		return ($page - 1) * $limit;
	}
	protected function getIds($key='ids')
	{
		$ids = input('param.'.$key.'/s',[]);
		$idsArr = json_decode($ids,true);
		foreach ($idsArr as &$v) {
			$v = intval($v);
		}
		return $idsArr;
	}
	protected function getPageHtml($curr,$total,$rows,$num=5)
    {
    	if($total<=0){
    		return '';
    	}
        $pageArr[] = $minPage = $maxPage = $curr;
        $pageTotal = ceil($total/$rows);
        while (1) {
            $count = count($pageArr);
            if($count == $num || $count == $pageTotal){
                break;
            }
            $maxPage++;
            if($maxPage <= $pageTotal){
                $pageArr[] = $maxPage;
            }
            $minPage--;
            if($minPage >= 1){
                $pageArr[] = $minPage;
            }
        }
        sort($pageArr);
        parse_str($_SERVER['QUERY_STRING'],$queryArr);
        $html = '<ul class="pages">';
        foreach ($pageArr as $v) {
            $queryArr['page'] = $v;
            $url = $_SERVER['PATH_INFO'].'?'.http_build_query($queryArr);
            if($v == $curr){
                $html .= '<li class="curr"><a href="'.$url.'">'.$v.'</a></li>';
            }else{
                $html .= '<li><a href="'.$url.'">'.$v.'</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
