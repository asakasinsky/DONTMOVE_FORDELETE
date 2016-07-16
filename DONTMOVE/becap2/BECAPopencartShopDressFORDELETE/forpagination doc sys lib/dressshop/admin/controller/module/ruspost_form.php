<?php
define('FPDF_FONTPATH', DIR_SYSTEM . 'ufpdf/font/');
define('FPDF_LIBPATH', DIR_SYSTEM . 'ufpdf/');

class ControllerModuleRuspostForm extends Controller {
    private $error = array();

    protected function getFormData() {
        $vals_array = $this->session->data['ufpdf_post_form'];
        foreach ($vals_array as $key => $value) {
            $vals_array[$key] = html_entity_decode(stripslashes($value));
            $vals_array[$key] = str_replace('Р', 'P', $vals_array[$key]);
        }
        if(!empty($vals_array['addr_sum'])) {
            $vals_array['addr_sum'] =  $vals_array['addr_sum'] - (int)  $vals_array['addr_sum'] > 0 ?  number_format($vals_array['addr_sum'], 2, '.') : (int) $vals_array['addr_sum'];
        }
        return $vals_array;
    }

    public function pdfopis() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.opis.php');

        $this->load->model('sale/order');
        $products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

        $doc = new PDF_Opis('P', 'mm', 'A5');
        $doc->Open();

        $doc->PrintFirstPage('Post sticker blank');
        $vals_array = $this->getFormData();
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address'], $vals_array['addr_index']);

        $total = 0;
        $total_num = 0;
        foreach ($products as $product) {
            $total += $product['total'];
            $total_num += $product['quantity'];
        }
        $doc->PrintProducts($products);

