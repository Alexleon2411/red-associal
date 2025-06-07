@extends('layouts.app')

@section('titulo')

Crear una nueva publicacion
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush


@section('contenido')
  <div class="md:flex md:items-center">
    <div class="md:w-1/2">
        <form action="{{route('images.store')}}" method="POST" enctype="multipart/form-data" id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
            @csrf
        </form>
    </div>
    <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-xl mt-10 md:mt-0">
      <form action="{{route('post.store')}}" method="POST">
        @csrf
        <div  class="mb-5">
            <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">Nombre</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo de la Publicacion" class="border p-3 w-full rounded-lg @error('titulo') border-red-500
            @enderror" value="{{old('titulo')}}">
            @error('titulo')
                <p class="text-bold text-red-600">{{$message}} </p>
            @enderror
        </div>
          <div  class="mb-5">
            <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">Descripcion</label>
            <textarea  id="descripcion" name="descripcion" placeholder="Descripcion de la publicacion" class="border p-3 w-full rounded-lg @error('descripcion') border-red-500
            @enderror">{{old('username')}}</textarea>
            @error('descripcion')
                <p class="text-bold text-red-600">{{$message}} </p>
            @enderror
        </div>
        <div class="mb-5">
            <input type="hidden" name="imagen" value="{{old('imagen')}}">
            @error('imagen')
                <p class="text-bold text-red-600">{{$message}} </p>
            @enderror
        </div>
        <input type="submit" value="crear Publicacion" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
      </form>
    </div>
  </div>
@endsection
