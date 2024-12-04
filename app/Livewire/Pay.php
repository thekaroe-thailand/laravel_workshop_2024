<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PayModel;
use App\Models\PayLogModel;

class Pay extends Component {
    public $showModalPay = false;
    public $showModalPayLog = false;
    public $showModalPayLogEdit = false;
    public $showModalPayDelete = false;
    public $showModalPayLogDelete = false;
    public $showModalPayLogRestore = false;
    public $pays = [];
    public $payLogs = [];
    public $listPays = [];
    public $payId;
    public $payName;
    public $payRemark;
    public $payNameForDelete;
    public $payLogDate;
    public $payLogAmount = [];
    public $payLogEditId;
    public $payLogEditName;
    public $payLogEditRemark;
    public $payLogEditAmount;
    public $payLogEditDate;
    public $payLogDeleteId;
    public $payLogRestoreId;

    public function mount() {
        $this->fetchData();
        $this->payLogDate = date('Y-m-d');
    }

    public function fetchData() {
        $this->pays = PayModel::where('status', 'use')
            ->orderBy('id', 'desc')
            ->get();
        $this->payLogs = PayLogModel::orderBy('id', 'desc')->get();
    }

    public function render() {
        return view('livewire.pay');
    }

    public function openModalPay() {
        $this->showModalPay = true;
    }

    public function closeModalPay() {
        $this->showModalPay = false;
    }

    public function openModalPayLog() {
        $this->showModalPayLog = true;
        $this->listPays = PayModel::where('status', 'use')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function closeModalPayLog() {
        $this->showModalPayLog = false;
    }

    public function openModalPayLogEdit($id) {
        $this->showModalPayLogEdit = true;

        $payLog = PayLogModel::find($id);
        $this->payLogEditId = $payLog->id;
        $this->payLogEditName = $payLog->pay->name;
        $this->payLogEditRemark = $payLog->remark;
        $this->payLogEditAmount = $payLog->amount;
        $this->payLogEditDate = date('Y-m-d', strtotime($payLog->pay_date));
    }

    public function closeModalPayLogEdit() {
        $this->showModalPayLogEdit = false;
    }

    public function savePay() {
        $pay = new PayModel();

        if ($this->payId) {
            $pay = PayModel::find($this->payId);
        }

        $pay->name = $this->payName;
        $pay->remark = $this->payRemark;
        $pay->status = 'use';
        $pay->save();

        $this->fetchData();
        
        $this->payName = '';
        $this->payRemark = '';
        $this->payId = null;
    }

    public function editPay($id) {
        $pay = PayModel::find($id);

        $this->payId = $pay->id;
        $this->payName = $pay->name;
        $this->payRemark = $pay->remark;
    }

    public function openModalPayDelete($id, $name) {
        $this->showModalPayDelete = true;
        $this->payId = $id;
        $this->payNameForDelete = $name;
    }

    public function deletePay() {
        $pay = PayModel::find($this->payId);
        $pay->status = 'delete';
        $pay->save();

        $this->fetchData();
        $this->closeModalPayDelete();
    }

    public function closeModalPayDelete() {
        $this->showModalPayDelete = false;
    }

    public function openModalPayLogDelete($id) {
        $this->showModalPayLogDelete = true;
        $this->payLogDeleteId = $id;
    }

    public function closeModalPayLogDelete() {
        $this->showModalPayLogDelete = false;
    }

    public function deletePayLog() {
        $payLog = PayLogModel::find($this->payLogDeleteId);
        $payLog->status = 'delete';
        $payLog->save();

        $this->fetchData();
        $this->closeModalPayLogDelete();
    }

    public function openModalPayLogRestore($id) {
        $this->showModalPayLogRestore = true;
        $this->payLogRestoreId = $id;
    }

    public function closeModalPayLogRestore() {
        $this->showModalPayLogRestore = false;
    }

    public function restorePayLog() {
        $payLog = PayLogModel::find($this->payLogRestoreId);
        $payLog->status = 'use';
        $payLog->save();

        $this->fetchData();
        $this->closeModalPayLogRestore();
    }

    public function savePayLog() {
        $arrayPayLogAmount = $this->payLogAmount;

        foreach ($arrayPayLogAmount as $key => $value) {
            $payLog = new PayLogModel();
            $payLog->pay_date = $this->payLogDate;
            $payLog->amount = $value;
            $payLog->pay_id = $key;
            $payLog->status = 'use';
            $payLog->save();
        }

        $this->closeModalPayLog();
        $this->fetchData();
        $this->payLogDate = date('Y-m-d');
        $this->payLogAmount = [];
    }

    public function editPayLog($id) {
        $payLog = PayLogModel::find($id);
    }

    public function editPayLogSave() {
        $payLog = PayLogModel::find($this->payLogEditId);
        $payLog->pay_date = $this->payLogEditDate;
        $payLog->amount = $this->payLogEditAmount;
        $payLog->remark = $this->payLogEditRemark;
        $payLog->save();

        $this->fetchData();
        $this->closeModalPayLogEdit();
    }
}
