<?php

namespace App\Http\Livewire\Frontend\User;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAddress;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddressesComponent extends Component
{
    use LivewireAlert;

    public $showForm = false;
    public $editMode = false;
    public $default_address = "";
    public $address_id = '';
    public $zipcode = '';
    public $title = '';
    public $number = '';
    public $neighborhood = '';
    public $state = '';
    public $city = '';
    public $complement = '';
    public $address = '';

    public function rules()
    {
       
        return [
            'zipcode' => ['required', 'string'],
            'title' => ['required', 'string'],
            'number' => ['required', 'numeric']
        ];
    }

    public function validationAttributes()
    {
   
        return [
            'zipcode' => 'zipcode',
            'title' => 'title',
            'number' => 'number',
        ];
    }

    public function storeAddress()
    {
        $this->validate();
       
        $address = auth()->user()->addresses()->create($this->formData());

        if ($this->default_address) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update([
                'default_address' => false,
            ]);
        }
        $this->resetForm();
        $this->showForm = false;
        $this->alert('success', 'Endereço Criado com Sucesso.');
    }

    public function editAddress($id)
    {
        $address = UserAddress::find($id);

        
        
        $this->number = $address->number;
        $this->zipcode = $address->zipcode;
        $this->title = $address->title;
        $this->address_id = $id;     

        $this->showForm = true;
        $this->editMode = true;
    }

    public function updateAddress()
    {
        $this->validate();

        $viaCepUrl = "https://viacep.com.br/ws/{$this->zipcode}/json/";
        $response = file_get_contents($viaCepUrl);
        $endereco = json_decode($response, true);

        $this->address = $endereco['logradouro'];
        $this->neighborhood = $endereco['bairro'];
        $this->city = $endereco['localidade'];
        $this->state = $endereco['uf'];
       

        auth()->user()->addresses()
            ->where('id', $this->address_id)
            ->update($this->formData());

      

        $this->resetForm();
        $this->showForm = false;
        $this->alert('success', 'Address updated successfully');
    }

    public function deleteAddress($id)
    {
        
        $address = auth()->user()->addresses()->where('id', $id)->first();
        if ($address->default_address) {
            auth()->user()->addresses()->first()->update(['default_address' => true]);
        }
        $address->delete();
        $this->alert('success', 'Address deleted successfully');
    }

    public function resetForm()
    {
      
        $this->reset();
        $this->resetValidation();
    }

    public function formData(): array
    {

        $viaCepUrl = "https://viacep.com.br/ws/{$this->zipcode}/json/";
        $response = file_get_contents($viaCepUrl);
        $endereco = json_decode($response, true);
       
        return [
            
            'zipcode' => $this->zipcode,
            'title' => $this->title,
            'neighborhood' => $endereco['bairro'],
            'state' => $endereco['uf'],
            'city' => $endereco['localidade'],
            'complement' => $this->complement,
            'address' => $endereco['logradouro'],
            'number' => $this->number,
        ];

      
    }

    public function render()
    {
        
      

        return view('livewire.frontend.user.addresses-component', [
            'addresses' => auth()->user()->addresses,
        ]);
    }
}
