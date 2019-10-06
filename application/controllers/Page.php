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

  public function chk_passwd(){

    $passwd = $this->input->post('passwd');

    if($passwd =="1234"){
      
      $this->session->set_userdata('is_adm','Y');

      $json['code'] = 200;
      $json['massge'] = "확인되었습니다.";
    }else{
      $json['code'] = 500;
      $json['message'] = "비밀번호가 일치하지 않습니다." ;
    }
    
    echo json_encode($json);
  
  }
    
public function add_career(){

  $new_career = $this->input->post('new_career');
  if(strlen($new_career) <3){
    $json['code'] = 500;
    $json['message'] = "너무 짧게 입력하셨습니다.";
  }else{

    $new_step = $this->db->select(' max(step)+1 as step ') -> get('careers') ->row_array()[step];
    if(!$new_step) $new_step = 1;

    $in_data['content'] = $new_career;
    $in_data['step'] = $new_step;
    $in_data['updated'] = date("Y-m-d H:i:s");
    $in_data['created'] = date("Y-m-d H:i:s");

    if($this->db->insert('careers',$in_data)){
      $json['code'] = 200;
      $json['result'] = $in_data;
    }else{
      $json['code'] = 500;
      $json['massage'] = 'DB 입력에 실패하였습니다.';
    }
  }

  echo json_encode($json);
  
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