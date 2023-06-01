<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Resident;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Residents extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $CivilStatus, $FirstName, $MiddleName, $LastName, $Suffix, $DOB, $PlaceOfBirth, $forUpdate;
    public $searchTerm;
    public $list;

    protected $paginationTheme = 'bootstrap'; // Optional: Set the pagination theme

    public function render()
    {
        $residents = $this->getResidentList(); // Call the getResidentList() method
        $residents = $this->getResidentList()->paginate(5); // Set the number of items per page
    
        return view('livewire.residents', compact('residents'));
    }

    public function delete($id)
    {
        $delete = Resident::where('id', $id)->delete();
        if ($delete) {
            $this->alert('success', 'Successfully deleted!');
        }
    }

    public function update($id)
    {
        $info = Resident::where('id', $id)->first();

        if (isset($info)) {
            $this->sessionID           = $id;
            $this->forUpdate           = true;
            $this->FirstName           = $info->FirstName;
            $this->MiddleName          = $info->MiddleName;
            $this->LastName            = $info->LastName;
            $this->Suffix              = $info->Suffix;
            $this->DOB                 = $info->DOB;
            $this->PlaceOfBirth        = $info->PlaceOfBirth;
            $this->CivilStatus         = $info->CivilStatus;
        }
    }

    public function saveResident()
    {
        $validate = $this->validate([
            'FirstName'     => 'required',
            'LastName'      => 'required',
            'MiddleName'    => 'required',
            'DOB'           => 'required',
            'Suffix'        => '',
            'PlaceOfBirth'  => 'required',
            'CivilStatus'   => 'required'
        ], [
            'FirstName.required'    => 'First Name is required',
            'LastName.required'     => 'Last Name is required',
            'MiddleName.required'   => 'Middle Name is required',
            'DOB.required'          => 'Date of Birth is required',
            'Suffix.required'       => 'Suffix is required',
            'PlaceOfBirth.required' => 'Place of Birth is required',
            'CivilStatus.required'  => 'Civil Status is required',
        ]);

        if ($validate) {
            if ($this->forUpdate) {
                $data = [
                    'FirstName'     => $this->FirstName,
                    'MiddleName'    => $this->MiddleName,
                    'LastName'      => $this->LastName,
                    'Suffix'        => $this->Suffix,
                    'DOB'           => $this->DOB,
                    'PlaceOfBirth'  => $this->PlaceOfBirth,
                    'CivilStatus'   => $this->CivilStatus,
                ];

                $update = Resident::where('id', $this->sessionID)
                    ->update($data);
                if ($update) {
                    $this->alert('success', $this->FirstName . ' ' . $this->LastName . ' has been updated', ['toast' => false, 'position' => 'center']);
                }
            } else {
                $resident = new Resident();
                $resident->ResidentNo       = strtoupper(uniqid());
                $resident->FirstName        = $this->FirstName;
                $resident->MiddleName       = $this->MiddleName;
                $resident->LastName         = $this->LastName;
                $resident->Suffix           = $this->Suffix;
                $resident->DOB              = $this->DOB;
                $resident->PlaceOfBirth     = $this->PlaceOfBirth;
                $resident->CivilStatus      = $this->CivilStatus;
                $resident->save();

                $this->alert('success', $this->FirstName . ' ' . $this->LastName . ' has been added', ['toast' => false, 'position' => 'center']);
            }

            // Reset the input fields
            $this->resetInputFields();
        }
    }

    public function resetInputFields()
    {
        $this->FirstName = '';
        $this->MiddleName = '';
        $this->LastName = '';
        $this->Suffix = '';
        $this->DOB = '';
        $this->PlaceOfBirth = '';
        $this->CivilStatus = '';
    }

    public function getResidentList()
    {
        $query = Resident::query();

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('FirstName', 'LIKE', '%' . $this->searchTerm . '%')
                    ->orWhere('LastName', 'LIKE', '%' . $this->searchTerm . '%');
            });
        }

        return $query->orderBy('id', 'DESC');
    }
}
    
