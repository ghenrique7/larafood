@include('admin.includes.alerts')

<div class="form-group">
    <label>Nome</label>
    <input type="text" name="name" class="form-control" placeholder="Nome"
        value="{{ $description->name ?? old('name') }}">
</div>
<div class="form-group">
    <label>Descrição</label>
    <textarea name="description" class="form-control" cols="30" rows="3" placeholder="Descrição">{{ $description->description ?? old('description') }}</textarea>
</div>
<button type="submit" class="btn btn-dark">Enviar</button>
