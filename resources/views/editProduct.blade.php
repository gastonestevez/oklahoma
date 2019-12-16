@extends('plantilla')
@section('titulo')
Edit Product
@endsection
@section('css')
forms
@endsection
@section('main')
  <div class="container">
    <h5 class="centrado titulo">Editar Producto</h5>
    <div class="row">
      <div class="col-lg-4 offset-lg-2 col-md-6">

        <!-- Vista de edicion del Producto-->
        <form class="form-signup" action='/editproduct/{{$product['id']}}' method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <input type="hidden" name="_method" value="PUT">  {{--<!-- alternativa @method('put') --}}

          <div class="form-group">
            <label for="">Name: </label>
            <input type="text" class="form-control" name="name" value="{{ old('name',$product->name)}}"> <?php // Se le pone el old(name, product name) No solo para que agarre los datos del nombre sino para que tambien persistan los cambios ante un error ?>
          </div>

          <div class="form-group">
            <label for="">Price: </label>
            <input type="number" class="form-control" min="300" max="15000" step="100" name="price" value="{{ old('price',$product->price)}}">
          </div>

          <div class="form-group">
            <label for="">on sale? : </label>
            <select class="" name="onSale">
                <option value =0 @if($product->onSale == 0) selected @endif>No esta en oferta</option>
                <option value =1 @if($product->onSale == 1) selected @endif>Esta en oferta</option>
            </select>
          </div>

          <div class="form-group">
            <label for="">descuento: </label>
            <input class="cantidad" type="number" class="form-control" name="discount" min="0" max="80" step="5" value="{{ old('discount',$product->discount)}}">
          </div>

          <div class="form-group">
            <label for="">Genero: </label>
            <select class="" name="genre_id">
              <option value="">Seleccione un genero</option>
              @foreach ($genres as $genre)
                <option value="{{$genre->id}}" @if($genre->id == $product->genre_id) selected @endif>{{$genre->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="">Categories: </label>
            <select class="" name="category_id">
              <option value="">Seleccione una categoria</option>
              @foreach ($categories as $category)
                <option value="{{$category->id}}" @if($category->id == $product->category_id) selected @endif>{{$category->name}}</option>
              @endforeach
            </select>
          </div>
          @if ($product->stock_id)

          <div class="form-group">
            <label for="">XS: </label>
            <input class="cantidad" type="number" class="form-control" name="xs" min="0" max="100" step="1" value="{{$product->stock->XS}}">
          </div>
          <div class="form-group">
            <label for="">S: </label>
            <input class="cantidad" type="number" class="form-control" name="s" min="0" max="100" step="1" value="{{$product->stock->S}}">
          </div>

          <div class="form-group">
            <label for="">M: </label>
            <input class="cantidad" type="number" class="form-control" name="m" min="0" max="100" step="1" value="{{$product->stock->M}}">
          </div>

          <div class="form-group">
            <label for="">L: </label>
            <input class="cantidad" type="number" class="form-control" name="l" min="0" max="100" step="1" value="{{$product->stock->L}}">
          </div>

          <div class="form-group">
            <label for="">XL: </label>
            <input class="cantidad" type="number" class="form-control" name="xl" min="0" max="100" step="1" value="{{$product->stock->XL}}">
          </div>
        @else
          <div class="form-group">
            <label for="">XS: </label>
            <input class="cantidad" type="number" class="form-control" name="xs" min="0" max="100" step="1" value="0">
          </div>

          <div class="form-group">
            <label for="">S: </label>
            <input class="cantidad" type="number" class="form-control" name="s" min="0" max="100" step="1" value="0">
          </div>

          <div class="form-group">
            <label for="">M: </label>
            <input class="cantidad" type="number" class="form-control" name="m" min="0" max="100" step="1" value="0">
          </div>

          <div class="form-group">
            <label for="">L: </label>
            <input class="cantidad" type="number" class="form-control" name="l" min="0" max="100" step="1" value="0">
          </div>

          <div class="form-group">
            <label for="">XL: </label>
            <input class="cantidad" type="number" class="form-control" name="xl" min="0" max="100" step="1" value="0">
          </div>
        @endif

          <div class="form-group">
            <label for="">Imagen del Producto: </label>
            <br>
            {{-- para poder agregar varios archivos hay que colocar los [] en el name del file y el atributo multiple --}}
            <input type="file" name="images" value="" multiple>
            {{-- @php
              $image_path = storage_path('app/public/') . $product->$images->path; // traemos la variable con la ruta de la imagen
            @endphp --}}

            {{-- Si las imagenes existen tanto en la bd como en storage, las muestro --}}
              @foreach ($product->images as $image)
                <img class="product-img" style="margin-bottom:10px;margin-top:10px;" src="/storage/{{$image->path}}" alt="">
              @endforeach
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-success" value="Edit Product">Editar producto</button>
          </div>
        </form>


      <ul style="color:red" class="errores">
        @foreach ($errors->all() as $error)
          <li>
            {{$error}}
          </li>
        @endforeach
      </ul>
  </div>
@endsection
