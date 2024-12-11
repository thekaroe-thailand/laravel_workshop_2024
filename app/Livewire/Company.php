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
    public $amount_water = 0;
    public $amount_water_per_unit = 0;
    public $amount_electric_per_unit = 0;
    public $amount_internet = 0;
    public $amount_etc = 0;
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
        $this->amount_water = $organization->amount_water ?? 0;
        $this->amount_water_per_unit = $organization->amount_water_per_unit ?? 0;
        $this->amount_electric_per_unit = $organization->amount_electric_per_unit ?? 0;
        $this->amount_internet = $organization->amount_internet ?? 0;
        $this->amount_etc = $organization->amount_etc ?? 0;

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

        if ($logo != '') {
            $organization->logo = $logo;
        }

        $organization->amount_water = $this->amount_water;
        $organization->amount_water_per_unit = $this->amount_water_per_unit;
        $organization->amount_electric_per_unit = $this->amount_electric_per_unit;
        $organization->amount_internet = $this->amount_internet;
        $organization->amount_etc = $this->amount_etc;
        $organization->save();

        $this->flashMessage = 'บันทึกข้อมูลสำเร็จ';
        $this->fetchData();
    }
}
