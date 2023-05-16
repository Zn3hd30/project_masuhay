<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Resident;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Residents extends Component
{
    use LivewireAlert;
    public $CivilStatus, $FirstName, $MiddleName, $LastName, $Suffix, $DOB, $PlaceofBirth, $forUpdate;

    public function render()
    {
        $this->list = Resident::orderBy('id','DESC')->get();
        return view('livewire.residents');
    }

    public function delete($id)
    {
        $delete = Resident::where('id', $id)->delete();
        if($delete)
            $this->alert('success','Successfully deleted!');
    }
    public function update($id)
    {
        $info = Resident::where('id', $id)->first();

        if(isset($info)){
            $this->sessionID           =$id;
            $this->forUpdate           =true;
            $this->FirstName           =$info->FirstName;
            $this->MiddleName          =$info->MiddleName;
            $this->LastName            =$info->LastName;
            $this->Suffix              =$info->Suffix;
            $this->DOB                 =$info->DOB;
            $this->PlaceofBirth        =$info->PlaceofBirth ;
            $this->CivilStatus         =$info->CivilStatus;
    }
}

    public function saveResident()
    {
        $validate = $this->validate([
            'FirstName'     => 'required',
            'LastName'      => 'required',
            'MiddleName'      => 'required',
            'DOB'   => 'required',
            'Suffix'   => '',
            'PlaceofBirth'  => 'required',
            'CivilStatus'   => 'required'
        ],[
            'FirstName.required' => 'First Name is required',
            'LastName.required'  => 'Last Name is required',
            'MiddleName.required'      => 'Middle Name is required',
            'DOB.required'       => 'Date of Birth is required',
            'Suffix.required'   => 'Suffix is required',
            'PlaceofBirth.required' => 'Place of Birth is required',
            'CivilStatus.required' => 'Civil Status is required',
        ]);

        if($validate){
            if($this->forUpdate){
                $data = [
                    'FirstName' => $this->FirstName,
                    'MiddleName' => $this->MiddleName,
                    'LastName' => $this->LastName,
                    'Suffix' => $this->Suffix,
                    'DOB' => $this->DOB,
                    'PlaceofBirth' => $this->PlaceofBirth,
                    'CivilStatus' => $this->CivilStatus,
                ];

                $update = Resident::where('id', $this->sessionID)
                ->update($data);
                if($update){
                    $this->alert('success', $this->FirstName.''.$this->LastName.' has been updated',['toast' => false,'position' => 'center']);
                }

            }else{
                $c = new Resident();
                $c->ResidentNo = strtoupper(uniqid());
                $c->FirstName = $this->FirstName;
                $c->MiddleName = $this->MiddleName;
                $c->LastName = $this->LastName;
                $c->Suffix = $this->Suffix;
                $c->DOB = $this->DOB;
                $c->PlaceofBirth = $this->PlaceofBirth;
                $c->CivilStatus = $this->CivilStatus;
                $c->save();

                $this->alert('success', $this->FirstName.''.$this->LastName.' has been added',['toast' => false,'position' => 'center']);
            }
            
            
            unset($this->FirstName);
            unset($this->MiddleName);
            unset($this->LastName);
            unset($this->Suffix);
            unset($this->DOB);
            unset($this->PlaceofBirth);
            unset($this->CivilStatus);
        }
    }
}