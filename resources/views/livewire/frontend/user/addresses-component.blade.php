<div x-data="{ formShow: @entangle('showForm') }">
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">Endereços</h2>
        <div class="ml-auto">
            <button type="button" @click="formShow = true" class="btn btn-dark rounded shadow">
                Adicionar Novo Endereço
            </button>
        </div>
    </div>

    <form wire:submit.prevent="{{ $editMode ? 'updateAddress' : 'storeAddress' }}" x-show="formShow"
        @click.away="formShow = false">
        @if ($editMode)
            <input type="hidden" wire:model="address_id">
        @endif
        <div class="form-group">
            <label for="title">Titulo:</label>
            <input type="text" class="form-control"  wire:model="title" name=""  placeholder="Exemplo : Minha Casa ">
            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" id="cep" wire:model="zipcode"  placeholder="Digite o CEP" maxlength="8"  onkeyup="buscarCEP()">
            @error('zipcode')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="logradouro">Logradouro:</label>
                    <input type="text" id="logradouro" class="form-control"  value="{{ old('address') }}" readonly>
             
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro"  class="form-control" readonly >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" class="form-control" readonly >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number">Número:</label>
                    <input type="text" id="number" class="form-control" wire:model="number">
                    @error('number')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="complement">Complemento:</label>
                    <input type="text" id="complement" class="form-control" wire:model="complement" >
                </div>
            </div>
        </div>

        <button class="btn btn-dark" type="submit">
            {{ $editMode ? 'Atualizar' : 'Salvar' }}
        </button>
    </form>

    <div class="my-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Localização</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($addresses as $address)
                        <tr>
                            <td>
                                {{ $address->title }}
                                <p class="text-gray-400">{{ $address->default_address }}</p>
                            </td>
                            <td>
                                {{ $address->address }}
                               N°  {{ $address->number }}<br>
                                <small>{{ $address->neighborhood . '-' . $address->city . '-' . $address->state }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" wire:click.prevent="editAddress('{{ $address->id }}')"
                                        class="btn btn-primary">
                                        <i class="fa fa-edit fa-sm"></i>
                                    </button>
                                    <button type="button"
                                        x-on:click.prevent="return confirm('Are you sure?') ? @this.deleteAddress('{{ $address->id }}') : false"
                                        class="btn btn-danger">
                                        <i class="fa fa-trash fa-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
