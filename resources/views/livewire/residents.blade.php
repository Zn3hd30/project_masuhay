<div>
<div class="card-body">
                    <h5>Add New Residents</h5>
                    <form wire:submit.prevent="saveResident">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-label">First Name</div>
                                    <input type="" wire:model="FirstName" class="form-control">
                                    @error('FirstName')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-label">Middle Name</div>
                                    <input type="" wire:model="MiddleName" class="form-control">
                                   
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-label">Last Name</div>
                                    <input type="" wire:model="LastName" class="form-control">
                                    @error('LastName')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-label">Suffix</div>
                                    <input type="" wire:model="Suffix" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-label">Date of Birth</div>
                                    <input type="date" wire:model="DOB" class="form-control">
                                    @error('DOB')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-label">Civil Status</div>
                                    <select wire:model="CivilStatus" class="form-control">
                                        <option value="">--Select Status--</option> 
                                        <option value="Single">Single</option> 
                                        <option value="Taken">Taken</option>
                                        <option value="Married">Married</option> 
                                        <option value="Separated">Separated</option> 
                                        <option value="Widow">Widow</option> 
                                    </select>
                                    @error('CivilStatus')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-label">Place of Birth</div>
                                    <input type="" wire:model="PlaceofBirth" class="form-control">
                                    @error('PlaceofBirth')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                @if($forUpdate)
                                <button class="btn btn-primary">Update</button>
                                @else
                                <button class="btn btn-primary">Save</button>
                                @endif
                             </div>
                        </div>
                    </form>
                </div>
 
                <hr>
                <table class="table">
                    <thead>
                        <th>QRcode</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Suffix</th>
                        <th>Date of Birth</th>
                        <th>Place of Birth</th>
                        <th>Civil Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if(isset($list))
                            @foreach($list as $c)
                                <tr>
                                    <td>{!! QrCode::size(30)->generate($c->FirstName)!!}</td>
                                    <td>{{ $c->FirstName }}</td>
                                    <td>{{ $c->MiddleName }}</td>
                                    <td>{{ $c->LastName }}</td>
                                    <td>{{ $c->Suffix }}</td>
                                    <td>{{ $c->DOB }}</td>
                                    <td>{{ $c->PlaceofBirth }}</td>
                                    <td>{{ $c->CivilStatus }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm"
                                        wire:click="update('{{ $c->id }}')">
                                        Edit</button>

                                        <button class="btn btn-danger btn-sm"
                                        wire:click="delete('{{ $c->id }}')">
                                        Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                </hr>
</div>