        $doc->PrintNumSum($total, $total_num);
        $doc->Output('f107-opis.pdf', 'D');
    }

    public function pdfsticker() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.sticker.php');

        $vals_array = $this->getFormData();

        $doc = new PDF_Blank('L', 'mm', 'A4');
        $doc->Open();

        $doc->PrintFirstPage('Post sticker blank');
        $doc->PrintAddrIndex($vals_array['addr_index']);
        $doc->PrintSenderIndex($vals_array['sender_index']);
        $doc->PrintStrSum($vals_array['addr_sum']);
        $doc->PrintStrNalozh($vals_array['addr_nalozh']);
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address']);

        $doc->PrintSenderName($vals_array['sender_name']);
        $doc->PrintSenderAddress($vals_array['sender_address']);
        $doc->Output('f7-sticker.pdf', 'D');
    }

    //Ф.113+117
    public function pdfform() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.blank.php');

        $vals_array = $this->getFormData();

        $vals_array['sender_RS'] = '';
        $vals_array['sender_bank'] = '';
        $vals_array['sender_bank_city'] = '';
        $vals_array['sender_bank_address'] = '';
        $vals_array['sender_bank_kor'] = '';
        $vals_array['sender_bank_bik'] = '';
        $vals_array['sender_bank_inn'] = '';

        $doc = new PDF_Blank('L', 'mm', 'A4');
        $doc->Open();

        $doc->PrintFirstPage('Post payment blank');
        $doc->PrintAddrIndex($vals_array['addr_index']); // индекс получателя
        $doc->PrintSenderIndex($vals_array['sender_index']); // индекс отправителя
        $doc->PrintNumSum($vals_array['addr_sum']);
        $doc->PrintNumNalozh($vals_array['addr_nalozh']);
        $doc->PrintStrSum($vals_array['addr_sum']);
        $doc->PrintStrNalozh($vals_array['addr_nalozh']);
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address'], $vals_array['addr_index']);

        if (isset($vals_array['sender_jurfiz']) && $vals_array['sender_jurfiz']) {
            $doc->PrintSenderNameAddress($vals_array['sender_name'], $vals_array['sender_index'], $vals_array['sender_address']);
            //$doc->PrintSenderBank($vals_array['sender_rs'],$vals_array['sender_bank'],$vals_array['sender_bank_city'],$vals_array['sender_bank_address'],$vals_array['sender_korr'],$vals_array['sender_bik'],$vals_array['sender_inn']);
        } else {
            $doc->PrintSenderNameAddress($vals_array['sender_name'], $vals_array['sender_index'], $vals_array['sender_address']);
            $doc->PrindDocument($vals_array['sender_document_doc'], $vals_array['sender_document_ser'],
                $vals_array['sender_document_nomer'], $vals_array['sender_document_vydan'],
                $vals_array['sender_document_vydanday'], $vals_array['sender_document_vydanyear']);
        }
        $doc->PrintSenderBank('', $vals_array['sender_address'], '', '', '', '', '');

        $doc->PrintSecondPage();
        $doc->PrintNumNalozh2nd($vals_array['addr_nalozh']);
        $doc->PrintAddrName2nd($vals_array['addr_name']);
        // выводим адрес отправителя, для адресата -  $vals_array['addr_address'] и $vals_array['addr_index']
        $doc->PrintAddrAddress2nd($vals_array['addr_address'], $vals_array['addr_index']);
        //Выводим документ в браузер
        $doc->Output('f113_f117.pdf', 'D');
        set_error_handler('error_handler');
    }

    public function f112ep() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.f112ep.php');

        $vals_array = $this->getFormData();

        $doc = new PDF_F112ep('L', 'mm', 'A4');
        $doc->Open();

        $doc->PrintFirstPage('Post payment blank');
        $doc->PrintAddrIndex($vals_array['addr_index']); // индекс получателя
        $doc->PrintSenderIndex($vals_array['sender_index']); // индекс отправителя
        $doc->PrintAddrPhone($vals_array['addr_phone']);
        $doc->PrintSenderPhone($vals_array['sender_phone']);
        $doc->PrintNumNalozh($vals_array['addr_nalozh']);
        $doc->PrintStrNalozh($vals_array['addr_nalozh']);
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address'], $vals_array['addr_index']);

        $doc->PrintSenderNameAddress($vals_array['sender_name'], $vals_array['sender_index'], $vals_array['sender_address']);
        if (isset($vals_array['sender_jurfiz']) && $vals_array['sender_jurfiz']) {
            $doc->PrintSenderBank($vals_array['sender_inn'], $vals_array['sender_bank'],
                $vals_array['sender_korr'], $vals_array['sender_rs'], $vals_array['sender_bik']);
        } else {
            $doc->PrindDocument($vals_array['sender_document_doc'], $vals_array['sender_document_ser'],
                $vals_array['sender_document_nomer'], $vals_array['sender_document_vydan'],
                $vals_array['sender_document_vydanday'], $vals_array['sender_document_vydanyear']);
        }

        //Выводим документ в браузер
        $doc->Output('f112ep.pdf', 'D');
        set_error_handler('error_handler');
    }

    public function f112ek() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.f112ek.php');

        $vals_array = $this->getFormData();

        $doc = new PDF_F112ek('L', 'mm', 'A4');
        $doc->Open();

        $doc->PrintFirstPage('Post payment blank');
        $doc->PrintNumNalozh($vals_array['addr_nalozh']);
        $doc->PrintSenderPhone($vals_array['sender_phone']);
        $doc->PrintSenderName($vals_array['sender_name']);
        $doc->PrintSenderAddress($vals_array['sender_index'], $vals_array['sender_address']);
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address']);
        $doc->PrintAddrIndex($vals_array['addr_index']); // индекс покупателя
        $doc->PrintStrNalozh($vals_array['addr_nalozh']);

        $doc->Output('f112ek.pdf', 'D');
        set_error_handler('error_handler');
    }

    public function f113() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.f113.php');

        $vals_array = $this->getFormData();

        $doc = new PDF_F113('L', 'mm', 'A4');
        $doc->Open();

        $doc->PrintFirstPage('Post payment blank');
        $doc->PrintAddrIndex($vals_array['addr_index']); // индекс получателя
        $doc->PrintSenderIndex($vals_array['sender_index']); // индекс отправителя
        $doc->PrintNumNalozh($vals_array['addr_nalozh']);
        $doc->PrintStrNalozh($vals_array['addr_nalozh']);
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address'], $vals_array['addr_index']);

        if (isset($vals_array['sender_jurfiz']) && $vals_array['sender_jurfiz']) {
            $doc->PrintSenderNameAddress($vals_array['sender_name'], $vals_array['sender_index'], $vals_array['sender_address']);
            $doc->PrintSenderBank($vals_array['sender_inn'], $vals_array['sender_bank'], $vals_array['sender_korr'], $vals_array['sender_rs'], $vals_array['sender_bik']);
        } else {
            $doc->PrintSenderNameAddress($vals_array['sender_name'], $vals_array['sender_index'], $vals_array['sender_address']);
            $doc->PrindDocument($vals_array['sender_document_doc'], $vals_array['sender_document_ser'],
                $vals_array['sender_document_nomer'], $vals_array['sender_document_vydan'],
                $vals_array['sender_document_vydanday'], $vals_array['sender_document_vydanyear']);
        }

        $doc->PrintSecondPage();
        $doc->PrintNumNalozh2nd($vals_array['addr_nalozh']);
        $doc->PrintAddrName2nd($vals_array['addr_name']);
        // выводим адрес отправителя, для адресата -  $vals_array['addr_address'] и $vals_array['addr_index']
        $doc->PrintAddrAddress2nd($vals_array['addr_address'], $vals_array['addr_index']);
        //Выводим документ в браузер
        $doc->Output('f113en.pdf', 'D');
        set_error_handler('error_handler');
    }

    public function f116() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.f116.php');

        $vals_array = $this->getFormData();

        $doc = new PDF_F116('P', 'mm', 'A5');
        $doc->Open();

        $doc->PrintFirstPage('Post payment blank');
        $doc->PrintAddrIndex($vals_array['addr_index']); // индекс получателя
        $doc->PrintSenderIndex($vals_array['sender_index']); // индекс отправителя
        $doc->PrintNumSum($vals_array['addr_sum']);
        $doc->PrintNumNalozh($vals_array['addr_nalozh']);
        $doc->PrintStrSum($vals_array['addr_sum']);
        $doc->PrintStrNalozh($vals_array['addr_nalozh']);
        $doc->PrintAddrName($vals_array['addr_name']);
        $doc->PrintAddrAddress($vals_array['addr_address'], $vals_array['addr_index']);

        $doc->PrintSenderNameAddress($vals_array['sender_name'], $vals_array['sender_index'], $vals_array['sender_address']);
        if (isset($vals_array['sender_jurfiz']) && $vals_array['sender_jurfiz']) {
        } else {
            $doc->PrintDocument($vals_array['sender_document_doc'], $vals_array['sender_document_ser'],
                $vals_array['sender_document_nomer'], $vals_array['sender_document_vydan'],
                $vals_array['sender_document_vydanday'], $vals_array['sender_document_vydanyear']);
        }

        $doc->PrintSecondPage();
        //Выводим документ в браузер
        $doc->Output('f116.pdf', 'D');
        set_error_handler('error_handler');
    }

    public function pdfcustom() {
        restore_error_handler();
        error_reporting(E_ALL ^ E_NOTICE);
        require(FPDF_LIBPATH . 'fpdf.php');
        require(FPDF_LIBPATH . 'fpdf.class.custom.php');

        $vals_array = $this->getFormData();


        $doc = new PDF_Custom('L', 'mm', 'A4');
        $doc->Open();

        $doc->PrintFirstPage('Post sticker blank');

        $left_column = "\r\n". $doc->wordToLines('Кому: '. $vals_array['addr_name'], 45)."\r\n\r\n";
        $left_column .= $doc->wordToLines("Куда: ". $vals_array['addr_address'], 45)."\r\n\r\n";
        if($vals_array['addr_index']) {
            $left_column .= "Индекс: ". $vals_array['addr_index']."\r\n";
        }

        $right_column  = "\r\n";
        if($vals_array['addr_nalozh']) {
            $right_column = "\r\nНаложенный платеж: " . $vals_array['addr_nalozh']. " руб. \r\n";
            $right_column .= $doc->wordToLines(num2str_bezkop($vals_array['addr_nalozh']))."\r\n\r\n";
        }
        $right_column .= 'Объявленая ценность: '. $vals_array['addr_sum']." руб. \r\n";
        $right_column .= $doc->wordToLines(num2str_bezkop($vals_array['addr_sum']))."\r\n\r\n";



        $doc->Row(array($left_column, $right_column));
        $doc->Output('f7-custom.pdf', 'D');
    }


    public function formprint() {
        $this->load->model('setting/setting');
        $settings = $this->config->get('ruspost_form_module');
        foreach ($settings as $i => $setting) {
            $settings[$i] = array_map('html_entity_decode', $setting);
        }
        $data['modules'] = json_encode($settings);
        $this->load->model('sale/order');
        $order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
        $arr = array();
        if (!($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $arr = (isset($settings[1]) ?
                $settings[1]
                : array("sender_name" => '',
                    "sender_index" => '',
                    "sender_address" => 'Заполните профиль в настройках модуля "Форма почтового перевода почты России"',
                    "sender_phone" => '',
                    "sender_document_doc" => 'паспорт',
                    "sender_document_ser" => '',
                    "sender_document_nomer" => '',
                    "sender_document_vydan" => '',
                    "sender_document_vydanday" => '',
                    "sender_document_vydanyear" => '',
                    "sender_jurfiz" => '',
                    "sender_inn" => '',
                    "sender_bank" => '',
                    "sender_korr" => '',
                    "sender_rs" => '',
                    "sender_bik" => '',
                )
            );
            $arr['addr_name'] = trim($order_info['shipping_lastname'] . ' ' . $order_info['shipping_firstname'] . ' '. $order_info['fax']);
            $arr['addr_index'] = $order_info['shipping_postcode'];
            $arr['addr_address'] = trim($order_info['shipping_address_1'] . ' ' . $order_info['shipping_address_2'] . ', д. ' . $order_info['shipping_custom_field'][5] . ', корп. ' . $order_info['shipping_custom_field'][6] . ', кв. ' . $order_info['shipping_custom_field'][7] . ', ' . $order_info['shipping_city'] . ', ' . $order_info['shipping_zone']);
            $arr['addr_phone'] = trim(preg_replace('/[^\d]/', '', str_replace('+7', '', $order_info['telephone'])));
            $arr['addr_sum'] = $order_info['total'];
            $arr['order_id'] = $order_info['order_id'];
            $data['arr'] = $arr;
            $this->response->setOutput($this->load->view('module/ruspost_formprint.tpl', $data));
        } else {
            $this->session->data['ufpdf_post_form'] = $this->request->post['arr'];
            if ($this->request->post['act'] == 'sticker')
                $this->response->redirect($this->url->link('module/ruspost_form/pdfsticker', 'token=' . $this->session->data['token'], 'SSL'));
            else if ($this->request->post['act'] == 'f113')
                $this->response->redirect($this->url->link('module/ruspost_form/f113', 'token=' . $this->session->data['token'], 'SSL'));
            else if ($this->request->post['act'] == 'f112ep')
                $this->response->redirect($this->url->link('module/ruspost_form/f112ep', 'token=' . $this->session->data['token'], 'SSL'));
            else if ($this->request->post['act'] == 'f112ek')
                $this->response->redirect($this->url->link('module/ruspost_form/f112ek', 'token=' . $this->session->data['token'], 'SSL'));
            else if ($this->request->post['act'] == 'f116')
                $this->response->redirect($this->url->link('module/ruspost_form/f116', 'token=' . $this->session->data['token'], 'SSL'));
            else if ($this->request->post['act'] == 'opis')
                $this->response->redirect($this->url->link('module/ruspost_form/pdfopis', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL'));
            else if ($this->request->post['act'] == 'custom')
                $this->response->redirect($this->url->link('module/ruspost_form/pdfcustom', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'], 'SSL'));
            else
                $this->response->redirect($this->url->link('module/ruspost_form/pdfform', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

    public function index() {
        $this->load->language('module/ruspost_form');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('ruspost_form', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data = array();
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_module'] = $this->language->get('text_module');

        $data['entry_profile'] = $this->language->get('entry_profile');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_fio'] = $this->language->get('entry_fio');
        $data['entry_zip'] = $this->language->get('entry_zip');
        $data['entry_address'] = $this->language->get('entry_address');
        $data['entry_phone'] = $this->language->get('entry_phone');

        $data['entry_jurfiz'] = $this->language->get('entry_jurfiz');

        $data['entry_docname'] = $this->language->get('entry_docname');
        $data['entry_doccode'] = $this->language->get('entry_doccode');
        $data['entry_docissued'] = $this->language->get('entry_docissued');
        $data['entry_docdate'] = $this->language->get('entry_docdate');

        $data['entry_inn'] = $this->language->get('entry_inn');
        $data['entry_korr'] = $this->language->get('entry_korr');
        $data['entry_bank'] = $this->language->get('entry_bank');
        $data['entry_rs'] = $this->language->get('entry_rs');
        $data['entry_bik'] = $this->language->get('entry_bik');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_profile'] = $this->language->get('button_add_profile');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['tab_module'] = $this->language->get('tab_module');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/ruspost_form', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('module/ruspost_form', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $data['newprofile'] = $this->url->link('module/ruspost_form', 'token=' . $this->session->data['token'] . '&newprofile=1', 'SSL');

        $data['token'] = $this->session->data['token'];

        $data['modules'] = array();

        if (isset($this->request->post['ruspost_form_module'])) {
            $data['modules'] = $this->request->post['ruspost_form_module'];
        } elseif ($this->config->get('ruspost_form_module')) {
            $data['modules'] = $this->config->get('ruspost_form_module');
        }
        if (isset($this->request->get['newprofile'])) {
            $data['modules'][] = array(
                'description' => 'Новый профиль',
                'sender_name' => 'Иванов Тимофей Семенович',
                'sender_index' => '111222',
                'sender_address' => 'Рязанская_обл., г.Спас-Клепики, ул._Есенина, д.21_кв.9',
                'sender_phone' => '+791191122',
                'sender_jurfiz' => 0,
                'sender_inn' => '',
                'sender_bank' => 'ЗАО &quot;Сочиолимраспилбанк&quot;',
                'sender_korr' => '',
                'sender_rs' => '',
                'sender_bik' => '',
                'sender_document_doc' => 'паспорт',
                'sender_document_ser' => 6002,
                'sender_document_nomer' => 421122,
                'sender_document_vydan' => 'Милицейским РОВД гор. Касимов',
                'sender_document_vydanday' => '1 апреля',
                'sender_document_vydanyear' => '02'
            );
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/ruspost_form.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/ruspost_form')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}

?>
