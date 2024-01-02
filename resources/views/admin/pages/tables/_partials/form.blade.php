@include('admin.includes.alerts')

<div class="form-group">
    <label>Identificador</label>
    <input type="text" name="identify" class="form-control" placeholder="Nome"
        value="{{ $table->identify ?? old('identify') }}">
</div>
<div class="form-group">
    <label>Descrição</label>
    <textarea name="description" class="form-control" cols="30" rows="3" placeholder="Descrição">{{ $table->description ?? old('description') }}</textarea>
</div>
<button type="submit" class="btn btn-dark">Enviar</button>
