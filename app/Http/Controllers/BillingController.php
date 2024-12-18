<?php

namespace App\Http\Controllers;

use App\Models\BillingModel;
use App\Models\OrganizationModel;

class BillingController extends Controller {
    public function index() {
        return view('billing');
    }

    public function printBilling($billingId) {
        $billing = BillingModel::find($billingId);
        $organization = OrganizationModel::first();
        
        return view('print-billing', compact('billing', 'organization'));
    }

    public function printInvoice($billingId) {
        $billing = BillingModel::find($billingId);
        $organization = OrganizationModel::first();

        return view('print-invoice', compact('billing', 'organization'));
    }
}
