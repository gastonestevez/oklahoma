@extends('plantilla')
@section('titulo')
  Home Page
@endsection
@section('css')
home
@endsection
@section('main')
  <!-- contenido especifico del body de la vista-->
      <section class="banner">
        <div class="banner-inicio">
          <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
              <!-- indicators
             <ol class="carousel-indicators">
                 <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                 <li data-target="#myCarousel" data-slide-to="1"></li>
                 <li data-target="#myCarousel" data-slide-to="2"></li> -->
             </ol>
             <div class="carousel-inner">
               <div class="carousel-item active">
                 <img src="/img/banner.png" class="d-block w-100" alt="...">
               </div>
               <div class="carousel-item">
                 <img src="/img/carrousel2prueba.jpg" class="d-block w-100" alt="...">
               </div>
               <div class="carousel-item">
                 <img src="/img/carrousel3prueba.jpg" class="d-block w-100" alt="...">
               </div>
             </div>
             <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
             </a>
             <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
             </a>
           </div>
           <a class="ordena-ahora" href="">ORDENA YA!</a>
        </div>
        <div class="banner-mobile">
          <img class="img-bannerMobile" src="/img/bannerMobile.png" alt="Banner">
        </div>
      </section>
      <div class="container">
        <section class="productos">
          <div class="row">

          @foreach ($products as $product)
            <div class="padding  col-6 col-md-4 col-lg-3">
              <div class="producto">
                <a href="product/{{$product->id}}"><img class="img-productos" onmouseover="newImage()" onmouseout="oldImage()" foto-a="/storage/{{$product->images[0]->path}}" foto-b="/storage/{{$product->images[1]->path}}"  src="/storage/{{$product->images[0]->path}}" alt="{{$product->category->name}}"></a>
                <h3>{{$product->category->name}}</h3>
                <p class="descripcion">{{$product->name}}</p>
                @if($product->onSale==true && isset($product->discount))
                  @php
                    $onSalePrice = $product->price - $product->price/100*$product->discount; // precio * descuento / 100
                  @endphp
                  <span class="descuento">{{$product->discount}}% off</span> <!-- Pone un cartelito de descuento sobre la imagen del producto-->
                  <span class="precioAnterior">${{$product->price}}</span> <!-- Muestra precio anterior tachado -->
                  <span class="precio">${{$onSalePrice}}</span><p></p> <!-- Muestra el precio con el descuento incluido -->
                @else
                    <p class="precio">${{$product->price}}</p>
                @endif
                <a class="ordenar" href="product/{{$product->id}}">Ordenar!  <ion-icon name="cart"></ion-icon></a>
              </div>
            </div>

          @endforeach
          </div>
        </section>
      </div>
      <script type="text/javascript">
        function newImage(){
          imagenes = document.querySelectorAll(".img-productos");
          for (imagen of imagenes) {
            imagen.src = imagen.getAttribute("foto-b");
          }
        }
        function oldImage(){
          imagenes = document.querySelectorAll(".img-productos");
          for (imagen of imagenes) {
            imagen.src = imagen.getAttribute("foto-a");
          }
        }
      </script>

@endsection('main')