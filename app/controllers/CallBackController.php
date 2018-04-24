<?php

class CallBackController extends ControllerBase
{

    protected function initialize ()
    {}

    public function addAction ()
    {
        try {
            $type = $this->request->getPost('type_add');
            $contract_no = $this->request->getPost('contract_no_add');
            
            $client_name = $this->request->getPost('client_name_add');
            $contact_info = $this->request->getPost('contact_info_add');
            $contact_info2 = $this->request->getPost('contact_info2_add');
            $city = $this->request->getPost('city_add');
            $visit_date = $this->request->getPost('visit_date_add');
            $responsible_person = $this->request->getPost(
                    'responsible_person_add');
            $remark_phone = $this->request->getPost('remark_phone_add');
            $remark_detail = $this->request->getPost('remark_detail_add');
            $actual_paid_amt = $this->request->getPost('actual_paid_amt_add');
            $team_leader = $this->request->getPost('team_leader_add');
            $manager = $this->request->getPost('manager_add');
            $contact_person = $this->request->getPost('contact_person_add');
            $is_connected = $this->request->getPost('is_connected_add');
            $is_meet = $this->request->getPost('is_meet_add');
            $paid_date = $this->request->getPost('paid_date_add');
            $paid_method_q3 = $this->request->getPost('paid_method_q3_add');
            $paid_amt_q4 = $this->request->getPost('paid_amt_q4_add');
            $is_contacted = $this->request->getPost('is_contacted_add');
            $contact_type = $this->request->getPost('contact_type_add');
            $is_harassed = $this->request->getPost('is_harassed_add');
            $harass_type = $this->request->getPost('harass_type_add');
            $issue_type = $this->request->getPost('issue_type_add');
            $complaint_obj = $this->request->getPost('complaint_obj_add');
            $harass_detail = $this->request->getPost('harass_detail_add');
            $issue_time = $this->request->getPost('issue_time_add');
            $sensitive_word = $this->request->getPost('sensitive_word_add');
            $has_evidence = $this->request->getPost('has_evidence_add');
            $evidence_channel = $this->request->getPost('evidence_channel_add');
            $has_paid = $this->request->getPost('has_paid_add');
            $paid_method = $this->request->getPost('paid_method_add');
            $paid_amount = $this->request->getPost('paid_amount_add');
            $got_understood = $this->request->getPost('got_understood_add');
            $remark = $this->request->getPost('remark_add');
            $qc_name = $this->session->get('auth')['name']; // $this->request->getPost('qc_name_add');
            $check_time = date("Y-m-d H:i:s"); // $this->request->getPost('check_time_add');
            $delete_time = $this->request->getPost('delete_time_add');
            $actual_caller = $this->request->getPost('actual_caller_add');
            $data_uploader = $this->request->getPost('data_uploader_add');
            $upload_time = $this->request->getPost('upload_time_add');
            $upload_batch = date("Y-m-d");
            $create_type = "manual";
            
            if ($type == "" || $contract_no == "") {
                throw new exception("Type and contract No. are required");
            }
            if ($qc_name == "") {
                throw new exception("Login session expired");
            }
            
            $cb = new Callback();
            $cb->type = $type;
            $cb->contract_no = $contract_no;
            $cb->client_name = $client_name;
            $cb->contact_info = $contact_info;
            $cb->contact_info2 = $contact_info2;
            $cb->city = $city;
            $cb->visit_date = $visit_date;
            $cb->responsible_person = $responsible_person;
            $cb->remark_phone = $remark_phone;
            $cb->remark_detail = $remark_detail;
            $cb->actual_paid_amt = $actual_paid_amt;
            $cb->team_leader = $team_leader;
            $cb->manager = $manager;
            $cb->contact_person = $contact_person;
            $cb->is_connected = $is_connected;
            $cb->is_meet = $is_meet;
            $cb->paid_date = $paid_date;
            $cb->paid_method_q3 = $paid_method_q3;
            $cb->paid_amt_q4 = $paid_amt_q4;
            $cb->is_contacted = $is_contacted;
            $cb->contact_type = $contact_type;
            $cb->is_harassed = $is_harassed;
            $cb->harass_type = $harass_type;
            $cb->issue_type = $issue_type;
            $cb->complaint_obj = $complaint_obj;
            $cb->harass_detail = $harass_detail;
            $cb->issue_time = $issue_time;
            $cb->sensitive_word = $sensitive_word;
            $cb->has_evidence = $has_evidence;
            $cb->evidence_channel = $evidence_channel;
            $cb->has_paid = $has_paid;
            $cb->paid_method = $paid_method;
            $cb->paid_amount = $paid_amount;
            $cb->got_understood = $got_understood;
            $cb->remark = $remark;
            $cb->qc_name = str_replace(".", " ", $qc_name);
            $cb->check_time = $check_time;
            // $cb->delete_time=$delete_time;
            $cb->actual_caller = $actual_caller;
            $cb->data_uploader = $qc_name;
            $cb->upload_batch = $upload_batch;
            $cb->create_type = $create_type;
            
            if ($cb->create() === false) {
                throw new exception("something wrong");
            } else {
                echo '{"result":"success","msg":"' . $cb->id . '"}';
            }
        } catch (exception $e) {
            echo '{"result":"failed","msg":"' . $e->getmessage() . '"}';
        }
        $this->view->disable();
    }

    public function updateAction ()
    {
        try {
            $id = $this->request->getPost('id');
            $type = $this->request->getPost('type');
            $contract_no = $this->request->getPost('contract_no');
            $client_name = $this->request->getPost('client_name');
            $contact_info = $this->request->getPost('contact_info');
            $remark_detail = $this->request->getPost('remark_detail');
            $remark_phone = $this->request->getPost('remark_phone');
            
            $city = $this->request->getPost('city');
            $responsible_person = $this->request->getPost('responsible_person');
            $visit_date = $this->request->getPost('visit_date');
            
            $cb = Callback::findFirst($id);
            $cb->type = $type;
            $cb->contract_no = $contract_no;
            $cb->client_name = $client_name;
            $cb->contact_info = $contact_info;
            $cb->remark_detail = $remark_detail;
            $cb->remark_phone=$remark_phone;
            
            $cb->city = $city;
            $cb->responsible_person = $responsible_person;
            $cb->visit_date = $visit_date;
            if ($cb->save() === false) {
                throw new Exception("Failed updating record");
            }
            
            echo '{"result":"success","msg":"更新成功！"}';
        } catch (Exception $e) {
            echo '{"result":"failed","msg":"' . $e->getMessage() . '"}';
        }
        $this->view->disable();
    }
}
