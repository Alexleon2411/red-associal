@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{auth()->user()->username}}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{route('perfil.store')}}" method="POST" class="mt-10 md:mt-0" enctype="multipart/form-data">
                @csrf
                 <div  class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Username</label>
                    <input type="text" id="username" name="username" placeholder="Tu nombre de usuario" class="border p-3 w-full rounded-lg @error('username') border-red-500
                    @enderror" value="{{auth()->user()->username}}" accept=".jpg, .jpeg, .png ">
                    @error('username')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                 <div  class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="text" id="email" name="email" placeholder="Tu Email" class="border p-3 w-full rounded-lg @error('email') border-red-500
                    @enderror" value="{{auth()->user()->email}}" accept=".jpg, .jpeg, .png ">
                    @error('email')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                 <div  class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Contraseña</label>
                    <input type="text" id="password" name="password" placeholder="Antigua Contraseña" class="border p-3 w-full rounded-lg @error('password') border-red-500
                    @enderror"  accept=".jpg, .jpeg, .png ">
                    @error('password')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                 <div  class="mb-5">
                    <label for="newpassword" class="mb-2 block uppercase text-gray-500 font-bold">Nueva Contraseña</label>
                    <input type="text" id="newpassword" name="newpassword" placeholder="Nueva Contraseña" class="border p-3 w-full rounded-lg @error('newpassword') border-red-500
                    @enderror"  accept=".jpg, .jpeg, .png ">
                    @error('newpassword')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                 <div  class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">imagen Perfil</label>
                    <input type="file" id="imagen" name="imagen" placeholder="Tu nombre de usuario" class="border p-3 w-full rounded-lg"accept=".jpg, .jpeg, .png">
                </div>
                <input type="submit" value="Actualizar perfil" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
