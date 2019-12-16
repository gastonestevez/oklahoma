<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Genre;
use App\Image;
use App\Stock;
class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function directory(Product $product)
     {
       $products = Product::all();
       $categories = Category::all();
       $images = Image::all();
       $vac = compact('products','categories','images');
       return view('/main',$vac);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function new() // Se muestra un form con los campos vacios para agregar un producto
     {
       $products = Product::all();
       $categories = Category::all();
       $genres = Genre::all();
       $vac = compact('products','categories', 'genres');
       return view('addproduct',$vac);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $form) // agrega un producto y te redirige a la lista de productos
    {

      // Declaro las variables de validacion

      $reglas = [
        'name' => 'required|string|min:1|max:50',
        'price' => 'required|integer|min:50|max:15000',
        'discount' => 'required|integer|min:0|max:80',
        'genre_id' => 'required',
        'category_id' => 'required',
        'xs' => 'required',
        's' => 'required',
        'm' => 'required',
        'l' => 'required',
        'xl' => 'required',
      ];


      $mensajes = [
        "required" => "El campo :attribute no puede estar vacio",
        'string' => "El campo :attribute debe ser un texto",
        "min" => "El campo :attribute tiene un minimo de :min caracteres",
        "max" => "El campo :attribute tiene un maximo de :max caracteres",
      ];


      // Validamos
      $this->validate($form,$reglas,$mensajes);

      // Instancio un stock
      $stock = new Stock;
      $stock->XS = $form->xs;
      $stock->S = $form->s;
      $stock->M = $form->m;
      $stock->L = $form->l;           // los campos que escribimos aca deben estar presentes en el form de creacion!
      $stock->XL = $form->xl;
      // $stock->T26 = $form->t26;
      // $stock->T28 = $form->t28;
      // $stock->T30 = $form->t30;
      // $stock->T32 = $form->t32;
      // $stock->T34 = $form->t34;
      // $stock->T36 = $form->t36;
      // $stock->T38 = $form->t38;
      // $stock->T40 = $form->t40;
      // $stock->T42 = $form->t42;
      // $stock->T44 = $form->t44;
      // $stock->T46 = $form->t46;
      // $stock->T48 = $form->t48;
      // $stock->T50 = $form->t50;

      // guardo en la base de datos
      $stock->save();


      // Instancio un producto
      $product = new Product();
      $product->name = $form['name']; // alternativa $producto->name = $request->name;
      $product->price = $form['price'];
      $product->onSale = $form['onSale'];
      $product->discount = $form['discount'];
      $product->genre_id = $form['genre_id'];
      $product->category_id = $form['category_id'];
      $product->stock_id = $stock->id ;  // modifique, antes era asi : $product->stock_id = $stock->id; Por ende no necesitamos la columna FK stock_id

      // guardo en la base de datos
      $product->save();


      // traigo el producto recien creado para obtener su ID
      $lastProduct = Product::all()->last();
      $productId = $lastProduct->id;

      if (!empty($form['images'])) { // si suben una o mas fotos, entonces comenzamos el proceso de guardado ALTERNATIVA: if($request->images)
        // obtengo el array de imagenes
        $images = $form->file('images');
        // traigo las imagenes y recorro el array
        // $images = Image::all();
        foreach ($images as $image) {
          // guardo cada imagen en storage/public (no en la base de datos)
          $file = $image->store('public');
          // obtengo sus nombres
          $path = basename($file);


          // por cada imagen instancio un objeto de la clase imagen
          $image = new Image;
          // asigno las rutas correspondientes y asigno el id de la imagen que debe ser igual al id del ultimo producto creado
          $image->product_id = $productId;
          $image->path = $path;

          // guardo el objeto imagen instanciado en la base de datos
          $image->save();
        }
      }

      // dd($form->all());

      // Redirijo
      return redirect('/')
      ->with('status', 'Producto creado exitosamente!!!')
      ->with('operation', 'success');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function show($id) // se muestran los datos del producto elegido
    {
      $product = Product::find($id);
      $image = Image::where('product_id', '=', $id)->get();
      // $category = Category::find($id); si no lo llamo de esta manera utilizo la relacion del modelo. Ver Product.blade.php {{$product->category->name}}
      $stock = Stock::where('id', '=', $product->stock_id)->get();
      $vac = compact('product', 'image', 'stock');
      // dd($image);
      return view('product',$vac);
    }

    public function edit($id) // se muestran los datos del producto elegido listo para editar
    {
      $product = Product::find($id);
      $genres = Genre::all();
      $images = Image::where('product_id', '=', $id)->get();
      $categories = Category::all();
      $stock = Stock::find($id);

      return view('/editproduct', compact('product', 'genres', 'categories','images' , 'stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */


    public function update(Request $form, int $id) // se muestra el producto con los campos completos listo para editar. A diferencia de guardar, update lleva tambien la variable $id
    {
        // Declaro las variables de validacion

        $reglas = [
      'name' =>'required|string|min:3|max:40|',
      'price' =>'required|numeric|min:0|max:100000|',
      'onSale' => 'required',
      'discount' => 'numeric|min:0|max:80',
      'genre_id' => 'required',
      'category_id' => 'required',
      'xs' => 'required|numeric|min:0|max:1000',
      's' => 'required|numeric|min:0|max:1000',
      'm' => 'required|numeric|min:0|max:1000',
      'l' => 'required|numeric|min:0|max:1000',
      'xl' => 'required|numeric|min:0|max:1000',
    ];

    $mensajes = [
      "required" => "El campo es obligatorio",
      "string" => "El campo debe ser un texto",
      "min" => "El minimo es de :min caracteres",
      "max" => "El maximo es de :max caracteres",
      "date" => "El campo :date debe ser una fecha",
      "integer" => "El campo debe ser un numero entero",
      "numeric" => "El campo debe ser un numero"
    ];

    // Validamos
    $this->validate($form, $reglas, $mensajes);

    // llamo al producto a editar
    $product = Product::find($id);

    // busco el stock del producto a editar

    $product->stock->XS = $form->xs;
    $product->stock->S = $form->s;
    $product->stock->M = $form->m;
    $product->stock->L = $form->l;
    $product->stock->XL = $form->xl;

    // guardo en la base de datos
    $product->stock->save();

    $product->name = $form['name']; // alternativa $producto->name = $request->name;
    $product->price = $form['price'];
    $product->onSale = $form['onSale'];
    $product->discount = $form['discount'];
    $product->genre_id = $form['genre_id'];
    $product->category_id = $form['category_id'];

    // guardo en la base de datos
    $product->save();


    // si cambian la foto
    // obtenemos la ruta de la foto anterior
    // verificamos si existe en la base de datos y en storage
    // elimina la foto del storage


    // Redirijo
    return redirect('/product/'.$product->id)
    ->with('status', 'Producto editado exitosamente!!!')
    ->with('operation', 'success');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function remeras(Product $product)
    {
      $products = Product::where('category_id', 'like', '1')->orderBy('price')->get();
      $category = Category::where('name', 'like', 'Remera')->get();
      $vac = compact('products','category');
      return view('remeras',$vac);
    }

    public function camisas(Product $product)
    {
      $products = Product::where('category_id', 'like', '2')->orderBy('price')->get();
      $category = Category::where('name', 'like', 'Camisa')->get();
      $vac = compact('products','category');
      return view('camisas',$vac);
    }

    public function jeans(Product $product)
    {
      $products = Product::where('category_id', 'like', '3')->orderBy('price')->get();
      $category = Category::where('name', 'like', 'Jean')->get();
      $vac = compact('products','category');
      return view('jeans',$vac);
    }

    public function buzos(Product $product)
    {
      $products = Product::where('category_id', 'like', '4')->orderBy('price')->get();
      $category = Category::where('name', 'like', 'Buzo')->get();
      $vac = compact('products','category');
      return view('jeans',$vac);
    }

    public function camperas(Product $product)
    {
      $products = Product::where('category_id', 'like', '5')->orderBy('price')->get();
      $category = Category::where('name', 'like', 'Campera')->get();
      $vac = compact('products','category');
      return view('jeans',$vac);
    }

    public function accesorios(Product $product)
    {
      $products = Product::where('category_id', 'like', '6')->orderBy('price')->get();
      $category = Category::where('name', 'like', 'Accesorio')->get();
      $vac = compact('products','category');
      return view('jeans',$vac);
    }

    public function ofertas(Product $product)
    {
      $products = Product::where('onSale', '=', true)->orderBy('price')->get();
      $category = Category::all();
      $vac = compact('products','category');
      return view('jeans',$vac);
    }

    public function delete(int $id){ // borrar producto y deslinkear cualquier relacion, en este caso, borra sus imagenes
      // llamamos al producto a eliminar mediante su id
      $product = Product::find($id);
      // llamamos a las imagenes que tienen el id del producto a eliminar
      $arrayImages = Image::where('product_id', '=', $id);

      for ($i=0; $i < count($arrayImages) ; $i++) {
      // por cada imagen seleccionamos su path y si existe la borramos de storage
      $image_path = storage_path('app/public/') . $arrayImages[$i]->path;
      // verificamos si existe en la base de datos y en storage
        if ($product->images && file_exists($image_path)) {
          // elimina las imagenes de storage
          unlink($image_path);
        }
      }
      $product->delete(); // borramos el producto
      $images->delete(); // borramos las imagenes utilizando la relacion del modelo
      return redirect("/");
    }
}
