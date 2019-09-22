<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Page
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Page extends CI_Controller
{
  var $date = array();  


  public function __construct()
  {
    parent::__construct();

    // $this->data['menus'] = array(
    //   array('title'=>'프로필' ,'page_id'=>'profile'),
    //   array('title'=>'프로젝트', 'page_id'=>'project'),
    //   array('title'=>'디자이너', 'page_id'=>'designer'),
    //   array('title'=>'아트웍', 'page_id'=>'art-work'),
    //   array('title'=>'문의하기', 'page_id'=>'pna'),
    // );

    $this->data['menus'] = $this->db->get('menus')->result_array();
  }

  public function index($page_id='main')
  {
    if($page_id){
      $is_page = $this->db->where('page_id',$page_id)->get('menus')->row_array();

      if($page_id){

        $this->data['page_tilte'] = $is_page['title'];

        $this->db->set('view_cnt', $is_page['view_cnt']+1)->where('page_id',$page_id)->update('menus');
    
      }
    }


    $html = $this->load->view('layout.html',$this->data,true); // 레이아웃 내용 담기
    $header_html = $this->load->view('layout_header.html',$this->data,true); // 헤더 내용 담기
    $main_html = $this->load->view('main.html',$this->data,true); // 메인 내용 담기
    $footer_html = $this->load->view('footer.html',$this->data,true); // 메인 내용 담기
    $main_html = $this->load->view($page_id.'.html',$this->data,true); // 메인 내용 담기


    $html = str_replace("{#HEADER}",$header_html,$html); 
    $html = str_replace("{#CONTENT}",$main_html,$html); 
    $html = str_replace("{#FOOTER}",$footer_html,$html); 
    echo $html;
  }

public function data_json($mode=''){
  if($mode == 'careers'){
    $json['code'] = 200;
    $json['result']['careers'] = $this->db->order_by('step','asc')->get('careers')->result_array();

    echo json_encode($json);
    exit;
  }
}



}


/* End of file Page.php */
/* Location: ./application/controllers/Page.php */