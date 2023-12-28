
@include('admin.includes.alerts')

<div class="form-group">
    <label>Nome</label>
    <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ $role->name ?? old('name') }}">
</div>
<div class="form-group">
    <label>Descrição</label>
    <input type="text" name="description" class="form-control" placeholder="Descrição"
        value="{{ $role->description ?? old('description') }}">
</div>
<button type="submit" class="btn btn-dark">Enviar</button>
