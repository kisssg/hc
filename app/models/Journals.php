<?php
use Phalcon\Mvc\Model;
class Journals extends Model {
    public function initialize()
    {
        $this->setSource("journal_data");
    }
    public $j_id;
public $employee_id;
public $journal_creator;
public $city;
public $journal_create_time;
public $contract_no;
public $addr_type_cn;
public $addr_current;
public $addr_work;
public $addr_registered;
public $addr_sign_in;
public $addr_detail;
public $device;
public $negotiator_cn;
public $estate_owner;
public $client_work_info;
public $visit_result_cn;
public $unpaid_reason_cn;
public $follow_act;
public $follow_act_time;
public $detail_describe;
public $remark;
public $pic_addr;
public $addr;
public $comment;
public $visit_addr;
public $contract_appointee_id;
public $visit_date_short;
public $addr_type;
public $negotiator;
public $visit_result;
public $unpaid_reason;
public $detail;
public $qc_name;
public $validity;
public $equipment_id;
public $visit_time;
public $envelope;
public $name_cn;
public $visit_date;
public $red_cell;
public $employee_code;
public $visit_logic;
public $logic_check;
public $issue_reason;
public $id_person;
public $contract_rep;
public $judge_remark;
public $upload_time;
public $validity_fill_date;
public $validity_fill_time;
public $edit_log;
public $device_checker;
public $device_check_time;
public $checking_time;
public $index_llc_date;

}