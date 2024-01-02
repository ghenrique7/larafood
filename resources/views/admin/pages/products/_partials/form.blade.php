@include('admin.includes.alerts')

<div class="form-group">
    <label>Imagem</label>
    <input type="file" name="image" class="form-control" placeholder="Imagem"
        value="{{ $product->image ?? old('image') }}">
</div>
<div class="form-group">
    <label>Nome</label>
    <input type="text" name="title" class="form-control" placeholder="Nome"
        value="{{ $product->title ?? old('title') }}">
</div>
<div class="form-group">
    <label>Preço</label>
    <input type="text" name="price" class="form-control" placeholder="Preço"
        value="{{ $product->price ?? old('price') }}">
</div>
<div class="form-group">
    <label>Descrição</label>
    <textarea name="description" class="form-control" cols="30" rows="3" placeholder="Descrição">{{ $product->description ?? old('description') }}</textarea>
</div>
<button type="submit" class="btn btn-dark">Enviar</button>
