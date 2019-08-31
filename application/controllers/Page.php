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

    $this->data['menus'] = array(
      array('title'=>'프로필' ,'page_id'=>'profile'),
      array('title'=>'프로젝트', 'page_id'=>'project'),
      array('title'=>'디자이너', 'page_id'=>'designer'),
      array('title'=>'아트웍', 'page_id'=>'art-work'),
      array('title'=>'문의하기', 'page_id'=>'pna'),
    );
  }

  public function index($page_id='main')
  {
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

}


/* End of file Page.php */
/* Location: ./application/controllers/Page.php */