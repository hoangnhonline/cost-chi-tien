<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Color;
use App\Models\LoaiThuocTinh;
use App\Models\ThuocTinh;
use App\Models\SpThuocTinh;
use App\Models\SpHinh;
use App\Models\MetaData;
use App\Models\Compare;
use App\Models\SpTuongThich;
use App\Models\SpMucDich;

use Goutte, Helper, File, Session, Auth, Hash, URL;
use App\Helpers\simple_html_dom;
class CompareController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */

    public function index(Request $request)
    {
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : 2;
        $tmpCate = Cate::where('loai_id', $loai_id)
            			->orderBy('display_order', 'desc')->first();
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : $tmpCate->id;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = SanPham::where('san_pham.loai_id', $loai_id);

        if( $cate_id ){
            $query->where('san_pham.cate_id', $cate_id);
        }       
        if( $name != ''){
            $query->where('san_pham.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }        
        $query->join('loai_sp', 'loai_sp.id', '=', 'san_pham.loai_id');
        $query->join('cate', 'cate.id', '=', 'san_pham.cate_id');        
        $query->orderBy('san_pham.id', 'desc');
        $items = $query->select('san_pham.*')
        ->paginate(50);   

        $loaiSpArr = LoaiSp::whereIn('id', [2])->get();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)
            			->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }
        return view('compare.index', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr'));
    }    
    public function search(Request $request){
        $name = $request->name;
        $site = $request->site;
        if($site == 'tiki'){        	
            $price = $this->crawlerTiki($name);
        }elseif($site == 'lazada'){
        	$price = $this->crawlerLazada($name);
        }elseif($site == 'adayroi'){
        	$price = $this->crawlerAdayroi($name);
        }
        return $price;
    }
    public function crawlerAdayroi($name){        
        set_time_limit(10000);
        $arr = [];
        $url = 'https://www.adayroi.com/tim-kiem?q='.urlencode($name);       
	    $crawler = Goutte::request('GET', $url);       
	    $name = strtolower($name);       
	    $crawler->filter('.col-lg-3.col-xs-4')->each(function ($node) use (&$arr, $name){                
	        if($node->filter('.out-of-stock')->count() == 0){
	        	$title = $price = '';                    
	            
	            if($node->filter('.post-title')->count() > 0){
	                $title = strtolower($node->filter('.post-title')->text());	            	
	            }
	            
	            $pos = (strpos($title, $name));
	            
	            if($pos !== false){            	
	            	if($node->filter('.amount-1')->count() > 0){
		                $price = $node->filter('.amount-1')->text();
		           		$arr[] = (int) $this->getPrice($price);	
		            }  	            	
	            }  	                          
	       } 
	       
	    });            
              
        $price = !empty($arr) ? min($arr) : 0;
    	
      	return $price;       
    }
    public function crawlerSendo($name){
        
        set_time_limit(10000);
         $url = 'https://www.sendo.vn/tim-kiem/?q='.urlencode($name);        
         $crawler = Goutte::request('GET', $url); 
         $arr = []; 
         $name = strtolower($name);         
         $crawler->filter('.product-card')->each(function ($node) use (&$arr, $name){
         	
            $title =  $price = '';           
            if($node->filter('div.product-card__name-wrap span')->count() > 0){
                $title = strtolower($node->filter('div.product-card__name-wrap span')->text());
            }
            $pos = (strpos($title, $name));
            if($pos !== false){            	
            	if($node->filter('div.product-card__price')->count() > 0){
		            $price = $node->filter('div.product-card__price')->text();		          
		            $arr[] = (int) $this->getPrice($price);	
		        }  
            }           
            
         }); 
       	$price = !empty($arr) ? min($arr) : 0;
    	
      	return $price;
    }
    public function crawlerLazada($name){
        
        set_time_limit(10000);
         $url = 'http://www.lazada.vn/catalog/?q='.urlencode($name);        
         $crawler = Goutte::request('GET', $url); 
         $arr = []; 
         $name = strtolower($name);         
         $crawler->filter('.product-card')->each(function ($node) use (&$arr, $name){
         	
            $title =  $price = '';           
            if($node->filter('div.product-card__name-wrap span')->count() > 0){
                $title = strtolower($node->filter('div.product-card__name-wrap span')->text());
            }
            $pos = (strpos($title, $name));
            if($pos !== false){            	
            	if($node->filter('div.product-card__price')->count() > 0){
		            $price = $node->filter('div.product-card__price')->text();		          
		            $arr[] = (int) $this->getPrice($price);	
		        }  
            }           
            
         }); 
       	$price = !empty($arr) ? min($arr) : 0;
    	
      	return $price;
    }
    public function crawlerTiki($name){      
        set_time_limit(10000);
        $url = 'https://tiki.vn/search?q='.urlencode($name);        
            
        $chs = curl_init();
        curl_setopt($chs, CURLOPT_URL, $url);
        curl_setopt($chs, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($chs, CURLOPT_HEADER, 0);
        $result = curl_exec($chs);       
        curl_close($chs);    
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);
       	$name = strtolower($name);
        foreach($crawler->find('div.product-item') as $node){
        	if($node->find('span.title', 0)){
             	$title = strtolower(trim($node->find('span.title', 0)->innertext));
            }
            $pos = (strpos($title, $name));
            if($pos !== false){
	            if($node->find('.price-sale', 0)){
	                $price_tmp = $node->find('.price-sale', 0)->innertext;
	                $tmpArr = explode('<span', $price_tmp);
	                $price = $tmpArr[0];                    
	            }
	            $arr[] = (int) $this->getPrice($price);
        	}
        };
        
	    $price = !empty($arr) ? min($arr) : 0;
    	
      	return $price;
    }
    public function getPrice($price){
    	$price = str_replace('VND', '', $price);
    	$price = str_replace(' đ', '', $price);
    	$price = str_replace('₫', '', $price);
    	$price = str_replace('  ', '', $price);
    	$price = str_replace(' ', '', $price);
		$price = str_replace(' ', '', $price);
    	$price = str_replace('.', '', $price);
    	return $price;
    }
}
