<?php 
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OrganizationModel;
use Illuminate\Support\Facades\Storage;

class Company extends Component
{
    use WithFileUploads;

    public $name, $address, $phone, $tax_code, $logo;
    public $logoUrl;
    public $flashMessage;

    public function mount()
    {
        $this->fetchData();
    }

    public function fetchData()
    {
        $organization = OrganizationModel::first();
        $this->name = $organization->name ?? '';
        $this->address = $organization->address ?? '';
        $this->phone = $organization->phone ?? '';
        $this->tax_code = $organization->tax_code ?? '';

        if (isset($organization->logo)) {
            $this->logoUrl = Storage::disk('public')->url($organization->logo);
        }
    }

    public function render()
    {
        return view('livewire.company');
    }

    public function save() {
        $logo = '';

        if ($this->logo) {
            $logo = $this->logo->store('organizations', 'public');
        }

        if (OrganizationModel::count() == 0) {
            $organization = new OrganizationModel();
        } else {
            $organization = OrganizationModel::first();

            if ($organization->logo) {
                if ($logo != '') {
                    $storage = Storage::disk('public');

                    if ($storage->exists($organization->logo)) {
                        $storage->delete($organization->logo);
                    }
                }
            }
        }

        $organization->name = $this->name;
        $organization->address = $this->address;
        $organization->phone = $this->phone;
        $organization->tax_code = $this->tax_code;
        $organization->logo = $logo;
        $organization->save();

        $this->flashMessage = 'บันทึกข้อมูลสำเร็จ';
        $this->fetchData();
    }
}
