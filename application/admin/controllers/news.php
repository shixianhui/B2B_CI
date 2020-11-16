<?php
class News extends CI_Controller {
	private $_title = '新闻管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//模型名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table' => $this->_table, 'parent_title' => '网站管理', 'title' => '新闻'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
    	$this->load->helper(array('url', 'my_fileoperate', 'file'));
	}

	public function index($clear = 0, $page = 0) {
	    checkPermission("{$this->_table}_index");
	    clearSession(array('search'));
	    if ($clear) {
	    	$clear = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;

		if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";
			$title = $this->input->post('title');
			$category_id = $this->input->post('select_category_id');
			$display = $this->input->post('display');
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if (! empty($category_id) ) {
		        $strWhere .= " and {$this->_table}.category_id = {$category_id} ";
		    }
		    if (! empty($title) ) {
		        $strWhere .= " and {$this->_table}.title REGEXP '{$title}'";
		    }
		    if ($display != "") {
		        $strWhere .= " and {$this->_table}.display = {$display} ";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime." 23:59:59")." ";
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$menu_list = $this->Menu_model->menuTree('id, menu_name', $this->_table);
		$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		foreach ($item_list as $key=>$value) {
		    $item_list[$key]['title'] = $value['title'].'&nbsp;&nbsp;'.$this->tableObject->attribute($value['custom_attribute']);
		}

		$data = array(
		        'tool'      =>$this->_tool,
				'clear'=>     $clear,
				'item_list'  =>$item_list,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table,
		        'menu_list'=>$menu_list
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
	    if ($id) {
	        checkPermission("{$this->_table}_edit");
	    } else {
	        checkPermission("{$this->_table}_add");
	    }
		$prfUrl = $this->session->userdata($this->_table.'RefUrl')?$this->session->userdata($this->_table.'RefUrl'):base_url()."admincp.php/{$this->_table}/index/1";
		if ($_POST) {
			$custom_attribute = $this->input->post('custom_attribute', TRUE);
			if (! empty($custom_attribute)) {
			    $custom_attribute = implode($custom_attribute, ',');
			} else {
				$custom_attribute = '';
			}

			$fields = array(
			          'category_id'=>     $this->input->post('category_id', TRUE),
			          'title'=>           $this->input->post('title', TRUE),
			          'seo_title'=>       $this->input->post('seo_title', TRUE),
			          'title_color'=>     $this->input->post('title_color', TRUE),
			          'custom_attribute'=>$custom_attribute,
			          'author'=>          $this->input->post('author', TRUE),
			          'source'=>          $this->input->post('source', TRUE),
			          'relation'=>        $this->input->post('relation', TRUE),
			          'keyword'=>         $this->input->post('keyword', TRUE),
			          'abstract'=>        $this->input->post('abstract', TRUE),
			          'content'=>         unhtml($this->input->post('content')),
			          'hits'=>            $this->input->post('hits', TRUE),
			          'add_time'=>        strtotime($this->input->post('add_time', TRUE)),
			          'path'=>            $this->input->post('path', TRUE)
			          );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));
		$menu_list = $this->Menu_model->menuTree('id, menu_name', $this->_table);

		$data = array(
		        'tool'=>$this->_tool,
		        'menu_list'=>$menu_list,
		        'table'=>$this->_table,
		        'item_info'=>$item_info,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

	public function getKeycode() {
		$this->load->library('Splitwordclass');
		$title = $this->input->post('title', TRUE);
		if ($title) {
			$splitword = new Splitwordclass();
			$keycode = $splitword->SplitRMM(iconv("UTF-8", "gbk", $title));
			$splitword->Clear();
			$keycode = iconv("gbk","UTF-8", $keycode);
			printAjaxData(array('keycode'=>$keycode));
		}
	}

	public function sort() {
	    checkPermissionAjax("{$this->_table}_edit");
	    if ($_POST) {
			$ids = $this->input->post('ids', TRUE);
			$sorts = $this->input->post('sorts', TRUE);

			if (! empty($ids)) {
				$ids = explode(',', $ids);
				$sorts = explode(',', $sorts);

				foreach ($ids as $key=>$value) {
					$this->tableObject->save(
					                   array('sort'=>$sorts[$key]),
					                   array('id'=>$value));
				}
				printAjaxSuccess('success', '排序成功！');
			}

			printAjaxError('fail', '排序失败！');
	    }
	}

	public function category() {
		checkPermissionAjax("{$this->_table}_edit");
		if ($_POST) {

			$ids = $this->input->post('ids', TRUE);
			$category_id = $this->input->post('categoryId', TRUE);

			if (! empty($ids) && ! empty($category_id)) {
				if($this->tableObject->save(array('category_id'=>$category_id), 'id in ('.$ids.')')) {
					printAjaxSuccess('success', '修改栏目成功！');
				}
			}

			printAjaxError('fail', '修改栏目失败！');
		}
	}

    public function display() {
        checkPermissionAjax("{$this->_table}_edit");
        if ($_POST) {
        	$ids = $this->input->post('ids');
        	$display = $this->input->post('display');

        	if (! empty($ids) && $display != "") {
        		if($this->tableObject->save(array('display'=>$display), 'id in ('.$ids.')')) {
        			printAjaxSuccess('success', '修改状态成功！');
        		}
        	}

        	printAjaxError('fail', '修改状态失败！');
        }
	}

    public function attribute() {
        checkPermissionAjax("{$this->_table}_edit");
        if ($_POST) {
        	$ids = $this->input->post('ids', TRUE);
        	$customAttribute = $this->input->post('custom_attribute', TRUE);

        	if (! empty($ids) && ! empty($customAttribute)) {
        		if ($customAttribute == 'clear'){
        			$customAttribute = '';
        		}
        		if($this->tableObject->save(array('custom_attribute'=>$customAttribute), 'id in ('.$ids.')')) {
        			printAjaxSuccess('success', '属性修改成功！');
        		}
        	}

        	printAjaxError('fail', '属性修改失败！');
        }
	}

    public function delete() {
        checkPermissionAjax("{$this->_table}_delete");
        if ($_POST) {
        	$ids = $this->input->post('ids', TRUE);

        	if (! empty($ids)) {
        		$itemList = $this->tableObject->gets($this->_table.".id in ($ids)");
        		foreach ($itemList as $key=>$value) {
        			$filePath = "./{$value['html_path']}/{$value['id']}.html";
        			if (file_exists($filePath)) {
        				@unlink($filePath);
        			}
        		}
        		if ($this->tableObject->delete('id in ('.$ids.')')) {
        			printAjaxData(array('ids'=>explode(',', $ids)));
        		}
        	}

        	printAjaxError('fail', '删除失败！');
        }
	}

    public function html($page = 0) {
        checkPermission("{$this->_table}_html");

	    if (! $this->uri->segment(2)) {
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;

		if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";
			$title = $this->input->post('title');
			$category_id = $this->input->post('select_category_id');
			$display = $this->input->post('display');
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if (! empty($category_id) ) {
		        $strWhere .= " and {$this->_table}.category_id = {$category_id} ";
		    }
		    if (! empty($title) ) {
		        $strWhere .= " and {$this->_table}.title like '%".$title."%'";
		    }
		    if ($display != "") {
		        $strWhere .= " and {$this->_table}.display={$display} ";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime." 23:59:59")." ";
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/html/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 3;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$menuList = $this->Menu_model->menuTree('id, menu_name', $this->_table);
		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		foreach ($itemList as $key=>$value) {
			if (file_exists("./".$value['html_path']."/{$value['id']}.html")) {
				$itemList[$key]['display'] = 1;
			} else {
			    $itemList[$key]['display'] = 0;
			}
		}

		$data = array(
		        'tool'      =>$this->_tool,
				'itemList'  =>$itemList,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table,
		        'menuList'=>$menuList
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/html', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

    public function htmlUpdate() {
        checkPermissionAjax("{$this->_table}_htmlUpdate");

        $systemInfo = $this->System_model->get('*', array('id'=>1));
		if ($systemInfo['html'] == 0) {
			printAjaxError('fail', '请到"系统设置 > 基本设置"开启静态！');
		}
	    $ids = $this->input->post('ids', TRUE);
	    if (! empty($ids)) {
	    	$itemList = $this->tableObject->gets($this->_table.".id in ($ids)");
	        foreach ($itemList as $key=>$value) {
	            if ($systemInfo['client_index']) {
			    	$url = base_url()."{$systemInfo['client_index']}/{$value['table']}/detail/{$value['id']}";
			    } else {
			    	$url = base_url()."{$systemInfo['client_index']}{$value['table']}/detail/{$value['id']}";
			    }
			    $content = file_get_contents ($url);
			    //在这里要对页面内容进入过滤
			    $filePath = "./{$value['html_path']}/";
		        createDirs($filePath);
				@write_file($filePath."/{$value['id']}.html", $content);
	        }
	    }
	    printAjaxSuccess('', '更新成功！');
	}

    public function htmlDelete() {
        checkPermissionAjax("{$this->_table}_htmlDelete");
        if ($_POST) {
        	$ids = $this->input->post('ids', TRUE);
        	if (! empty($ids)) {
        		$itemList = $this->tableObject->gets($this->_table.".id in ($ids)");
        		foreach ($itemList as $key=>$value) {
        			$filePath = "./{$value['html_path']}/{$value['id']}.html";
        			if (file_exists($filePath)) {
        				@unlink($filePath);
        			}
        		}
        	}
        	printAjaxSuccess('', '删除成功！');
        }
	}
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */