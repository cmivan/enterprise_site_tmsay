<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_into_pic_2 extends HT_Controller {
	
	public $rootpath = '/public/up/uploads/20120928/'; //$rootpath = '/public/up/uploads/20120813/';
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->helper('directory');
		$this->load->helper('file');
		$this->load->model('Products_Model');
		
	}
	
	function retype(){
		
	}
	
	
	
	/* 分类目录/系列目录[/产品目录]/具体产品 */
	function into()
	{
		$this->rootpath = '/public/up/uploads/20121007/';
		$path  = $this->rootpath . 'view/';
		$pathB = $this->rootpath . 'big/';
		$pathS = $this->rootpath . 'small/';
		
		$map = directory_map('.'.$path, FALSE, FALSE);
		foreach($map as $dir => $val)
		{
			$dir = mb_convert_encoding($dir, "UTF-8", "GB2312");
			
			//判断目录是否已经匹配规则
			$get_style_id = $rs = $this->Products_Model->get_style_title_id($dir);
			if(is_numeric($get_style_id)&&$get_style_id!=0)
			{
				$styles_id = $get_style_id;
				
				$xxx = $this->reIconv('.' . $path . $dir);
				$xx2 = $this->reIconv('.' . $path . $styles_id);
				
				if(is_numeric($dir)==false)
				{
					//修改文件夹
					$this->rePath($xxx,$xx2);
					$this->out('已将目录：' . iconv("GB2312","utf-8",$xxx));
					$this->out('修改成为：' . $xx2);
				}else{
					$xx2 = $xxx;
					$this->out('该目录不需要修改：' . $xxx);
				}
				$this->out('');
			}
			else
			{
				$this->out('未找到分类目录!');exit;
			}
			

			//在风格目录下列出 产品类型
			foreach($val as $filekey => $file)
			{
				if($file!='Thumbs.db')
				{
					$da = array();
					$da['styles_id'] = $styles_id;
					
					//大类---------------------------
					$filekey = iconv("GB2312","utf-8",$filekey);
					//大类ID
					$da['typeB_id'] = $this->getTypeB_Id($filekey);
					if(is_numeric( $da['typeB_id'] ) && $da['typeB_id']!=0)
					{
						$this->out('<strong>发现大类:' . $filekey . '('.$da['typeB_id'].')</strong>');
						//修改大类文件夹
						$typeBpath = $this->reIconv($xx2 . '/' . $filekey);
						$typeBpathTo = $this->reIconv($xx2 . '/' . $da['typeB_id']);
						$this->rePath($typeBpath,$typeBpathTo);
						
						//小类 --------------------------
						if(is_array($file))
						{
							foreach($file as $valkey => $fileval)
							{
								if(is_array($fileval))
								{
									$valkey = iconv("GB2312","utf-8",$valkey);
									//小类ID
									$da['typeS_id'] = $this->getTypeB_Id($valkey, $da['typeB_id'] );
									$this->out('&nbsp;&nbsp;&nbsp;&nbsp;<em>小类:- ' . $valkey . '('.$da['typeS_id'].')</em>');
									//修改小类文件夹
									$typeSpath = $this->reIconv($typeBpathTo . '/' . $valkey);
									$typeSpathTo = $this->reIconv($typeBpathTo . '/' . $da['typeS_id']);
									$this->rePath($typeSpath,$typeSpathTo);
		
									//读取具体的文件
									foreach($fileval as $itemkey => $item)
									{
										if(is_array($item))
										{
											//********{发现目录}********
											
											//产品名称
											$da['title'] = $itemkey;
											$da['content'] = '';
											if(!empty($item))
											{
												//具体到图片
												foreach($item as $filevalkey => $filename)
												{
													if($filename!='Thumbs.db')
													{
														$filePath = $typeSpathTo . '/' . $itemkey . '/';
														$filePath = str_replace('./','/',$filePath);

														$fname= mb_convert_encoding($filename, "UTF-8", "GB2312");
														$farr = explode('.',$fname);
														if(is_array($farr)&&count($farr)==3)
														{
															//修改图片名称避免中文(view)
															$filePath0 = $filePath . $filename;
															$filePath2 = $filePath . md5($farr[0] . "." . $farr[1]) . '.jpg';
															//rename('.'."$filePath0",'.'."$filePath2");
															$this->rePath('.'."$filePath0",'.'."$filePath2");
														}
														else
														{
															$filePath2 = $filePath . $filename;
														}
														$da['content'].= '<img src="'.$filePath2.'" /><br>';
														$da['filePath']= $filePath2;	
													}
												}
												
												$this->insertProduct($da);
											}
										}
										else
										{
											//********{发现图片文件}********
											if($item!='Thumbs.db')
											{
												$filePath = $typeSpathTo . '/';
												$filePath = str_replace('./','/',$filePath);

												$fname= mb_convert_encoding($item, "UTF-8", "GB2312");
												$farr = explode('.',$fname);
												if(is_array($farr)&&count($farr)==3)
												{
													$ftitle = $farr[0] . "." . $farr[1];
													$da['title'] = $ftitle;
													//修改图片名称避免中文(view)
													$filePath0 = $filePath . $item;
													$filePath2 = $filePath . md5($ftitle) . '.jpg';
													//rename('.'."$filePath0",'.'."$filePath2");
													$this->rePath('.'."$filePath0",'.'."$filePath2");
													
													$da['content'] = '<img src="'.$filePath2.'" /><br>';
													$da['filePath']= $filePath2;
													
													$this->insertProduct($da);
												}
											}
										}
										
										//print_r($da);
										//exit;
									}
								}
							}
						}
					}
				}
			}
		}
		exit;
	}
	


	
	

	/*录入场景*/
	function into_screen()
	{
		$path = '/public/up/uploads/20120929/';
		$map = directory_map('.'.$path, FALSE, FALSE);
		foreach($map as $dir => $val)
		{
			$dir = mb_convert_encoding($dir, "UTF-8", "GB2312");
			$da = array();
			$da['title'] = '朴风堂产品实景-' . $dir;
			$da['filePath'] = $path . $dir . '/small.jpg';
			$da['content'] = '';

			foreach($val['view'] as $filekey => $file)
			{
				if($file!='Thumbs.db')
				{
					$fileImg = $path . $dir . '/view/' . $file;
					$da['content'].= '<img src="'.$fileImg.'" /><br/>';
				}
			}
			$this->insertScreen($da);
		}
		exit;
	}
	
	
	
	
	
	
	
	
	
	
	
	/*--临时--*/
	function repic(){
		
		$this->db->select('id,title');
		$this->db->from('products');
		$row = $this->db->get()->result();
		foreach($row as $rs){
			$id = $rs->id;
			$title = $rs->title;
			preg_match_all('/(\d+)X(\d+)X(\d+)/i',$title,$mh);
			if(!empty($mh[0])){
				//存入数据库
				$da['size_z'] = $mh[1][0];
				$da['size_w'] = $mh[2][0];
				$da['size_h'] = $mh[3][0];
				$this->db->where('id',$id);
				$this->db->update('products',$da);
				print_r($da);
			}
		}
		//print_r($row);
		exit;
	}
	

	
	
	//录入产品
	function insertProduct($data='')
	{
		if(!empty($data))
		{
			$typeB_id  = (int)$data['typeB_id'];
			$typeS_id  = (int)$data['typeS_id'];
			$styles_id = (int)$data['styles_id'];
			$title     = (string)$data['title'];
			$content   = $data['content'];
			$filePath  = $data['filePath'];
			
			$this->db->select('id,title');
			$this->db->from('products');
			$whereON[] = array('typeB_id'=>$typeB_id,'typeS_id'=>$typeS_id,'styles_id'=>$styles_id);
			$this->db->where_on($whereON);
			$whereOR[] = array('title'=>$title);
			$whereOR[] = array('titleMD5'=>$title);
			$this->db->where_on($whereOR);
			//$this->db->where('typeB_id',$typeB_id);
			//$this->db->where('typeS_id',$typeS_id);
			//$this->db->where('styles_id',$styles_id);
			//$this->db->where('title',$title);
			//$this->db->or_where('titleMD5',$title);
			$this->db->limit(1);
			$item = $this->db->get()->row();
			if(empty($item))
			{
				$rs = array(
				  'title' => $title,
				  'titleMD5' => md5($title),
				  'pro_no' => '',
				  'size_z' => 0,
				  'size_w' => 0,
				  'size_h' => 0,
				  'price' => 0,
				  'price_vip' => 0,
				  'note' => $title,
				  'content' => $content,
				  'pic_b' => str_replace('view','big',$filePath),
				  'pic_s' => str_replace('view','small',$filePath),
				  'typeB_id' => $typeB_id,
				  'typeS_id' => $typeS_id,
				  'styles_id'=> $styles_id,
				  'add_ip' => ip(),
				  'hits' => 0,
				  'order_id' => 0
				);
				$this->db->insert('products',$rs);
				$this->out('----< 添加 >----');
			}else{
				$itemID = $item->id;
				$rs = array(
					  'content' => $content,
					  'pic_b' => str_replace('view','big',$filePath),
					  'pic_s' => str_replace('view','small',$filePath),
					  'typeB_id' => $typeB_id,
					  'typeS_id' => $typeS_id,
					  'styles_id'=> $styles_id
					  );
				$this->db->where('id',$itemID);
				$this->db->update('products',$rs);
				$this->out('----< 更新 >----');
			}
			//print_r($rs);
			$this->out('<hr>');
		}else{
			$this->out('数据不符合~~~');
		}
	}
	
	
	
	
	//录入场景
	function insertScreen($data='')
	{
		if(!empty($data))
		{
			$typeB_id = 0;
			$typeS_id = 0;
			
			$title    = $data['title'];
			$content  = $data['content'];
			$filePath = $data['filePath'];
			
			$this->db->select('id,title');
			$this->db->from('products_real');
			$this->db->where('typeB_id',$typeB_id);
			$this->db->where('typeS_id',$typeS_id);
			$this->db->where('title',$title);
			$this->db->limit(1);
			$item = $this->db->get()->row();
			if(empty($item))
			{
				$rs = array(
				  'title' => $title,
				  'note' => '',
				  'content' => $content,
				  'pic_b' => str_replace('view','big',$filePath),
				  'pic_s' => str_replace('view','small',$filePath),
				  'typeB_id' => 0,
				  'typeS_id' => 0,
				  'add_time' => dateTime(),
				  'add_ip' => ip(),
				  'hits' => 0,
				  'order_id' => 0,
				  'new' => 0,
				  'ok' => 0,
				  'hot' => 0
				);
				
				$this->db->insert('products_real',$rs);
				$this->out('----< 添加 >----');
			}else{
				$itemID = $item->id;
				$rs = array(
					  'content' => $content,
					  'note' => '',
					  'pic_b' => str_replace('view','big',$filePath),
					  'pic_s' => str_replace('view','small',$filePath),
					  'typeB_id' => 0,
					  'typeS_id' => 0
					  );
				$this->db->where('id',$itemID);
				$this->db->update('products_real',$rs);
				$this->out('----< 更新 >----');
			}
			//print_r($rs);
			$this->out('<hr>');
		}else{
			$this->out('数据不符合~~~');
		}
	}
	
	
	
	
	
	//修改目录
	function reIconv($path='')
	{
		return iconv("utf-8","gb2312",$path);
	}
	function rePath($path='',$path2='')
	{
		rename("$path","$path2");
		//--------------------
		$pathS = str_replace('view','small',$path);
		$pathS2 = str_replace('view','small',$path2);
		rename("$pathS","$pathS2");
		//--------------------
		$pathB = str_replace('view','big',$path);
		$pathB2 = str_replace('view','big',$path2);
		rename("$pathB","$pathB2");
	}
	
	
	
	
	//输出
	function out($str='')
	{
		echo $str . '<br/>';
	}
	
	
	//产品一级分类
	function getTypeB_Id($title='',$ids=0)
	{
		$type_id = 0;
		if(is_numeric($title)&&$title!=''&&$title!=0)
		{
			return $title;
		}else{
			$rs = $this->Products_Model->get_type_by_title($title,$ids);
			if(empty($rs))
			{
				$this->db->set('type_ids',$ids);
				$this->db->set('type_title',$title);
				$this->db->insert('products_type');
			}else{
				$type_id = $rs->type_id;
			}
			return $type_id;
		}
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */