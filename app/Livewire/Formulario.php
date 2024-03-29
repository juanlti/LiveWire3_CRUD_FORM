<?php

namespace App\Livewire;

use App\Livewire\Forms\PostCreateForm;
use App\Livewire\Forms\PostEditForm;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;


class Formulario extends Component
{




    public  $categories,$tags;
    public $is_published,$image_path;

    // CLASE POSTCREATEFORM
    //Creacion de un objeto tipo postCreateForm
    public PostCreateForm $postCreateForm;
    public $posts;


    //CLASE POSTEDITFORM
    public PostEditForm $postEditForm;
    //Edicion de un objeto tipo postEditForm



    /**
     *
     * @var mixed|null
     */
    private mixed $validate;
    /**
     * @var mixed|null
     */
    private mixed $errors;


    public function edit(Int $idPost){

        //RESETEO  LA ULTIMA VERIFICACION REALIZADA, CON EL FIN DE EVITAR MENSAJES A OBJETOS NO CORRESPONDIENTES
        $this->resetValidation();

       $this->postEditForm->edit($idPost);






    }
    public function update(){

        $this->postEditForm->update();
        $this->posts=Post::all();

        $this->dispatch('post-created','Articulo actualizado');
    }


    //

    /**
     * @throws \Exception
     */
    /*
    public function updating($property, $value){
      // updating => ESTA INTENTANDO VALIDAR DICHO COMPONENTES EN LA BD, SE AGREGA VALIDACIONES
         //updating es un metodo anecdotico, al igual que los parametros
            // conocemos el tipo de variable y el valor a modificar
        //$property => NOMBRE DE LA VARIABLE A UTILIZAR EN EL INPUT
        //$value => contenido de la variable
        //dd($value);
        // VALIDACION
        if($property=='postCreateForm.category_id'){
            if($value>3){
                throw new \Exception("No puedes selecionar esta categoria, vuelve a selecionar del 1 al 3");
            }


        }

    }
    */

public function updated($property,$value){
    /// updated => ACTUALIZA LOS VALORES EN LA BD, MODIFICAR EL TIPO DE LETRAS, NO RECOMENDADO PARA  VALIDAR
    dd($value);
}
public function hydrate(){
    // de back a front => hydrata el objecto
}

public function dehydrate(){
    // de front a back => desidrata el objecto
}


    //ciclo de vida de un componente
    public function mount(){
        // CARGA DE DATOS DE MANERA INCONDICIONAL
        // $categories contiene la collecion almacenada de categorias
        // $this->categories= Category::all();
        $this->categories= Category::orderBy('id','desc')->get();
        //$this->posts = Post::orderBy('created_at', 'asc')->get();
        // $tags contiene la collecion almacenada de tags
        $this->tags=Tag::all();

        //dd($this->tags);
        //CARGAMOS TODOS LOS POST
        $this->posts=Post::all();


    }
    public function save(){

        //llamo al objecto de la instancia PostCreateForm y ejecuto su metodo save()
        $this->postCreateForm->save();

        $this->posts=Post::all();

        //EMITO UN EVENTO, TIPO DE EVENTO 'dispatch'
        //este evento puede ser escuchado por un hijo o padre.
        // id del evento ? 'post-create' por lo tanto, con su id puede ser escuchado en cualquier lugar de la app
        $this->dispatch('post-created','Nuevo articulo creado');



    }
    public function destroy(int $idPost){
        //busco el objeto en la bd
        $postDelete=Post::find($idPost);
        //aplico el metodo delete al objeto a eliminar
        $postDelete->delete();
        //actualizo la lista
        $this->posts=Post::all();
        $this->dispatch('post-created','Articulo Eliminado');

    }




 public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
 {
     return view('livewire.formulario');
 }

}
